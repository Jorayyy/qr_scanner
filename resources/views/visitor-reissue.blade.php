<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Returning Visitor</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background-color: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 24px; box-sizing: border-box; color: #0f172a; }
        .card { background: #ffffff; padding: 40px; border-radius: 24px; box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.03); width: 100%; max-width: 440px; border: 1px solid #e2e8f0; box-sizing: border-box; }
        .logo-circle { background-color: #0f172a; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .logo-text { color: white; font-weight: 700; font-size: 16px; letter-spacing: 0.5px; text-transform: uppercase; }
        .text-center { text-align: center; margin-bottom: 28px; }
        h1 { font-size: 22px; color: #0f172a; margin: 0; font-weight: 700; }
        .subtitle { font-size: 13px; color: #64748b; margin: 6px 0 0 0; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 11px; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        input { width: 100%; height: 42px; padding: 0 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none; transition: all 0.15s ease; }
        input:focus { border-color: #0f172a; box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06); }
        input.invalid { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.06); }
        .submit-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: #0f172a; color: white; height: 44px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; margin-top: 8px; }
        .submit-btn:disabled { background: #94a3b8; cursor: not-allowed; }
        .back-btn { display: inline-flex; align-items: center; justify-content: center; width: 100%; background: transparent; color: #64748b; height: 44px; border-radius: 8px; font-weight: 600; font-size: 14px; border: 1px solid #cbd5e1; cursor: pointer; margin-top: 10px; text-decoration: none; box-sizing: border-box; }
        .back-btn:hover { background: #f1f5f9; color: #0f172a; }
        .error-msg { background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border: 1px solid #fee2e2; }
        .hint-text { font-size: 11px; color: #94a3b8; margin-top: 4px; display: block; }
    </style>
</head>
<body>

    <div class="card">
        <div class="text-center">
            <div class="logo-circle"><span class="logo-text">{{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}</span></div>
            <h1>Express Pass Lookup</h1>
            <p class="subtitle">
                Provide your ID and current visiting purpose to refresh your pass.
                <strong style="display: block; margin-top: 5px; color: #b45309; font-size: 11px;">
                    ⚠️ Note: Outside guests/parents without a school ID must register as a new visitor.
                </strong>
            </p>
        </div>

        @if ($errors->has('id_number'))
            <div class="error-msg" id="serverError">
                {{ $errors->first('id_number') }}
            </div>
        @endif

        <form action="{{ route('visitor.reissue.submit') }}" method="POST" id="lookupForm">
            @csrf 
            
            <div class="form-group">
    <label>Your Full Name / ID Number</label>
    <!-- 🔄 Updated placeholder to invite names or IDs -->
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

            <!-- 🔄 Button is now active by default, it does not wait for a format filter -->
            <button type="submit" class="submit-btn" id="submitBtn">Generate Express Pass</button>
            <a href="{{ route('visitor.register') }}" class="back-btn">New Visitor Registration</a>
        </form>
    </div>

    <script>
        const idInput = document.getElementById('id_number');
        const submitBtn = document.getElementById('submitBtn');
        const hint = document.getElementById('validationHint');
        const serverError = document.getElementById('serverError');

        // 🔄 Listens only to field length to manage button lockout and clear server alerts
        idInput.addEventListener('input', function(e) {
            const value = e.target.value.trim();

            if(serverError) serverError.style.display = 'none';

            if (value.length > 0) {
                idInput.classList.remove('invalid');
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });
    </script>
</body>
</html>
