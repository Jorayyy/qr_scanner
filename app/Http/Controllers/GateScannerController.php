<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GateScannerController extends Controller
{
    /**
     * Automated Check-In / Check-Out Lifecycle Controller
     * Handles any possible generated QR pass token dynamically.
     */
    public function processPassTransaction($token, $location)
    {
        // Normalize and clean incoming dynamic scan data parameters
        $cleanToken = trim($token);
        $stationLocation = trim($location);
        $normalizedStation = strtolower($stationLocation);

        Log::info("Gate Terminal Execution Sequence: Evaluating dynamic token input [{$cleanToken}] at gate location [{$normalizedStation}]");

        // 1. Locate the active record tracking row inside your database table dynamically
        // Searches for whichever code was transmitted by the camera stream
        $visitorRecord = DB::table('visitors')
                           ->where('qr_token', $cleanToken)
                           ->first();

        // 2. ABSOLUTE CRITICAL VALIDATION CHECK
        // If the token does not exist in the database, stop immediately and return an error
        if (!$visitorRecord) {
            Log::warning("Security Alert Matrix: Unregistered terminal sequence attempted: [{$cleanToken}]");
            return redirect()->back()->with('error', "Invalid Pass: The token code structure [{$cleanToken}] is unrecognized by campus registries.");
        }

        // 3. DYNAMIC LIFECYCLE TOGGLE PROCESSING CORE:
        // Reads the current state row from the database directly, with NO hardcoded strings.
        $currentStatus = strtolower(trim($visitorRecord->status ?? 'pending'));
        $isEntranceStation = str_contains($normalizedStation, 'entrance') || str_contains($normalizedStation, 'main gate');
        $isExitStation = str_contains($normalizedStation, 'exit');

        if ($currentStatus === 'checked_in') {
            if ($isEntranceStation && ! $isExitStation) {
                Log::warning("Duplicate entrance scan blocked for visitor [{$visitorRecord->id}] at [{$normalizedStation}]");
                return redirect()->back()->with('error', "This pass is already checked in. Use the exit gate to check out.");
            }

            
            // TRANSACTION: Execute the Check-Out update mutation immediately
            DB::table('visitors')
                ->where('id', $visitorRecord->id)
                ->update([
                    'status' => 'checked_out',
                    'current_location' => 'Outside Campus',
                    'updated_at' => now()
                ]);

            // LEDGER: Append a tracking line to your historical transaction data logs
            DB::table('visitor_logs')->insert([
                'visitor_id' => $visitorRecord->id,
                'action'     => 'Checked Out',
                'station'    => $normalizedStation,
                'logged_at'  => now()
            ]);

            return redirect()->back()->with('success', "Check-Out Verified successfully for {$visitorRecord->name}. Gate clears.");
            
        } else {

            if (! $isEntranceStation && ! $isExitStation) {
                return redirect()->back()->with('error', 'Scan at the entrance or exit gate to process this pass.');
            }
            
            // TRANSACTION: If they aren't checked in yet, process a fresh Check-In update pass instead
            DB::table('visitors')
                ->where('id', $visitorRecord->id)
                ->update([
                    'status'           => 'checked_in',
                    'current_location' => $stationLocation,
                    'updated_at'       => now()
                ]);

            // LEDGER: Log the entry action
            DB::table('visitor_logs')->insert([
                'visitor_id' => $visitorRecord->id,
                'action'     => 'Checked In',
                'station'    => $normalizedStation,
                'logged_at'  => now()
            ]);

            return redirect()->back()->with('success', "Check-In Confirmed for {$visitorRecord->name}. Terminal clear.");
        }
    }
}
