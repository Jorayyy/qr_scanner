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

        .form-group {
            margin-bottom: 20px;
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
        input { 
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
        input:focus {
            border-color: #ffffff; 
            background-color: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.15);
        }
        input::placeholder {
            color: #94a3b8;
            opacity: 0.8;
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

        <!-- 🆕 NEW DYNAMIC WARNING BANNER FROM GLASSMORPHISM SYSTEM -->
        <div class="warning-banner">
            ⚠️ <strong>Note:</strong> Outside guests/parents without a school ID must register as a new visitor.
        </div>

        @if ($errors->has('id_number'))
            <div class="error-msg" id="serverError" style="background-color: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: left;">
                {{ $errors->first('id_number') }}
            </div>
        @endif

        <form action="{{ route('visitor.reissue.submit') }}" method="POST" id="lookupForm">
            @csrf 
            
            <div class="form-group">
                <label>Your Full Name / ID Number</label>
                <input type="text" name="id_number" id="id_number" placeholder="Enter your Registered Name or ID" required autocomplete="off" maxlength="50">
                <span class="hint-text" id="validationHint">Enter the exact name or ID number you used when you registered.</span>
            </div>

            <div class="form-group">
                <label>New Purpose of Visit</label>
                <input type="text" name="purpose_of_visit" placeholder="e.g., Registrar, Submission, Meeting" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>New Person / Office to Visit</label>
                <input type="text" name="person_to_visit" placeholder="e.g., Dr. Smith, Dean Office" required autocomplete="off">
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

        // Listens only to field length to manage button lockout and clear server alerts
        idInput.addEventListener('input', function(e) {
            const value = e.target.value.trim();

            if(serverError) serverError.style.display = 'none';

            if (value.length > 0) {
                idInput.style.borderColor = 'rgba(255, 255, 255, 0.4)';
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });
    </script>
</body>
</html>
