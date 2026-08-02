<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Visitor Registration</title>
    
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.55), rgba(15, 23, 42, 0.75)), 
                        url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRTfP7BXODGeokb1X0ptCOu7pzgqNM7WiMOlQstwV-uRJ0JJfloFcGW74M&s=10') no-repeat center center fixed; 
            background-size: cover;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 24px; 
            box-sizing: border-box;
            color: #f8fafc;
        }
        .card { 
            background: rgba(15, 23, 42, 0.65); 
            backdrop-filter: blur(12px) saturate(140%);
            -webkit-backdrop-filter: blur(12px) saturate(140%);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3); 
            width: 100%; 
            max-width: 520px; /* Slightly wider to give breathing room for 3-column names */
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-sizing: border-box;
        }
        .logo-circle {
            background-color: #ffffff; 
            width: 48px;
            height: 48px;
            border-radius: 14px; 
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        .logo-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 7px;
            box-sizing: border-box;
        }
        .logo-text {
            color: #0f172a;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
            margin-bottom: 32px;
        }
        h1 { 
            font-size: 22px; 
            color: #ffffff; 
            margin: 0; 
            font-weight: 700; 
            letter-spacing: -0.5px;
        }
        .subtitle { 
            font-size: 13px; 
            color: #cbd5e1; 
            margin: 6px 0 0 0; 
            font-weight: 400;
        }
        .header-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
            margin-bottom: 6px;
        }
        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            appearance: none;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.15s ease;
        }
        .map-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.28);
            transform: translateY(-1px);
        }
        .gateway-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            appearance: none;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #e2e8f0;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.15s ease;
        }
        .gateway-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
            color: #ffffff;
        }
        .verification-card {
            margin-bottom: 20px;
            padding: 22px;
            border-radius: 18px;
            background: rgba(30, 41, 59, 0.82);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        }
        .verification-card h3 {
            margin: 0 0 6px 0;
            font-size: 16px;
            color: #ffffff;
        }
        .verification-card p {
            margin: 0;
            color: #cbd5e1;
            font-size: 12px;
            line-height: 1.5;
        }
        .verification-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
        }
        .verification-full {
            margin-top: 12px;
        }
        .verification-upload {
            position: relative;
            border: 1px dashed rgba(248, 250, 252, 0.28);
            border-radius: 14px;
            padding: 18px;
            background: rgba(15, 23, 42, 0.55);
            overflow: hidden;
        }
        .verification-upload input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .verification-upload .upload-copy {
            text-align: center;
            color: #e2e8f0;
        }
        .verification-upload .upload-copy strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }
        .verification-upload .upload-copy span {
            font-size: 11px;
            color: #94a3b8;
        }
        .verification-preview {
            display: none;
            max-width: 100%;
            max-height: 180px;
            margin: 14px auto 0;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.22);
        }
        .verification-success {
            margin-bottom: 16px;
            padding: 14px 16px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #d1fae5;
            font-size: 13px;
        }
        .verification-lock {
            margin-top: 10px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #cbd5e1;
            font-size: 12px;
            line-height: 1.5;
        }
        .verification-divider {
            margin: 22px 0;
            border: 0;
            border-top: 1px solid rgba(148, 163, 184, 0.16);
        }
        .map-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(2, 6, 23, 0.72);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 50;
        }
        .map-modal.show {
            display: flex;
        }
        .map-modal-panel {
            width: min(960px, 100%);
            background: rgba(15, 23, 42, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
            overflow: hidden;
        }
        .map-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .map-modal-title {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
        }
        .map-modal-subtitle {
            margin: 4px 0 0;
            font-size: 12px;
            color: #cbd5e1;
        }
        .map-modal-close {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }
        .map-modal-close:hover {
            background: rgba(255, 255, 255, 0.14);
        }
        .map-frame-wrap {
            aspect-ratio: 16 / 10;
            width: 100%;
            background: rgba(15, 23, 42, 0.7);
        }
        .map-frame-wrap iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }
        .map-modal-footer {
            padding: 14px 18px 18px;
            font-size: 12px;
            color: #94a3b8;
        }
        .form-grid {
            display: flex;
            gap: 12px;
        }
        .form-group {
            margin-bottom: 20px;
            flex: 1;
        }
        label { 
            display: block; 
            font-size: 11px; 
            font-weight: 600; 
            color: #cbd5e1; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .optional-mark {
            font-size: 10px;
            color: #94a3b8;
            text-transform: lowercase;
            font-weight: 400;
        }
        input, select { 
            width: 100%; 
            height: 42px;
            padding: 0 14px; 
            border: 1px solid rgba(255, 255, 255, 0.2) !important; 
            border-radius: 8px; 
            font-size: 14px;
            color: #ffffff;
            background-color: rgba(15, 23, 42, 0.6);
            box-sizing: border-box;
            transition: all 0.15s ease;
            outline: none;
        }
        input:focus, select:focus {
            border-color: #ffffff; 
            background-color: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.15);
        }
        input::placeholder {
            color: #94a3b8;
            opacity: 0.8;
        }
        .field-hint {
            margin: 8px 0 0;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.45;
        }
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://w3.org' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }
        select option { color: #0f172a; background-color: #ffffff; }
        .submit-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: #ffffff; color: #0f172a; height: 44px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; margin-top: 12px; transition: all 0.15s ease; box-sizing: border-box; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2); }
        .submit-btn:hover { background: #f1f5f9; transform: translateY(-1px); }
        .submit-btn:disabled { background: #475569; color: #94a3b8; cursor: not-allowed; }
        .login-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: rgba(255, 255, 255, 0.05); color: #cbd5e1; height: 44px; border-radius: 8px; font-weight: 600; font-size: 14px; border: 1px solid rgba(255, 255, 255, 0.2); cursor: pointer; margin-top: 10px; text-decoration: none; transition: all 0.15s ease; box-sizing: border-box; }
        .login-btn:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; border-color: rgba(255, 255, 255, 0.4); }

        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; cursor: pointer; user-select: none; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; accent-color: #ffffff; margin: 0; }
        .checkbox-label { font-size: 13px; font-weight: 500; color: #f8fafc; }
        .vehicle-details-container { display: none; opacity: 0; max-height: 0; overflow: hidden; transition: all 0.3s ease-in-out; }
        .vehicle-details-container.show { display: block; opacity: 1; max-height: 400px; margin-bottom: 8px; }
        @media (max-width: 640px) {
            .verification-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="card">
        @php
            $brandLogo = trim((string) env('APP_LOGO', ''));
            $brandLogoUrl = null;
            if ($brandLogo) {
                if (preg_match('/^https?:\/\//i', $brandLogo)) {
                    $brandLogoUrl = $brandLogo;
                } elseif (str_starts_with($brandLogo, 'public/')) {
                    $brandLogoUrl = asset(substr($brandLogo, 7));
                } elseif (str_starts_with($brandLogo, '/')) {
                    $brandLogoUrl = asset(ltrim($brandLogo, '/'));
                } else {
                    $brandLogoUrl = asset($brandLogo);
                }
            }
            if (! $brandLogoUrl && file_exists(public_path('images/evsu-logo.png'))) {
                $brandLogoUrl = asset('images/evsu-logo.png');
            }
        @endphp
        @if ($errors->any())
            <div style="background-color: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 14px; border-radius: 8px; font-size: 13px; font-weight: 500; margin-bottom: 20px; text-align: left;">
                <strong style="display:block; margin-bottom: 4px;">Form Submission Failed:</strong>
                <ul style="margin: 0; padding-left: 18px; line-height: 1.5;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="verification-success">{{ session('success') }}</div>
        @endif

        @if(!($idVerified ?? false))
            <div class="verification-card">
                <h3>Step 1: Verify Your Identity</h3>
                <p>Upload a valid ID first. Once verified, the registration form below will unlock and your name will be prefilled.</p>

                <form action="{{ route('visitor.verify.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="verification-grid">
                        <div>
                            <label>First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                        </div>
                        <div>
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                        </div>
                    </div>

                    <div class="verification-full">
                            <label>Select ID Type</label>
                        <select name="id_type" required>
                            <option value="" disabled selected>-- Choose ID Type --</option>
                            <option value="national_id">Philippine National ID (PhilID)</option>
                            <option value="drivers_license">LTO Driver's License</option>
                            <option value="umpid">UMID / SSS Card</option>
                            <option value="passport">Philippine Passport</option>
                                <option value="evsu_id">EVSU School ID / University ID</option>
                        </select>
                    </div>

                    <div class="verification-full">
                        <label>Upload Valid ID Document Image</label>
                        <div class="verification-upload">
                            <input type="file" name="id_image" id="id_image" required accept="image/png, image/jpeg" onchange="updateIdPreview(this)">
                            <div id="verification-upload-prompt" class="upload-copy">
                                <strong>Click or drag an ID image here</strong>
                                <span>JPEG or PNG up to 5MB</span>
                            </div>
                            <img id="verification-image-preview" class="verification-preview" alt="Uploaded ID preview">
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" style="margin-top: 14px;">Scan & Verify Identity</button>
                </form>
            </div>
            <hr class="verification-divider">
        @else
            <div class="verification-card">
                <h3>Identity Verified</h3>
                <p>Your ID has been checked successfully. Continue with the visitor registration form below.</p>
                <div class="verification-lock">
                    Verified name: <strong>{{ $verifiedFirstName }} {{ $verifiedLastName }}</strong>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 12px;">
                    <a href="{{ route('visitor.verify.reset') }}" class="login-btn" style="margin-top: 0; width: 100%; background: rgba(34, 197, 94, 0.12); color: #d1fae5; border-color: rgba(34, 197, 94, 0.3);">
                        Register New Visitor
                    </a>
                </div>
            </div>
        @endif

        <div class="text-center">
            <div class="logo-circle">
                @if ($brandLogoUrl)
                    <img src="{{ $brandLogoUrl }}" alt="{{ env('APP_NAME', 'State University') }} logo" class="logo-image">
                @else
                    <span class="logo-text">{{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}</span>
                @endif
            </div>
            <h1>{{ env('APP_NAME', 'State University') }}</h1>
            <p class="subtitle">{{ env('SYSTEM_DEPARTMENT', 'Visitor Management Control') }} Gateway</p>
            <div class="header-actions">
                <button
                    type="button"
                    id="view_map_btn"
                    class="map-btn"
                >
                    <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 1 1 16 0Z"></path><circle cx="13" cy="10" r="3"></circle></svg>
                    View Campus Map
                </button>

                <a href="{{ route('welcome') }}" class="gateway-btn">
                    <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"></path><path d="M8 5l-5 7 5 7"></path></svg>
                    Main Gateway
                </a>
            </div>
        </div>

        @if($idVerified ?? false)
        <form action="{{ route('visitor.store') }}" method="POST" onsubmit="this.querySelector('.submit-btn').disabled=true; this.querySelector('.submit-btn').innerText='Generating Pass...';">
            @csrf 

            <!-- 🆕 NEW STRUCTURE: 3-Column Split Name Fields -->
            <div class="form-grid">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="John" value="{{ old('first_name', $verifiedFirstName ?? '') }}" required autocomplete="off" {{ ($idVerified ?? false) ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label>Middle Name <span class="optional-mark">(optional)</span></label>
                    <input type="text" name="middle_name" placeholder="Doe" value="{{ old('middle_name') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Smith" value="{{ old('last_name', $verifiedLastName ?? '') }}" required autocomplete="off" {{ ($idVerified ?? false) ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" placeholder="09123456789" value="{{ old('contact_number') }}" required autocomplete="off">
                </div>
                 
                <div class="form-group">
                    <label for="id_number">ID Number <span class="optional-mark">(optional)</span></label>
                    <input type="text" name="id_number" id="id_number" placeholder="e.g., 2026-12345" value="{{ old('id_number') }}" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label for="purpose_of_visit">Purpose of Visit</label>
                <input type="text" id="purpose_of_visit" name="purpose_of_visit" list="campus_visit_places" placeholder="e.g., Registrar, Library, Academic Building" value="{{ old('purpose_of_visit') }}" required autocomplete="off">
                <datalist id="campus_visit_places">
                    @foreach($campusLocations as $location)
                        <option value="{{ $location->name }}">
                    @endforeach
                </datalist>
                <p class="field-hint">Choose a campus destination from the list or type another purpose of visit.</p>
            </div>

            <!-- 🆕 NEW STRUCTURE: Person and Office to Visit side-by-side, both optional -->
            <div class="form-grid">
                <div class="form-group">
                    <label>Person to Visit <span class="optional-mark">(optional)</span></label>
                    <input type="text" name="person_to_visit" placeholder="e.g., Dr. Smith" value="{{ old('person_to_visit') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Office to Visit <span class="optional-mark">(optional)</span></label>
                    <input type="text" name="office_to_visit" placeholder="e.g., Registrar Office" value="{{ old('office_to_visit') }}" autocomplete="off">
                </div>
            </div>

                        <!-- Hidden field to pass 'none' explicitly when checkbox is turned off -->
            <input type="hidden" name="vehicle_type" id="vehicle_type_hidden" value="none">

            <!-- TOGGLE CHECKBOX TRIGGER -->
            <label class="checkbox-group">
                <input type="checkbox" id="has_vehicle_toggle" {{ old('has_vehicle_toggle') || in_array(old('vehicle_type'), ['motorcycle', 'car']) ? 'checked' : '' }}>
                <span class="checkbox-label">Are you bringing a vehicle?</span>
            </label>

            <!-- DYNAMIC VEHICLE SPECIFICATIONS CONTAINER -->
            <div id="vehicle_details" class="vehicle-details-container {{ old('has_vehicle_toggle') || in_array(old('vehicle_type'), ['motorcycle', 'car']) ? 'show' : '' }}">
                
                <div class="form-group">
                    <label for="vehicle_type">Vehicle Type</label>
                    <select id="vehicle_type_select">
                        <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                        <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Brand Name</label>
                        <input type="text" name="vehicle_brand" id="vehicle_brand" placeholder="e.g., Toyota, Honda" value="{{ old('vehicle_brand') }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" name="vehicle_model" id="vehicle_model" placeholder="e.g., Vios, Click" value="{{ old('vehicle_model') }}" autocomplete="off">
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Plate Number</label>
                        <input type="text" name="vehicle_plate" id="vehicle_plate" placeholder="e.g., ABC 1234" value="{{ old('vehicle_plate') }}" autocomplete="off" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input type="text" name="vehicle_color" id="vehicle_color" placeholder="e.g., Black, White" value="{{ old('vehicle_color') }}" autocomplete="off">
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><path d="M14 14h7v7h-7z"></path></svg>
                Generate Visitor QR Pass
            </button>

            <!-- LOGIN BUTTON LINK FOR EXISTING USERS -->
            <a href="{{ route('visitor.reissue') }}" class="login-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                Existing User? Login Here
            </a>

            @if(!($idVerified ?? false))
                <div class="verification-lock">
                    You can verify your identity above or continue using the existing visitor form if you already have a verified session.
                </div>
            @endif

            <!-- Back to Public Home Gateway Link Route -->
            <a href="{{ route('welcome') }}" style="display: block; text-align: center; margin-top: 16px; font-size: 12px; color: #94a3b8; text-decoration: none; transition: color 0.15s ease; font-weight: 500;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">
                ← Back to Welcome Gateway
            </a>
        </form>
        @else
            <div class="verification-lock" style="margin-top: 20px; text-align: center;">
                Complete the ID verification step above to unlock the visitor registration form.
            </div>
        @endif
    </div>

    <div id="map_modal" class="map-modal" aria-hidden="true">
        <div class="map-modal-panel" role="dialog" aria-modal="true" aria-labelledby="map_modal_title">
            <div class="map-modal-header">
                <div>
                    <h2 id="map_modal_title" class="map-modal-title">Campus Map Preview</h2>
                    <p class="map-modal-subtitle">Eastern Visayas State University, Tacloban City, Leyte</p>
                </div>
                <button type="button" id="close_map_btn" class="map-modal-close" aria-label="Close map modal">
                    <svg xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="map-frame-wrap">
                <iframe
                    src="https://www.google.com/maps?q=Eastern+Visayas+State+University,+Tacloban+City,+Leyte&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Eastern Visayas State University map"
                ></iframe>
            </div>
            <div class="map-modal-footer">
                Use this map to help visitors find the campus before completing their registration.
            </div>
        </div>
    </div>

    <script>
        function updateIdPreview(input) {
            const preview = document.getElementById('verification-image-preview');
            const prompt = document.getElementById('verification-upload-prompt');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    prompt.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Enforce alignment consistency across the registration form
        const registrationIdInput = document.getElementById('id_number');
        if (registrationIdInput) {
            const registerForm = registrationIdInput.closest('form');
            const regSubmitBtn = registerForm ? registerForm.querySelector('.submit-btn') : null;

            const strictFormatRegex = /^\d{2,4}-\d{3,10}$/;

            registrationIdInput.addEventListener('input', function(e) {
                let val = e.target.value.replace(/[^0-9a-zA-Z-]/g, '');
                if (val.length > 4 && !val.includes('-')) {
                    val = val.slice(0, 4) + '-' + val.slice(4);
                }
                e.target.value = val;

                if (regSubmitBtn) {
                    if (strictFormatRegex.test(val)) {
                        registrationIdInput.style.borderColor = 'rgba(255, 255, 255, 0.4)';
                        regSubmitBtn.disabled = false;
                    } else {
                        if (val.length > 0) {
                            registrationIdInput.style.borderColor = '#ef4444';
                            regSubmitBtn.disabled = true;
                        } else {
                            registrationIdInput.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                            regSubmitBtn.disabled = false;
                        }
                    }
                }
            });
        }

        // JAVASCRIPT LOGIC TO SYNC CHECKBOX TOGGLE & REQUIRED ATTRIBUTES
        const vehicleToggle = document.getElementById('has_vehicle_toggle');
        const vehicleDetails = document.getElementById('vehicle_details');
        const vehicleTypeHidden = document.getElementById('vehicle_type_hidden');
        const vehicleTypeSelect = document.getElementById('vehicle_type_select');
        
        const vehicleInputs = [
            document.getElementById('vehicle_brand'),
            document.getElementById('vehicle_model'),
            document.getElementById('vehicle_plate'),
            document.getElementById('vehicle_color')
        ];

        if (vehicleToggle && vehicleDetails && vehicleTypeHidden && vehicleTypeSelect) {
            function handleVehicleToggle() {
                if (vehicleToggle.checked) {
                    vehicleDetails.classList.add('show');
                    vehicleTypeHidden.name = ""; 
                    vehicleTypeSelect.name = "vehicle_type";
                    vehicleInputs.forEach(input => input.required = true);
                } else {
                    vehicleDetails.classList.remove('show');
                    vehicleTypeSelect.name = "";
                    vehicleTypeHidden.name = "vehicle_type";
                    vehicleTypeHidden.value = "none";
                    vehicleInputs.forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                }
            }

            vehicleToggle.addEventListener('change', handleVehicleToggle);
            window.addEventListener('DOMContentLoaded', handleVehicleToggle);
        }

        const mapModal = document.getElementById('map_modal');
        const viewMapBtn = document.getElementById('view_map_btn');
        const closeMapBtn = document.getElementById('close_map_btn');

        function openMapModal() {
            mapModal.classList.add('show');
            mapModal.setAttribute('aria-hidden', 'false');
            closeMapBtn.focus();
        }

        function closeMapModal() {
            mapModal.classList.remove('show');
            mapModal.setAttribute('aria-hidden', 'true');
            viewMapBtn.focus();
        }

        viewMapBtn.addEventListener('click', openMapModal);
        closeMapBtn.addEventListener('click', closeMapModal);
        mapModal.addEventListener('click', function(event) {
            if (event.target === mapModal) {
                closeMapModal();
            }
        });
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && mapModal.classList.contains('show')) {
                closeMapModal();
            }
        });
    </script>

</body>
</html>
