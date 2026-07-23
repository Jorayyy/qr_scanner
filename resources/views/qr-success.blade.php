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
        
        /* 🆕 LIVE STATUS BADGES */
        .status-container {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }
        .status-pending {
            background: rgba(234, 179, 8, 0.15);
            color: #fef08a;
            border: 1px solid rgba(234, 179, 8, 0.3);
        }
        .status-inside {
            background: rgba(34, 197, 94, 0.15);
            color: #bbf7d0;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .status-left {
            background: rgba(148, 163, 184, 0.15);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        /* Clean White QR Box Frame Matrix Area */
        .qr-frame-box { 
            display: inline-block; 
            padding: 16px; 
            background: #ffffff; 
            border-radius: 16px; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3); 
            margin-bottom: 24px; 
        }
        .qr-frame-box svg { display: block; }
        
        h1 { font-size: 22px; color: #ffffff; margin: 0; font-weight: 700; letter-spacing: -0.5px; }
        .subtitle { font-size: 13px; color: #cbd5e1; margin-top: 6px; font-weight: 400; }
        
        /* Executive Technical Data Details Block */
        .meta-data-list { border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 16px; margin-bottom: 20px; text-align: left; }
        .meta-data-row { display: flex; justify-content: space-between; align-items: baseline; padding: 8px 0; font-size: 13px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .meta-data-row:last-child { border-bottom: none; }
        .meta-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .meta-value { font-weight: 600; color: #f8fafc; text-align: right; }
        
        /* 🆕 VEHICLE DECLARATION PANEL SECTOR */
        .vehicle-info-block {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 20px;
            text-align: left;
        }
        .vehicle-title {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: block;
        }
        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            font-size: 12px;
        }

        .bookmark-banner {
            background: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.25);
            color: #bae6fd;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .action-button-group { display: flex; flex-direction: column; gap: 10px; }
        
        .download-btn { background: #ffffff; color: #0f172a; height: 44px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.15s ease; width: 100%; box-sizing: border-box; }
        .download-btn:hover { background: #f1f5f9; }
        
        .back-link-btn { background: rgba(255, 255, 255, 0.05); color: #cbd5e1; height: 44px; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: all 0.15s ease; width: 100%; box-sizing: border-box; }
        .back-link-btn:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; }
    </style>
</head>
<body>

    <div class="card">
        <!-- 🆕 LIVE STATUS BADGE TRACKING BANNER -->
        @if(($visitor->status ?? '') === 'pending')
            <div class="status-container status-pending">🕒 Pass Status: Pending Entry</div>
        @elseif(($visitor->status ?? '') === 'checked_in')
            <div class="status-container status-inside">🟢 Pass Status: Inside Campus</div>
        @else
            <div class="status-container status-left">⚪ Pass Status: Left Campus</div>
        @endif
        
        <!-- DYNAMIC CONDITIONAL HEADER BLOCK -->
        @if(isset($page_status) && $page_status === 'returning')
            <h1>Welcome Back!</h1>
            <div class="subtitle">Your entry credentials for {{ env('APP_NAME', 'State University') }} have been reissued.</div>
        @else
            <h1>Registration Complete!</h1>
            <div class="subtitle">Your entry credentials for {{ env('APP_NAME', 'State University') }} have been issued.</div>
        @endif

        <!-- 🆕 DYNAMIC BOOKMARK / SCREENSHOT SAVER BANNER -->
        <div class="bookmark-banner" style="margin-top: 16px;">
            📸 <strong>Tip:</strong> Please <strong>Screenshot</strong> or <strong>Bookmark</strong> this page tab so you don't lose your gate scanner code!
        </div>

        <!-- Crisp QR Frame Area Matrix -->
        <div class="qr-frame-box">
            {!! $qrCode !!}
        </div>

        <!-- Technical Parameters Summary Grid -->
        <div class="meta-data-list">
            
            <!-- 👤 VISITOR NAME ROW CONTAINER -->
            <div class="meta-data-row">
                <span class="meta-label">Visitor Name</span>
                <span class="meta-value" style="font-weight: 700;">
                    {{-- Safely stitches split columns together on the fly --}}
                    {{ trim(($visitor->first_name ?? '') . ' ' . ($visitor->middle_name ?? '') . ' ' . ($visitor->last_name ?? '')) ?: 'N/A' }}
                </span>
            </div>

            <!-- 🏢 VISITING TARGET TWIN NULLABLE LOGIC ROW CONTAINER -->
            <div class="meta-data-row">
                <span class="meta-label">Visiting Target</span>
                <span class="meta-value" style="font-weight: 700;">
                    @php
                        $targetOffice = trim($visitor->office_to_visit ?? '');
                        $targetPerson = trim($visitor->person_to_visit ?? '');
                    @endphp

                    @if(!empty($targetOffice) && !empty($targetPerson))
                        {{ $targetOffice }} <span style="opacity: 0.7; font-weight: 500;">({{ $targetPerson }})</span>
                    @elseif(!empty($targetOffice))
                        {{ $targetOffice }}
                    @elseif(!empty($targetPerson))
                        {{ $targetPerson }}
                    @else
                        <span style="color: #64748b; font-style: italic; font-weight: 500;">General Premises (N/A)</span>
                    @endif
                </span>
            </div>

            <div class="meta-data-row">
                <span class="meta-label">Purpose of Entry</span>
                <span class="meta-value">{{ $visitor->purpose_of_visit ?? 'N/A' }}</span>
            </div>
            
            <div class="meta-data-row">
                <span class="meta-label">Current Tracking</span>
                <span class="meta-value" style="color: #38bdf8; font-weight: 700;">{{ $visitor->current_location ?? 'Main Gate' }}</span>
            </div>
            
            <!-- 🆕 NEW DYNAMIC VEHICLE TYPE SUMMARY PARAMETER ROW -->
            <div class="meta-data-row">
                <span class="meta-label">Vehicle Type</span>
                <span class="meta-value">
                    @switch(strtolower(trim($visitor->vehicle_type ?? 'pedestrian')))
                        @case('pedestrian') 🚶 Pedestrian @break
                        @case('motorcycle') 🏍️ Motorcycle @break
                        @case('car') 🚗 Car / Sedan @break
                        @default {{ ucfirst($visitor->vehicle_type ?? 'Pedestrian') }}
                    @endswitch
                </span>
            </div>

            <!-- 🆕 NEW DYNAMIC VEHICLE SPECIFICATIONS EXTENSION DRAWER VIEW -->
            @if(!in_array(strtolower(trim($visitor->vehicle_type ?? 'pedestrian')), ['pedestrian', 'none', '']) && ($visitor->vehicle_brand ?? false))
                <div class="vehicle-info-block" style="margin-top: 12px; font-size: 13px;">
                    <span class="vehicle-title">Registered Vehicle Metrics</span>
                    <div class="vehicle-grid">
                        <div>
                            <div style="color:#94a3b8; font-size:10px; text-transform:uppercase;">Brand / Model</div>
                            <div style="font-weight:600; color:#ffffff;">{{ $visitor->vehicle_brand }} ({{ $visitor->vehicle_model ?? 'N/A' }})</div>
                        </div>
                        <div>
                            <div style="color:#94a3b8; font-size:10px; text-transform:uppercase;">Plate & Color</div>
                            <div style="font-weight:600; color:#ffffff; letter-spacing:0.5px;">{{ strtoupper($visitor->vehicle_plate ?? 'N/A') }} • {{ ucfirst($visitor->vehicle_color ?? 'N/A') }}</div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="token-display-field" style="background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); padding: 10px; border-radius: 8px; margin-top: 12px; text-align: center;">
                <span class="meta-label" style="display:block; margin-bottom:4px; font-size:10px; text-align:center;">Unique Pass Token ID Code</span>
                <div class="token-string-text" id="passTokenString" style="font-family: monospace; font-size: 11px; color: #94a3b8; word-break: break-all; user-select: all;">{{ $visitor->qr_code_token ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Shared Action Button Layout Controls Bundle -->
        <div class="action-button-group">
            <!-- Solid Primary Action Download Button -->
            <button onclick="downloadPassImage()" class="download-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download QR Pass Image
            </button>

            <!-- Slate Gray Outline Back Link Navigation Button -->
            <a href="{{ route('visitor.register') }}" class="back-link-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Register Another Visitor
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
                
                const rawTokenStr = document.getElementById('passTokenString').innerText.trim();
                const cleanFilename = 'PASS_' + rawTokenStr + '.png';
                
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
