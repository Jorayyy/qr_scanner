<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\SimpleQR;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // ⭐ FIXED: Moved to top
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VisitorController extends Controller
{
    // 1. Show the registration form page
    public function showRegisterForm()
    {
        return view('register');
    }

    // 2. Handle visitor form submission and generate pass data matrix
    public function storeVisitor(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'contact_number' => 'required|string|max:20',
            'purpose_of_visit' => 'required|string|max:255',
            'person_to_visit' => 'required|string|max:255',
        ]);

        $uniqueToken = Str::uuid()->toString();

        $visitor = Visitor::create([
            'full_name' => $request->full_name,
            'id_number' => $request->id_number,
            'contact_number' => $request->contact_number,
            'purpose_of_visit' => $request->purpose_of_visit,
            'person_to_visit' => $request->person_to_visit,
            'qr_code_token' => $uniqueToken,
            'status' => 'pending'
        ]);

        $qrCode = QrCode::size(220)
            ->color(15, 23, 42)
            ->margin(1)
            ->generate($visitor->qr_code_token);

        return view('qr-success', compact('visitor', 'qrCode'));
    }

    // 3. Handle Campus Scans and Multi-Office Department Tracking Logic
    public function verifyScan($token, $location = 'Main Gate')
    {
        $visitor = Visitor::where('qr_code_token', $token)->first();

        if (!$visitor) {
            return view('scan-result', ['success' => false, 'title' => 'Invalid Pass', 'message' => 'Token not found.', 'visitor' => null]);
        }

        if ($visitor->status === 'checked_out') {
            return view('scan-result', ['success' => false, 'title' => 'Pass Expired', 'message' => 'Visitor has already left campus.', 'visitor' => $visitor]);
        }

        // ACTION A: Checking out at the front gates
        if ($visitor->status === 'checked_in' && $location === 'Main Gate') {
            $visitor->update([
                'status' => 'checked_out',
                'current_location' => 'Left Campus',
                'checked_out_at' => now(),
            ]);
            
            \App\Models\Movement::create(['visitor_id' => $visitor->id, 'location_name' => 'Left Campus']);

            return view('scan-result', ['success' => true, 'title' => 'Check-Out Approved', 'message' => 'Visitor has left the university.', 'visitor' => $visitor]);
        }

        // ACTION B: Inter-office department tracking jump
        if ($visitor->status === 'checked_in' && $location !== 'Main Gate') {
            $visitor->update(['current_location' => $location]);
            
            \App\Models\Movement::create(['visitor_id' => $visitor->id, 'location_name' => $location]);

            return view('scan-result', ['success' => true, 'title' => 'Location Tracked', 'message' => "Visitor layout movement successfully tracked at: {$location}.", 'visitor' => $visitor]);
        }

        // ACTION C: Primary check-in at the gate
        $visitor->update([
            'status' => 'checked_in',
            'current_location' => 'Main Gate',
            'checked_in_at' => now(),
        ]);
        
        \App\Models\Movement::create(['visitor_id' => $visitor->id, 'location_name' => 'Main Gate (Entry)']);

        return view('scan-result', ['success' => true, 'title' => 'Access Granted', 'message' => 'Welcome to campus!', 'visitor' => $visitor]);
    }

    // 4. Show the Administration Log Dashboard Panel with Search and Analytics
    public function showAdminDashboard()
    {
        $allVisitors = Visitor::orderBy('created_at', 'desc')->get();
        
        $totalRegistered = $allVisitors->count();
        $currentlyInside = Visitor::where('status', 'checked_in')->count();
        $totalCheckedOut = Visitor::where('status', 'checked_out')->count();
        $totalPending = Visitor::where('status', 'pending')->count();

        $dailyLogs = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(7)
            ->get();

        $chartLabels = $dailyLogs->pluck('date')->toArray();
        $chartData = $dailyLogs->pluck('count')->toArray();

        return view('admin-dashboard', compact(
            'allVisitors', 
            'totalRegistered', 
            'currentlyInside', 
            'totalCheckedOut',
            'totalPending',
            'chartLabels',
            'chartData'
        ));
    }

    // Show the Secure Login Page
    public function showLoginForm()
    {
        return view('admin-login');
    }

    // Process Login Request
    public function processLogin(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withInput()->with('error', 'The provided security credentials do not match our records.');
    }

    // Process Logout Request
    public function processLogout(Request $request)
    {
        Auth::logout(); // ⭐ FIXED: Properly clear standard Laravel Auth session guard data
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
    }

    // 5. Delete a specific visitor record permanently
    public function destroyVisitor($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->movements()->delete(); 
        $visitor->delete();

        return back()->with('success', 'Visitor record deleted successfully!');
    }
}
