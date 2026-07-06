<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State University - Admin Authentication</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; display: flex; align-items: center; justify-content: center; min-height: 100vh; color: #0f172a; }
        .login-card { background: #ffffff; padding: 40px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02), 0 8px 10px -6px rgba(0,0,0,0.02); max-width: 400px; width: 100%; box-sizing: border-box; }
        
        /* Premium Header Branding Styles */
        .brand-section { text-align: center; margin-bottom: 32px; }
        .brand-logo-badge { display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: #0f172a; color: #ffffff; font-size: 16px; font-weight: 700; border-radius: 12px; letter-spacing: 0.5px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15); text-transform: uppercase; }
        h1 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px; color: #0f172a; text-transform: uppercase; }
        .brand-subtitle { font-size: 13px; color: #64748b; margin-top: 4px; font-weight: 400; }
        
        /* Clean Input Field Group Containers */
        .input-group { margin-bottom: 20px; }
        label { display: block; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        
        /* Relative Wrapper to Align Vector Elements & Toggles */
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper svg.field-icon { position: absolute; left: 14px; color: #94a3b8; pointer-events: none; }
        
        input { width: 100%; height: 42px; padding: 0 14px 0 40px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #334155; background: #ffffff; box-sizing: border-box; outline: none; font-family: inherit; transition: all 0.15s ease; }
        input:focus { border-color: #0f172a; box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06); }
        
        /* Adjusted Padding for the Password Password Input field */
        input[type="password"], input[type="text"]#securityPassword { padding-right: 40px; }
        
        /* Flat Center Vector Eye Toggle Button Positioning */
        .eye-toggle-btn { position: absolute; right: 12px; background: none; border: none; padding: 0; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: color 0.15s ease; }
        .eye-toggle-btn:hover { color: #64748b; }
        
        /* Premium Solid Black Authorize Access Action Button */
        .login-btn { width: 100%; background: #0f172a; color: #ffffff; height: 44px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 10px; transition: background 0.15s ease; text-transform: uppercase; letter-spacing: 0.5px; }
        .login-btn:hover { background: #1e293b; }
        
        /* Professional Muted Status Notification Banners */
        .alert { padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 24px; text-align: left; display: flex; align-items: center; gap: 10px; border: 1px solid transparent; }
        .alert-error { background: #fef2f2; color: #991b1b; border-color: #fee2e2; }
        .alert-success { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Brand Header Section -->
        <!-- Open login.blade.php -->
<!-- Replace your old brand-section inside login.blade.php with this: -->
<div class="brand-section">
    <div style="display: flex; justify-content: center; width: 100%; margin-bottom: 16px;">
        <div class="brand-logo-badge">SU</div>
    </div>
    <h1>{{ env('APP_NAME', 'State University') }}</h1>
    <div class="brand-subtitle">Administrative Secure Access Panel</div>
</div>



        <!-- 🔴 Red Unsuccessful Warning Banner -->
        @if(session('error'))
            <div class="alert alert-error">
                <svg xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- 🟢 Green Successful Logout Banner -->
        @if(session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            
            <!-- Security Email Username Input Field -->
            <div class="input-group">
                <label>Security Username / Email</label>
                <div class="input-wrapper">
                    <svg class="field-icon" xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6Ref 0 0 1 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input type="text" name="username" placeholder="admin@gmail.com" required autocomplete="off" value="{{ old('username') }}">
                </div>
            </div>
            
            <!-- Secure Encrypted Password Field with Eye Toggle Icon -->
            <div class="input-group">
                <label>Security Password</label>
                <div class="input-wrapper">
                    <svg class="field-icon" xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input type="password" id="securityPassword" name="password" placeholder="••••••••" required>
                    
                    <!-- Interactive Reveal Password Action Button -->
                    <button type="button" id="togglePasswordVisibility" class="eye-toggle-btn" title="Toggle Password Visibility">
                        <svg id="eyeIcon" xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eyeOffIcon" xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Unified Solid Executive Submit Authorization Button -->
            <button type="submit" class="login-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Authorize Access
            </button>
        </form>
    </div>

    <!-- Client-Side Toggle Field Password Controller Script -->
    <script>
        document.getElementById('togglePasswordVisibility').addEventListener('click', function () {
            const passwordInput = document.getElementById('securityPassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        });
    </script>

</body>
</html>
