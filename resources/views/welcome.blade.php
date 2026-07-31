<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Campus Access Gateway</title>
    
    <style>
        :root {
            --bg-ink: #0f172a;
            --bg-soft: #1e293b;
            --card: rgba(15, 23, 42, 0.72);
            --card-border: rgba(255, 255, 255, 0.12);
            --text-main: #ffffff;
            --text-muted: #cbd5e1;
            --text-faint: #94a3b8;
            --accent: #f8fafc;
            --accent-ink: #0f172a;
        }
        body { 
            font-family: Inter, "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif; 
            background: radial-gradient(circle at top left, rgba(59, 130, 246, 0.18), transparent 30%),
                        radial-gradient(circle at top right, rgba(14, 165, 233, 0.14), transparent 28%),
                        linear-gradient(rgba(15, 23, 42, 0.58), rgba(15, 23, 42, 0.86)), 
                        url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRTfP7BXODGeokb1X0ptCOu7pzgqNM7WiMOlQstwV-uRJ0JJfloFcGW74M&s=10') no-repeat center center fixed; 
            background-size: cover;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 24px; 
            box-sizing: border-box;
            color: var(--text-main);
            overflow: hidden;
        }
        .card { 
            position: relative;
            overflow: hidden;
            background: var(--card); 
            backdrop-filter: blur(12px) saturate(140%);
            -webkit-backdrop-filter: blur(12px) saturate(140%);
            padding: 42px 40px 34px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3); 
            width: 100%; 
            max-width: 560px; 
            border: 1px solid var(--card-border);
            box-sizing: border-box;
            text-align: center;
            animation: cardRise 0.7s ease-out both;
        }
        .card::before,
        .card::after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            filter: blur(28px);
            opacity: 0.22;
            pointer-events: none;
        }
        .card::before {
            top: -110px;
            right: -90px;
            background: rgba(59, 130, 246, 0.65);
        }
        .card::after {
            bottom: -130px;
            left: -110px;
            background: rgba(14, 165, 233, 0.55);
        }
        .card-inner {
            position: relative;
            z-index: 1;
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
        .logo-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 8px;
            box-sizing: border-box;
        }
        .logo-text {
            color: var(--accent-ink);
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            margin-bottom: 18px;
        }
        h1 { 
            font-size: 29px; 
            color: var(--text-main); 
            margin: 0; 
            font-weight: 800; 
            letter-spacing: -0.5px;
        }
        .hero-copy {
            max-width: 430px;
            margin: 0 auto;
        }
        .subtitle { 
            font-size: 14px; 
            color: var(--text-muted); 
            margin: 10px 0 22px 0; 
            font-weight: 400;
            line-height: 1.5;
        }
        .status-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 28px;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
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
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            text-align: left;
            border: 1px solid transparent;
            min-height: 82px;
            position: relative;
            overflow: hidden;
        }
        .btn-primary {
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            color: var(--accent-ink);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.18);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.25);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-main);
            border-color: rgba(255, 255, 255, 0.14);
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
            width: 42px;
            height: 42px;
            border-radius: 12px;
            flex-shrink: 0;
        }
        .btn-primary .btn-icon {
            background: rgba(15, 23, 42, 0.08);
        }
        .btn-secondary .btn-icon {
            background: rgba(255, 255, 255, 0.1);
        }
        .btn-content {
            flex: 1;
        }
        .btn-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .btn-desc {
            font-size: 12px;
            opacity: 0.82;
            margin: 4px 0 0 0;
            font-weight: 400;
            line-height: 1.45;
        }
        .tips-panel {
            margin-top: 10px;
            padding: 16px 16px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
        }
        .tips-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 10px 0;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
        }
        .tips-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .tips-list li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            color: var(--text-muted);
            font-size: 12px;
            line-height: 1.45;
        }
        .tip-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            margin-top: 5px;
            background: #f8fafc;
            box-shadow: 0 0 0 4px rgba(248, 250, 252, 0.08);
            flex-shrink: 0;
        }
        .campus-strip {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }
        .campus-chip {
            padding: 10px 12px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-muted);
            font-size: 11px;
            line-height: 1.35;
            text-align: left;
        }
        .campus-chip strong {
            display: block;
            color: #ffffff;
            font-size: 12px;
            margin-bottom: 2px;
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
        .footer-note {
            margin-top: 14px;
            font-size: 11px;
            color: var(--text-faint);
            line-height: 1.45;
        }
        @keyframes cardRise {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        @media (max-width: 640px) {
            body {
                padding: 16px;
            }
            .card {
                padding: 34px 22px 24px;
                border-radius: 22px;
            }
            h1 {
                font-size: 26px;
            }
            .campus-strip {
                grid-template-columns: 1fr;
            }
            .btn-title {
                font-size: 15px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-inner">
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
            <!-- University Branding Header -->
            <div class="logo-circle">
                @if ($brandLogoUrl)
                    <img src="{{ $brandLogoUrl }}" alt="{{ env('APP_NAME', 'State University') }} logo" class="logo-image">
                @else
                    <span class="logo-text">
                        {{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}
                    </span>
                @endif
            </div>
            <div class="eyebrow">Campus Access Portal</div>
            <div class="hero-copy">
                <h1>{{ env('APP_NAME', 'State University') }}</h1>
                <p class="subtitle">Fast campus entry for new visitors and returning guests. Choose the route below to create or refresh your pass, then head straight to your destination.</p>
            </div>

            <div class="status-row" aria-label="Portal highlights">
                <div class="status-pill">
                    <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-9"></path><path d="M14 17H5"></path><circle cx="17" cy="17" r="3"></circle><circle cx="7" cy="7" r="3"></circle></svg>
                    Simple check-in flow
                </div>
                <div class="status-pill">
                    <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="3"></rect><path d="M9 9h6v6H9z"></path></svg>
                    QR pass generation
                </div>
                <div class="status-pill">
                    <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l9 4.5v11L12 22l-9-4.5v-11L12 2z"></path><path d="M12 22V12"></path></svg>
                    Security ready
                </div>
            </div>

            <!-- Access Routes Interactive Menu -->
            <div class="gateway-menu">
                <!-- Route A: Fresh Registration -->
                <a href="{{ route('visitor.register') }}" class="menu-btn btn-primary">
                    <span class="btn-icon">
                        <svg xmlns="http://w3.org" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4"></path><path d="M15 4h5v5"></path><path d="M10 14 20 4"></path></svg>
                    </span>
                    <div class="btn-content">
                        <div class="btn-title">New Visitor Registration <span>➔</span></div>
                        <p class="btn-desc">First-time arrival on campus, fresh visit details, or a new vehicle setup.</p>
                    </div>
                </a>

                <!-- Route B: Quick Express Reissue -->
                <a href="{{ route('visitor.reissue') }}" class="menu-btn btn-secondary">
                    <span class="btn-icon">
                        <svg xmlns="http://w3.org" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11a8 8 0 1 0 2 5.3"></path><path d="M20 4v7h-7"></path></svg>
                    </span>
                    <div class="btn-content">
                        <div class="btn-title">Express Pass Lookup <span>➔</span></div>
                        <p class="btn-desc">Returning guests update details quickly and renew entry passes without starting over.</p>
                    </div>
                </a>
            </div>

            <div class="tips-panel">
                <div class="tips-title">
                    <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                    Before you start
                </div>
                <ul class="tips-list">
                    <li><span class="tip-dot"></span><span>Bring a valid ID and know the office, person, or purpose you are visiting.</span></li>
                    <li><span class="tip-dot"></span><span>Prepare vehicle details if you are driving a motorcycle or car.</span></li>
                    <li><span class="tip-dot"></span><span>Returning visitors can use Express Pass Lookup for a faster refresh.</span></li>
                </ul>
            </div>

            <div class="campus-strip" aria-label="Common campus destinations">
                <div class="campus-chip"><strong>Academic core</strong>Academic Building, Science Building, Library</div>
                <div class="campus-chip"><strong>Administration</strong>Registrar, Executive House, College Building</div>
                <div class="campus-chip"><strong>Campus landmarks</strong>EVSU Landmark, Gabaldon, Auditorium, Cafeteria</div>
            </div>

            <!-- Hidden Secure Access Entryway to Management Hub -->
            <div style="margin-top: 22px;">
                <a href="{{ route('login') }}" class="footer-link">
                    <svg xmlns="http://w3.org" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Authorized Security Personnel Login
                </a>
                <div class="footer-note">Designed to keep the entry process quick for visitors.</div>
            </div>
        </div>
    </div>

</body>
</html>
