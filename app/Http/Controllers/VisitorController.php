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

    // 2. Handle visitor form submission
    public function storeVisitor(Request $request)
    {
        $request->validate([
            // 🆕 RESTRUCTURED: Validating split fields matching advisor recommendations
            'first_name'       => 'required|string|max:100',
            'middle_name'      => 'nullable|string|max:100',
            'last_name'        => 'required|string|max:100',
            'id_number'        => 'nullable|string|max:50', 
            'contact_number'   => 'required|string|max:20',
            'purpose_of_visit' => 'required|string|max:255',
            
            // 🆕 FIXED FOR ADVISER: Specific targets are completely optional (nullable)
            'person_to_visit'  => 'nullable|string|max:255',
            'office_to_visit'  => 'nullable|string|max:255',
            
            // Vehicle choice inputs
            'vehicle_type'     => 'required|string|in:none,motorcycle,car',
            'vehicle_brand'    => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:50',
            'vehicle_model'    => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:50',
            'vehicle_plate'    => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:20',
            'vehicle_color'    => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:30',
        ]);

        // 1. Look up an existing profile across your split names database index paths
        $visitor = Visitor::where(function($query) use ($request) {
            if ($request->id_number) {
                $query->where('id_number', $request->id_number);
            } else {
                $query->where('first_name', $request->first_name)
                      ->where('last_name', $request->last_name)
                      ->where('contact_number', $request->contact_number);
            }
        })->first();

        // 2. If they exist, ensure their previous session isn't still active on campus
        if ($visitor && in_array($visitor->status, ['pending', 'checked_in'])) {
            return redirect()->back()->withErrors([
                'duplicate' => 'A visitor session under this identity is already active on campus.'
            ])->withInput();
        }

        $uniqueToken = Str::uuid()->toString();

        if ($visitor) {
            // 3a. PROFILE RECYCLING: Update the historical record with their fresh trip requirements
            $visitor->update([
                'purpose_of_visit' => $request->purpose_of_visit,
                'person_to_visit'  => $request->person_to_visit,
                'office_to_visit'  => $request->office_to_visit,
                'vehicle_type'     => $request->vehicle_type,
                'vehicle_brand'    => $request->vehicle_type === 'none' ? null : $request->vehicle_brand,
                'vehicle_model'    => $request->vehicle_type === 'none' ? null : $request->vehicle_model,
                'vehicle_plate'    => $request->vehicle_type === 'none' ? null : $request->vehicle_plate,
                'vehicle_color'    => $request->vehicle_type === 'none' ? null : $request->vehicle_color,
                'qr_code_token'    => $uniqueToken,
                'status'           => 'pending',
                'current_location' => 'Main Gate',
                'checked_in_at'    => null,
                'checked_out_at'   => null
            ]);
        } else {
            // 3b. NEW ENTRY: First time visitor onboarding scenario
            $idNumber = $request->id_number ?: 'GUEST-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            
            $visitor = Visitor::create([
                'first_name'       => $request->first_name,
                'middle_name'      => $request->middle_name,
                'last_name'        => $request->last_name,
                'id_number'        => $idNumber, 
                'contact_number'   => $request->contact_number,
                'purpose_of_visit' => $request->purpose_of_visit,
                'person_to_visit'  => $request->person_to_visit,
                'office_to_visit'  => $request->office_to_visit,
                'vehicle_type'     => $request->vehicle_type,
                'vehicle_brand'    => $request->vehicle_type === 'none' ? null : $request->vehicle_brand,
                'vehicle_model'    => $request->vehicle_type === 'none' ? null : $request->vehicle_model,
                'vehicle_plate'    => $request->vehicle_type === 'none' ? null : $request->vehicle_plate,
                'vehicle_color'    => $request->vehicle_type === 'none' ? null : $request->vehicle_color,
                'qr_code_token'    => $uniqueToken,
                'status'           => 'pending',
                'current_location' => 'Main Gate'
            ]);
        }

        // 4. TIMELINE ENTRY LOGGING: Record the pass generation action inside your movements relationship safely
        try {
            $visitor->movements()->create([
                'action_type' => 'PASS_GENERATED', 
                'location'    => 'Online Gateway',
                'remarks'     => 'New entry pass requested for: ' . $request->purpose_of_visit
            ]);
        } catch (\Exception $e) {
            // Log error internally if needed, fails gracefully so the user still gets their pass
        }

        // ✅ REDIRECT TO PERMANENT PASS HUB URL
        return redirect()->route('visitor.live.pass', ['token' => $visitor->qr_code_token]);
    }

    // 4. Show the Administration Log Dashboard Panel with Search and Analytics
    public function showAdminDashboard()
    {
        $allVisitors = Visitor::orderBy('created_at', 'desc')->paginate(15);
        
        $totalRegistered = Visitor::count();
        $currentlyInside = Visitor::where('status', 'checked_in')->count();
        $totalCheckedOut = Visitor::where('status', 'checked_out')->count();
        $totalPending     = Visitor::where('status', 'pending')->count();

                // 🆕 NEW ANALYTICS: Count vehicle metrics currently occupying campus space (Case-Insensitive)
        $vehiclesInside  = Visitor::where('status', 'checked_in')
            ->where(function($query) {
                $query->whereRaw('LOWER(vehicle_type) LIKE ?', ['%motorcycle%'])
                      ->orWhereRaw('LOWER(vehicle_type) LIKE ?', ['%car%'])
                      ->orWhereRaw('LOWER(vehicle_type) LIKE ?', ['%vehicle%'])
                      ->orWhereRaw('LOWER(vehicle_type) LIKE ?', ['%suv%']);
            })
            ->count();


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
            'vehiclesInside', // Passed directly to dashboard metric tiles
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

    // -----------------------------------------------------------------
    // 🆕 RETURNING VISITOR LOOKUP FUNCTIONS
    // -----------------------------------------------------------------

    // Render the dedicated lookup input card view
    public function showReissueForm()
    {
        return view('visitor-reissue');
    }

    // Search for existing ID, update their visit details, and reconstruct active QR pass token
    public function processReissue(Request $request)
    {
        // 1. Validate the incoming request fields (🆕 Configured with split destination trackers)
        $request->validate([
            'id_number'         => 'required|string',
            'purpose_of_visit'  => 'required|string|max:255',
            'person_to_visit'   => 'nullable|string|max:255',
            'office_to_visit'   => 'nullable|string|max:255',
            'vehicle_type'      => 'required|string|in:none,motorcycle,car',
            
            // Required only if the returning visitor declares a transport toggle update
            'vehicle_brand'     => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:50',
            'vehicle_model'     => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:50',
            'vehicle_plate'     => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:20',
            'vehicle_color'     => 'required_if:vehicle_type,motorcycle,car|nullable|string|max:30',
        ]);

        $userInput = trim($request->id_number);

        // 2. 🔄 SMART SEARCH: Query SQLite for an exact ID match OR flexible split name segments
        $visitor = Visitor::where('id_number', $userInput)
            ->orWhere('first_name', 'LIKE', '%' . $userInput . '%')
            ->orWhere('last_name', 'LIKE', '%' . $userInput . '%')
            ->first();

        if (!$visitor) {
            return back()->withErrors(['id_number' => 'No visitor record found matching that Name or ID Number.'])->withInput();
        }

        // 3. UPDATE the existing record with their fresh purpose and transport details
        $visitor->update([
            'purpose_of_visit' => $request->purpose_of_visit,
            'person_to_visit'  => $request->person_to_visit,
            'office_to_visit'  => $request->office_to_visit,
            'vehicle_type'     => $request->vehicle_type,
            'vehicle_brand'    => $request->vehicle_type === 'none' ? null : $request->vehicle_brand,
            'vehicle_model'    => $request->vehicle_type === 'none' ? null : $request->vehicle_model,
            'vehicle_plate'    => $request->vehicle_type === 'none' ? null : $request->vehicle_plate,
            'vehicle_color'    => $request->vehicle_type === 'none' ? null : $request->vehicle_color,
            'status'           => 'pending', // Reset status to pending for their new gate entry scan
        ]);

        // ✅ REDIRECT TO PERMANENT PASS HUB URL
        return redirect()->route('visitor.live.pass', ['token' => $visitor->qr_code_token]);
    }

    // 🆕 Express Pass Hub Profile Live View
    public function showLivePass($token)
    {
        $visitor = Visitor::where('qr_code_token', $token)->firstOrFail();
        
        $visitorFullName = trim($visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name);


        // Dynamically regenerate the matching live QR graphic matrix
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)
            ->color(15, 23, 42)
            ->margin(1)
            ->generate($visitor->qr_code_token);

        return view('qr-success', compact('visitor', 'qrCode'));
    }

   public function verifyScan(Request $request, $token, $location = 'Main Gate - Entrance')
{
    // 🧼 1. UN-ESCAPE DOUBLE ENCODING ARTIFACTS SCRIPT DECODER
    // Converts raw URL characters (like %20 or %2520) back into pure plain text spaces safely!
    $location = urldecode(urldecode($location));

    // Sanitize incoming tokens from accidental spaces or window duplication formats
    $cleanToken = trim(preg_replace('/\s*\(\d+\)\s*$/', '', $token));
    $visitor = Visitor::where('qr_code_token', $cleanToken)->first();

    if (!$visitor) {
        return view('scan-result', ['success' => false, 'title' => 'Invalid Pass', 'message' => 'Token not found.', 'visitor' => null]);
    }

    // Combined string variable to prevent Eloquent writing full_name back to SQLite tables
    $visitorFullName = trim($visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name);

    // -----------------------------------------------------------------
    // 🚪 A. MASTER MAIN GATE ENGINES (Triggers for ANY location string containing "Main Gate")
    // -----------------------------------------------------------------
    if (str_contains(strtolower($location), 'main gate')) {
        
        $isExplicitExit = (str_contains(strtolower($location), 'exit'));
        $isExplicitEntrance = (str_contains(strtolower($location), 'entrance'));
        
        // Normalize database status string to lowercase for safe comparisons
        $currentStatus = strtolower(trim($visitor->status));

        // 🚪 ENGINE DIRECTION A: PROCESS CHECK-OUT
        if ($isExplicitExit || ($currentStatus === 'checked_in' && !$isExplicitEntrance)) {
            
            // 🛑 CRITICAL SECURED LAYER: Throw error if they try scanning an already departed pass!
            if ($currentStatus === 'checked_out') {
                return view('scan-result', [
                    'success' => false, 
                    'title' => 'Pass Already Cleared', 
                    'message' => 'This visitor has already checked out of the university premises.', 
                    'visitor' => $visitor,
                    'full_name' => $visitorFullName
                ]);
            }

            // First time processing the exit:
            $visitor->update([
                'status' => 'checked_out',
                'current_location' => 'Left Campus',
                'checked_out_at' => now(),
            ]);
            
            $visitor->movements()->create([
                'action_type' => 'CHECKED_OUT', 
                'location_name' => 'Main Gate',
                'remarks' => 'Visitor successfully cleared campus exit.'
            ]);

            return view('scan-result', [
                'success' => true, 
                'title' => 'Check-Out Approved', 
                'message' => 'Visitor safely left the university premises.', 
                'visitor' => $visitor,
                'full_name' => $visitorFullName
            ]);
        }

        // 🚪 ENGINE DIRECTION B: PROCESS CHECK-IN
        else if (!$isExplicitExit) {
            
            // 🛑 CRITICAL SECURED LAYER: Block access if pass was burned by an exit event earlier today
            if ($currentStatus === 'checked_out') {
                return view('scan-result', [
                    'success' => false, 
                    'title' => 'Pass Expired', 
                    'message' => 'This QR pass has already been used for an exit and is now invalid.', 
                    'visitor' => $visitor,
                    'full_name' => $visitorFullName
                ]);
            }

            // If already checked in, just show the view (Refresh handle)
            if ($currentStatus === 'checked_in') {
                $primaryTarget = $visitor->office_to_visit ?: ($visitor->person_to_visit ?: 'General Premises');
                return view('scan-result', [
                    'success' => true, 
                    'title' => 'Access Granted', 
                    'message' => 'Welcome to campus! Initial target: ' . $primaryTarget, 
                    'visitor' => $visitor,
                    'full_name' => $visitorFullName
                ]);
            }

            // First time processing the entry:
            $visitor->update([
                'status' => 'checked_in',
                'current_location' => 'Main Gate',
                'checked_in_at' => $visitor->checked_in_at ?: now(),
            ]);
            
            $primaryTarget = $visitor->office_to_visit ?: ($visitor->person_to_visit ?: 'General Premises');

            $visitor->movements()->create([
                'action_type' => 'CHECKED_IN', 
                'location_name' => 'Main Gate',
                'remarks' => 'Access Granted. Initial target track: ' . $primaryTarget
            ]);

            return view('scan-result', [
                'success' => true, 
                'title' => 'Access Granted', 
                'message' => 'Welcome to campus! Initial target: ' . $primaryTarget, 
                'visitor' => $visitor,
                'full_name' => $visitorFullName
            ]);
        }
    }

    // ... (Your Inter-Office hops logic continues cleanly right below)



    // -----------------------------------------------------------------
    // 🏢 B. INTER-OFFICE HOPS TRACKING (Only runs if location does NOT mention Main Gate)
    // -----------------------------------------------------------------
    if ($visitor->status === 'checked_in') {
        
        // Scenario 2: Form parameter payload update if custom log legs are caught
        if ($request->has('new_purpose') && $request->filled('new_purpose')) {
            $visitor->update([
                'purpose_of_visit' => $request->input('new_purpose'),
                'office_to_visit'  => $location,
                'current_location' => $location
            ]);

            $visitor->movements()->create([
                'action_type' => 'TRACKED',
                'location_name' => $location,
                'remarks' => 'Leg purpose updated at scanner: ' . $request->input('new_purpose')
            ]);

            return view('scan-result', [
                'success' => true, 
                'title' => 'Purpose Logged', 
                'message' => "Hop purpose tracked at: {$location}.", 
                'visitor' => $visitor,
                'full_name' => $visitorFullName
            ]);
        }

        // Scenario 1 & 3: Standard or spontaneous un-declared office checklist loops
        $isSpontaneous = ($visitor->office_to_visit !== $location);
        $remarkMsg = $isSpontaneous ? 'Spontaneous deviation hop tracked at: ' . $location : 'Declared target destination checked.';
        
        $visitor->update([
            'current_location' => $location,
            'office_to_visit'  => $location 
        ]);
        
        $visitor->movements()->create([
            'action_type' => 'TRACKED',
            'location_name' => $location,
            'remarks' => $remarkMsg
        ]);
        
        return view('scan-result', [
            'success' => true, 
            'title' => 'Movement Logged', 
            'message' => "Visitor layout movement tracked at: {$location}.", 
            'visitor' => $visitor,
            'full_name' => $visitorFullName
        ]);
    }

    return redirect()->route('welcome');
}


public function expressLookup(Request $request)
{
    $queryStr = trim($request->input('search_query'));

    // Return empty array if input is too short to optimize database strain
    if (strlen($queryStr) < 2) {
        return response()->json([]);
    }

    // High utility query scanning registration keys or user names
    $visitors = Visitor::where('registration_id', 'LIKE', "%{$queryStr}%")
        ->orWhere('last_name', 'LIKE', "%{$queryStr}%")
        ->orWhere('qr_code_token', $queryStr)
        ->take(5) // Limit payload sizes for rapid interface snappiness
        ->get();

    // Map rows cleanly to drop unnecessary schema columns over transit pipelines
    $results = $visitors->map(function ($visitor) {
        return [
            'id' => $visitor->id,
            'registration_id' => $visitor->registration_id,
            'full_name' => trim("{$visitor->first_name} {$visitor->middle_name} {$visitor->last_name}"),
            'status' => strtoupper($visitor->status ?? 'PENDING'),
            'current_location' => $visitor->current_location ?? 'Not Entered',
            'history_count' => $visitor->movements()->count(),
        ];
});

    return response()->json($results);
}

}
