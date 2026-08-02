<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Express Pass Hub</title>
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
            padding: 32px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3); 
            width: 100%; 
            max-width: 440px; 
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-sizing: border-box;
            text-align: center;
        }

        .brand-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }
        .logo-circle {
            width: 104px;
            height: 104px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
        }
        .logo-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 14px;
            box-sizing: border-box;
        }
        .logo-text {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffffff;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .hero-copy {
            margin-bottom: 18px;
        }
        
        .identity-panel {
            background: rgba(30, 41, 59, 0.38);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 14px;
            margin: 18px 0 22px 0;
            text-align: left;
        }
        .identity-title {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .identity-name {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
            margin-bottom: 10px;
        }
        .identity-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .identity-pill {
            background: rgba(15, 23, 42, 0.55);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 10px;
            padding: 10px 12px;
        }
        .identity-pill-label {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .identity-pill-value {
            font-size: 13px;
            font-weight: 600;
            color: #f8fafc;
            word-break: break-word;
        }

        .quick-note {
            color: #cbd5e1;
            font-size: 13px;
            line-height: 1.5;
            margin: 0 0 18px;
        }

        .qr-frame-box { 
            display: inline-block; 
            padding: 18px; 
            background: #ffffff; 
            border-radius: 16px; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3); 
            margin-bottom: 18px; 
            width: fit-content;
            max-width: 100%;
        }
        .qr-frame-box svg { display: block; max-width: 100%; height: auto; }
        
        h1 { font-size: 22px; color: #ffffff; margin: 0; font-weight: 700; letter-spacing: -0.5px; }
        .subtitle { font-size: 13px; color: #cbd5e1; margin-top: 6px; font-weight: 400; }

        .action-button-group { display: flex; flex-direction: column; gap: 10px; }
        
        .download-btn { background: #ffffff; color: #0f172a; height: 44px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.15s ease; width: 100%; box-sizing: border-box; }
        .download-btn:hover { background: #f1f5f9; }
        
        .back-link-btn { background: rgba(255, 255, 255, 0.05); color: #cbd5e1; height: 44px; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: all 0.15s ease; width: 100%; box-sizing: border-box; }
        .back-link-btn:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; }
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

        <div class="brand-block">
            <div class="logo-circle">
                @if ($brandLogoUrl)
                    <img src="{{ $brandLogoUrl }}" alt="{{ env('APP_NAME', 'State University') }} logo" class="logo-image">
                @else
                    <span class="logo-text">{{ strtoupper(substr(env('APP_NAME', 'SU'), 0, 2)) }}</span>
                @endif
            </div>
            <div class="eyebrow">Pass Ready</div>

            @if(isset($page_status) && $page_status === 'returning')
                <h1>Welcome Back</h1>
            @else
                <h1>Registration Complete</h1>
            @endif

            <div class="subtitle">Your QR pass is ready for scanning at the gate.</div>
        </div>

        <div class="identity-panel">
            <div class="identity-title">Visitor Badge</div>
            <div class="identity-name">
                {{ trim(($visitor->first_name ?? '') . ' ' . ($visitor->middle_name ?? '') . ' ' . ($visitor->last_name ?? '')) ?: 'N/A' }}
            </div>
            <div class="identity-meta">
                <div class="identity-pill">
                    <span class="identity-pill-label">Registration ID</span>
                    <span class="identity-pill-value">{{ $visitor->id_number ?? 'N/A' }}</span>
                </div>
                <div class="identity-pill">
                    <span class="identity-pill-label">Status</span>
                    <span class="identity-pill-value">{{ strtoupper($visitor->status ?? 'pending') }}</span>
                </div>
            </div>
        </div>

        <p class="quick-note">Keep this page open or download the QR image below.</p>

        <!-- Crisp QR Frame Area Matrix -->
        <div class="qr-frame-box">
            {!! $qrCode !!}
        </div>

        <!-- Shared Action Button Layout Controls Bundle -->
        <div class="action-button-group">
            <!-- Solid Primary Action Download Button -->
            <button onclick="downloadPassImage()" class="download-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download QR Pass Image
            </button>

            <a href="{{ route('visitor.verify.reset') }}" class="back-link-btn" style="background: rgba(34, 197, 94, 0.12); border-color: rgba(34, 197, 94, 0.25); color: #bbf7d0;">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"></path><path d="M12 3l9 9-9 9"></path></svg>
                Register New Visitor
            </a>

            <a href="{{ route('welcome') }}" class="back-link-btn" style="background: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.16); color: #e2e8f0;">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"></path><path d="M8 5l-5 7 5 7"></path></svg>
                Main Gateway
            </a>
        </div>
    </div>


    <!-- Client-Side Vector To PNG Image Packaging Downloader Script -->
    <script>
        function downloadPassImage() {
            const svgElement = document.querySelector('.qr-frame-box svg');
            if (!svgElement) return alert('Failed to locate pass image elements.');

            const svgString = new XMLSerializer().serializeToString(svgElement);
            const svgBlob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
            const URLWrapper = window.URL || window.webkitURL || window;
            const blobURL = URLWrapper.createObjectURL(svgBlob);
            
            const imageRunner = new Image();
            imageRunner.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                const borderOffsetPadding = 30;
                canvas.width = imageRunner.width + (borderOffsetPadding * 2);
                canvas.height = imageRunner.height + (borderOffsetPadding * 2);
                
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                ctx.drawImage(imageRunner, borderOffsetPadding, borderOffsetPadding);
                
                const fallbackName = @json($visitor->id_number ?? $visitor->qr_code_token ?? 'PASS');
                const rawTokenStr = (document.getElementById('passTokenString')?.innerText || fallbackName).trim();
                const cleanFilename = 'PASS_' + rawTokenStr.replace(/[^a-z0-9_-]+/gi, '_') + '.png';
                
                const downloaderAnchorElement = document.createElement('a');
                downloaderAnchorElement.download = cleanFilename;
                downloaderAnchorElement.href = canvas.toDataURL('image/png');
                document.body.appendChild(downloaderAnchorElement);
                downloaderAnchorElement.click();
                document.body.removeChild(downloaderAnchorElement);
                
                URLWrapper.revokeObjectURL(blobURL);
            };
            imageRunner.src = blobURL;
        }
    </script>

</body>
</html>
