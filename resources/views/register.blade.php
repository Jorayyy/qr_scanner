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
    </style>
</head>
<body>

    <div class="card">
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

        <div class="text-center">
            <div class="logo-circle"><span class="logo-text">{{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}</span></div>
            <h1>{{ env('APP_NAME', 'State University') }}</h1>
            <p class="subtitle">{{ env('SYSTEM_DEPARTMENT', 'Visitor Management Control') }} Gateway</p>
        </div>

        <form action="{{ route('visitor.store') }}" method="POST" onsubmit="this.querySelector('.submit-btn').disabled=true; this.querySelector('.submit-btn').innerText='Generating Pass...';">
            @csrf 

            <!-- 🆕 NEW STRUCTURE: 3-Column Split Name Fields -->
            <div class="form-grid">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="John" value="{{ old('first_name') }}" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Middle Name <span class="optional-mark">(optional)</span></label>
                    <input type="text" name="middle_name" placeholder="Doe" value="{{ old('middle_name') }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Smith" value="{{ old('last_name') }}" required autocomplete="off">
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
                <label>Purpose of Visit</label>
                <input type="text" name="purpose_of_visit" placeholder="e.g., Registrar, Submission, Meeting" value="{{ old('purpose_of_visit') }}" required autocomplete="off">
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

            <!-- Back to Public Home Gateway Link Route -->
            <a href="{{ route('welcome') }}" style="display: block; text-align: center; margin-top: 16px; font-size: 12px; color: #94a3b8; text-decoration: none; transition: color 0.15s ease; font-weight: 500;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">
                ← Back to Welcome Gateway
            </a>
        </form>
    </div>

    <script>
        // Enforce alignment consistency across the registration form
        const registrationIdInput = document.getElementById('id_number');
        const registerForm = registrationIdInput.closest('form');
        const regSubmitBtn = registerForm.querySelector('.submit-btn');

        const strictFormatRegex = /^\d{2,4}-\d{3,10}$/;

        registrationIdInput.addEventListener('input', function(e) {
            let val = e.target.value.replace(/[^0-9a-zA-Z-]/g, '');
            if (val.length > 4 && !val.includes('-')) {
                val = val.slice(0, 4) + '-' + val.slice(4);
            }
            e.target.value = val;

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
    </script>

</body>
</html>
