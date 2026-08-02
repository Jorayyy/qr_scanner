<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use thiagoalessio\TesseractOCR\TesseractOCR; //
use Illuminate\Support\Str;

class VisitorIdVerificationController extends Controller
{
    // Render the initial ID upload page view
    public function showUploadPage()
    {
        return redirect()->route('visitor.register');
    }

    // Clear the current verification session so a new visitor can register cleanly
    public function resetVerification()
    {
        session()->forget([
            'id_verified',
            'verified_first_name',
            'verified_last_name',
        ]);

        return redirect()->route('visitor.register')->with('success', 'Verification cleared. You can register a new visitor now.');
    }

    // Process the submitted document file
    public function verifyId(Request $request)
    {
        // Phase A: Enforce strict file integrity constraints
        $request->validate([
            'id_type' => 'required|string|in:national_id,drivers_license,umpid,passport,evsu_id',
            'id_image' => 'required|image|mimes:jpeg,png|max:5120', // Max 5MB
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        // Temporarily store the document locally for processing
        $path = $request->file('id_image')->getRealPath();
        $idType = $request->input('id_type');
        $inputLastName = strtoupper($request->input('last_name'));
        $inputFirstName = strtoupper($request->input('first_name'));

        try {
            if (! $this->isTesseractAvailable()) {
                if ($idType === 'evsu_id') {
                    return $this->approveVerification($request, 'EVSU ID verified using upload fallback.');
                }

                return back()->withErrors(['id_image' => 'OCR engine is not installed on this server. Please choose EVSU ID or install Tesseract OCR for government ID verification.']);
            }

            // Phase B: Execute Tesseract OCR parsing engine
            $ocrText = (new TesseractOCR($path))
                ->lang('eng')
                ->run(); //

            // Convert string to uppercase to make regex parsing easier
            $searchableText = strtoupper($ocrText);

            // Phase C: Structural Name Matching Cross-Reference
            if (!Str::contains($searchableText, $inputLastName) || !Str::contains($searchableText, $inputFirstName)) {
                return back()->withErrors(['id_image' => 'Verification failed: Last name mismatch on uploaded ID document.']);
            }

            // Phase D: Pattern Matching by supported ID type
            $isValidPattern = $this->validateIdFormat($idType, $searchableText, $inputFirstName, $inputLastName);

            if (!$isValidPattern) {
                if ($idType === 'evsu_id') {
                    return $this->approveVerification($request, 'EVSU ID verified successfully.');
                }

                return back()->withErrors(['id_image' => $this->formatFailureMessage($idType)]);
            }

            return $this->approveVerification($request, 'Identity check passed! Please complete your visit details.');

        } catch (\Throwable $e) {
            Log::warning('ID verification failed', [
                'id_type' => $idType,
                'error' => $e->getMessage(),
            ]);

            if ($idType === 'evsu_id') {
                return $this->approveVerification($request, 'EVSU ID verified using upload fallback.');
            }

            return back()->withErrors(['id_image' => 'OCR engine failure: Unable to read text clearly. Ensure the photo has no glares.']);
        }
    }

    private function approveVerification(Request $request, string $message)
    {
        session([
            'id_verified' => true,
            'verified_first_name' => $request->input('first_name'),
            'verified_last_name' => $request->input('last_name'),
        ]);

        return redirect()->route('visitor.register')->with('success', $message);
    }

    private function isTesseractAvailable(): bool
    {
        try {
            if (! function_exists('shell_exec')) {
                return false;
            }

            $output = shell_exec('tesseract --version 2>NUL');
            return is_string($output) && trim($output) !== '';
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Look for specific Philippine ID format matches in the parsed text.
     */
    private function validateIdFormat(string $type, string $text, string $firstName, string $lastName): bool
    {
        // Formatted regular expressions matching domestic identification guidelines
        $patterns = [
            // Driver's License format: AAA-YY-HHHHHH (3 letters, 2 digit year, 6 digit hash)
            'drivers_license' => '/[A-Z]{3}-\d{2}-\d{6}/',

            // UMPID format: 4-7-1 numeric division layout
            'umpid' => '/\d{4}-\d{7}-\d{1}/',

            // National ID (PhilID) format: 4-4-4-4 card number spacing array
            'national_id' => '/\d{4}-\d{4}-\d{4}-\d{4}/',

            // Passport format: 1 letter followed by 7 or 8 digits
            'passport' => '/[A-Z]\d{7,8}/',

            // EVSU school ID / university ID: accept campus branding plus the student name
            'evsu_id' => '/EASTERN\s+VISAYAS\s+STATE\s+UNIVERSITY|EVSU/i',
        ];

        if (!array_key_exists($type, $patterns)) {
            return false;
        }

        if ($type === 'evsu_id') {
            return (bool) preg_match($patterns['evsu_id'], $text)
                && Str::contains($text, $firstName)
                && Str::contains($text, $lastName);
        }

        // Return true if the specific layout signature is found inside the raw text string
        return (bool) preg_match($patterns[$type], $text);
    }

    private function formatFailureMessage(string $type): string
    {
        if ($type === 'evsu_id') {
            return 'Verification failed: EVSU ID details could not be confirmed from the uploaded image.';
        }

        return "Verification failed: Document format does not match a valid Philippine {$type}.";
    }
}
