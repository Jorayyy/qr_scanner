<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Visitor Registration</title>
    
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            background-color: #f8fafc; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 24px; 
            box-sizing: border-box;
            color: #0f172a;
        }
        .card { 
            background: #ffffff; 
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 10px 30px -5px rgba(0, 0, 0, 0.03); 
            width: 100%; 
            max-width: 480px; 
            border: 1px solid #e2e8f0;
            box-sizing: border-box;
        }
        .logo-circle {
            background-color: #0f172a; 
            width: 48px;
            height: 48px;
            border-radius: 14px; /* Premium squircle instead of a plain circle */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.1);
        }
        .logo-text {
            color: white;
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
            color: #0f172a; 
            margin: 0; 
            font-weight: 700; 
            letter-spacing: -0.5px;
        }
        .subtitle { 
            font-size: 13px; 
            color: #64748b; 
            margin: 6px 0 0 0; 
            font-weight: 400;
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
            color: #475569; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        input { 
            width: 100%; 
            height: 42px;
            padding: 0 14px; 
            border: 1px solid #cbd5e1; 
            border-radius: 8px; 
            font-size: 14px;
            color: #0f172a;
            background-color: #ffffff;
            box-sizing: border-box;
            transition: all 0.15s ease;
            outline: none;
        }
        input:focus {
            border-color: #0f172a; 
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06);
        }
        input::placeholder {
            color: #94a3b8;
            opacity: 0.7;
        }
        .submit-btn { 
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%; 
            background: #0f172a; 
            color: white; 
            height: 44px;
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 14px; 
            border: none; 
            cursor: pointer; 
            margin-top: 12px;
            transition: background 0.15s ease;
            box-sizing: border-box;
        }
        .submit-btn:hover { 
            background: #1e293b; 
        }
        .submit-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <div class="card">
        <!-- University Branding Header -->
        <div class="text-center">
            <div class="logo-circle">
                <span class="logo-text">
                    {{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}
                </span>
            </div>
            <h1>{{ env('APP_NAME', 'State University') }}</h1>
            <p class="subtitle">{{ env('SYSTEM_DEPARTMENT', 'Visitor Management Control') }} Gateway</p>
        </div>

        <!-- Form Layout -->
        <form action="{{ route('visitor.store') }}" method="POST" onsubmit="this.querySelector('.submit-btn').disabled=true; this.querySelector('.submit-btn').innerText='Generating Pass...';">
            @csrf 

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="John Doe" required autocomplete="off">
            </div>

            <!-- Balanced side-by-side fields for mobile/desktop layout symmetry -->
            <div class="form-grid">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" placeholder="09123456789" required autocomplete="off">
                </div>
                 
                <div class="form-group">
                    <label for="id_number">ID Number</label>
                    <input type="text" name="id_number" id="id_number" placeholder="2026-12345" required autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label>Purpose of Visit</label>
                <input type="text" name="purpose_of_visit" placeholder="e.g., Registrar, Submission, Meeting" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Person to Visit</label>
                <input type="text" name="person_to_visit" placeholder="e.g., Dr. Smith, Dean Office" required autocomplete="off">
            </div>

            <button type="submit" class="submit-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><path d="M14 14h7v7h-7z"></path></svg>
                Generate Visitor QR Pass
            </button>
        </form>
    </div>

</body>
</html>
