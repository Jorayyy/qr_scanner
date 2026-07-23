<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Express Pass Lookup</title>
    
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            /* 🆕 UPDATED: Uses your exact campus photo link with a crisp layout overlay mask */
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
            /* 🆕 UPDATED: Premium glass container matching the registration form */
            background: rgba(15, 23, 42, 0.65); 
            backdrop-filter: blur(12px) saturate(140%);
            -webkit-backdrop-filter: blur(12px) saturate(140%);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3); 
            width: 100%; 
            max-width: 480px; 
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
        .logo-text {
            color: #0f172a;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
            margin-bottom: 24px;
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
        
        /* Professional Warning Box Tuning */
        .warning-banner {
            background-color: rgba(234, 179, 8, 0.15);
            border: 1px solid rgba(234, 179, 8, 0.3);
            color: #fef08a;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .form-grid {
            display: flex;
            gap: 16px;
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
        .hint-text {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 4px;
            display: block;
        }

        /* Dark translucent field styles */
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
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://w3.org' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }
        select option {
            color: #0f172a; 
            background-color: #ffffff;
        }

        .submit-btn { 
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%; 
            background: #ffffff; 
            color: #0f172a; 
            height: 44px;
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 14px; 
            border: none; 
            cursor: pointer; 
            margin-top: 8px;
            transition: all 0.15s ease;
            box-sizing: border-box;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }
        .submit-btn:hover { 
            background: #f1f5f9; 
            transform: translateY(-1px);
        }
        .back-btn {
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%; 
            background: rgba(255, 255, 255, 0.05); 
            color: #cbd5e1; 
            height: 44px;
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 14px; 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            cursor: pointer; 
            margin-top: 10px;
            text-decoration: none; 
            transition: all 0.15s ease;
            box-sizing: border-box;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* 🆕 NEW STYLES: Custom Form Checkbox Layout & Hidden Container */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            cursor: pointer;
            user-select: none;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #ffffff;
            margin: 0;
        }
        .checkbox-label {
            font-size: 13px;
            font-weight: 500;
            color: #f8fafc;
            text-transform: none;
            letter-spacing: normal;
        }
        .vehicle-details-container {
            display: none;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }
        .vehicle-details-container.show {
            display: block;
            opacity: 1;
            max-height: 400px;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

<div class="card">
        <div class="text-center">
            <div class="logo-circle">
                <span class="logo-text">
                    {{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}
                </span>
            </div>
            <h1>Express Pass Lookup</h1>
            <p class="subtitle">Provide your ID and current visiting purpose to refresh your pass.</p>
        </div>

        <!-- NEW DYNAMIC WARNING BANNER FROM GLASSMORPHISM SYSTEM -->
        <div class="warning-banner">
            ⚠️ <strong>Note:</strong> Outside guests/parents without a school ID must register as a new visitor.
        </div>

        @if ($errors->any())
            <div class="error-msg" id="serverError" style="background-color: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: left;">
                <ul style="margin: 0; padding-left: 16px; line-height: 1.4;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('visitor.reissue.submit') }}" method="POST" id="lookupForm" onsubmit="this.querySelector('.submit-btn').disabled=true; this.querySelector('.submit-btn').innerText='Generating Express Pass...';">
            @csrf 
            
            <div class="form-group">
                <label>Your Registered Name / ID Number</label>
                <input type="text" name="id_number" id="id_number" placeholder="Enter your Registered Name or ID" value="{{ old('id_number') }}" required autocomplete="off" maxlength="50">
                <span class="hint-text" id="validationHint">Enter the exact name or ID number you used when you registered.</span>
            </div>

            <div class="form-group">
                <label>New Purpose of Visit</label>
                <input type="text" name="purpose_of_visit" placeholder="e.g., Registrar, Submission, Meeting" value="{{ old('purpose_of_visit') }}" required autocomplete="off">
            </div>

            <!-- 🆕 NEW STRUCTURE: Person and Office to Visit fields separated side-by-side, both fully optional -->
            <div class="form-grid">
                <div class="form-group">
                    <label>New Person to Visit <span class="optional-mark">(optional)</span></label>
                    <input type="text" name="person_to_visit" placeholder="e.g., Dr. Smith" value="{{ old('person_to_visit') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>New Office to Visit <span class="optional-mark">(optional)</span></label>
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

            <button type="submit" class="submit-btn" id="submitBtn">
                <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                Generate Express Pass
            </button>
            <a href="{{ route('visitor.register') }}" class="back-btn">New Visitor Registration</a>
        </form>
    </div>


        <script>
        const idInput = document.getElementById('id_number');
        const submitBtn = document.getElementById('submitBtn');
        const serverError = document.getElementById('serverError');

        // Listens to field length to manage button lockout and clear server alerts
        idInput.addEventListener('input', function(e) {
            const value = e.target.value.trim();

            if (serverError) serverError.style.display = 'none';

            if (value.length > 0) {
                idInput.style.borderColor = 'rgba(255, 255, 255, 0.4)';
                submitBtn.disabled = false;
            } else {
                idInput.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                submitBtn.disabled = true;
            }
        });

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

        function handleVehicleToggle() {
            if (vehicleToggle.checked) {
                // Open container smoothly
                vehicleDetails.classList.add('show');
                
                // Map select element back to active hidden submission parameter name
                vehicleTypeHidden.name = ""; 
                vehicleTypeSelect.name = "vehicle_type";
                
                // Apply strict mandatory requirements
                vehicleInputs.forEach(input => input.required = true);
            } else {
                // Hide dynamic container block
                vehicleDetails.classList.remove('show');
                
                // Restore backup fallback input value back to 'none' for Pedestrians
                vehicleTypeSelect.name = "";
                vehicleTypeHidden.name = "vehicle_type";
                vehicleTypeHidden.value = "none";
                
                // Erase values & eliminate HTML constraint loops
                vehicleInputs.forEach(input => {
                    input.required = false;
                    input.value = '';
                });
            }
        }

        // Run initial input validation verification on first render block
        function initializeFormVerification() {
            if (idInput.value.trim().length > 0) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
            handleVehicleToggle();
        }

        vehicleToggle.addEventListener('change', handleVehicleToggle);
        window.addEventListener('DOMContentLoaded', initializeFormVerification);
    </script>

</body>
</html>
