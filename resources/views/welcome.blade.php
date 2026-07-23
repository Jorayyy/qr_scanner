<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Campus Access Gateway</title>
    
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            /* Unified high-resolution EVSU campus background mask layout */
            background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.8)), 
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
            max-width: 500px; 
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-sizing: border-box;
            text-align: center;
        }
        .logo-circle {
            background-color: #ffffff; 
            width: 56px;
            height: 56px;
            border-radius: 16px; 
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        .logo-text {
            color: #0f172a;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        h1 { 
            font-size: 26px; 
            color: #ffffff; 
            margin: 0; 
            font-weight: 800; 
            letter-spacing: -0.5px;
        }
        .subtitle { 
            font-size: 14px; 
            color: #cbd5e1; 
            margin: 8px 0 32px 0; 
            font-weight: 400;
            line-height: 1.5;
        }

        /* Access Routes Menu */
        .gateway-menu {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 32px;
        }
        .menu-btn {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            text-align: left;
            border: 1px solid transparent;
        }
        .btn-primary {
            background: #ffffff;
            color: #0f172a;
        }
        .btn-primary:hover {
            background: #f1f5f9;
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #f8fafc;
            border-color: rgba(255, 255, 255, 0.15);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }
        
        .btn-icon {
            margin-right: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        .btn-content {
            flex: 1;
        }
        .btn-title {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-desc {
            font-size: 11px;
            opacity: 0.75;
            margin: 4px 0 0 0;
            font-weight: 400;
        }

        /* Admin Portal Link Footer */
        .footer-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.15s ease;
            font-weight: 500;
        }
        .footer-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="card">
        <!-- University Branding Header -->
        <div class="logo-circle">
            <span class="logo-text">
                {{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}
            </span>
        </div>
        <h1>{{ env('APP_NAME', 'State University') }}</h1>
        <p class="subtitle">Welcome to the Campus Access Portal. Please select your visitor registration route below to obtain or verify your entry pass.</p>

        <!-- Access Routes Interactive Menu -->
        <div class="gateway-menu">
            <!-- Route A: Fresh Registration -->
            <a href="{{ route('visitor.register') }}" class="menu-btn btn-primary">
                <span class="btn-icon">📝</span>
                <div class="btn-content">
                    <div class="btn-title">New Visitor Registration <span>➔</span></div>
                    <p class="btn-desc">First-time arrival on campus or bringing an unlisted vehicle.</p>
                </div>
            </a>

            <!-- Route B: Quick Express Reissue -->
            <a href="{{ route('visitor.reissue') }}" class="menu-btn btn-secondary">
                <span class="btn-icon">⚡</span>
                <div class="btn-content">
                    <div class="btn-title">Express Pass Lookup <span>➔</span></div>
                    <p class="btn-desc">Returning guests update visit details and renew entry passes.</p>
                </div>
            </a>
        </div>

        <!-- Hidden Secure Access Entryway to Management Hub -->
        <a href="{{ route('login') }}" class="footer-link">
            <svg xmlns="http://w3.org" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Authorized Security Personnel Login
        </a>
    </div>

</body>
</html>
