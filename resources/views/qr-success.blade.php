<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State University - Registration Complete</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px; display: flex; align-items: center; justify-content: center; min-height: 100vh; color: #0f172a; }
        .success-container { background: #ffffff; padding: 40px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02), 0 8px 10px -6px rgba(0,0,0,0.02); max-width: 480px; width: 100%; box-sizing: border-box; text-align: center; }
        
        /* Premium Status Check Badge */
        .status-badge-circle { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: #f0fdf4; color: #16a34a; border-radius: 50%; margin-bottom: 20px; border: 1px solid #bbf7d0; }
        
        h1 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px; color: #0f172a; }
        .subtitle { font-size: 13px; color: #64748b; margin-top: 6px; font-weight: 400; }
        
        /* Professional Warning Micro Banner */
        .warning-banner { display: inline-flex; align-items: center; gap: 6px; background: #fffde6; border: 1px solid #fef08a; color: #a16207; padding: 6px 14px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 20px 0 28px 0; }
        
        /* Clean QR Frame Matrix Wrapping Area */
        .qr-frame-box { display: inline-block; padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-bottom: 28px; }
        .qr-frame-box svg, .qr-frame-box img { display: block; max-width: 100%; height: auto; }
        
        /* Executive Technical Data Details Block */
        .meta-data-list { border-top: 1px solid #f1f5f9; padding-top: 20px; margin-bottom: 28px; text-align: left; }
        .meta-data-row { display: flex; justify-content: space-between; align-items: baseline; padding: 8px 0; font-size: 13px; }
        .meta-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .meta-value { font-weight: 600; color: #0f172a; text-align: right; }
        
        /* Token Field Copy Area Box */
        .token-display-field { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-top: 12px; text-align: center; }
        .token-string-text { font-family: monospace; font-size: 12px; color: #475569; word-break: break-all; user-select: all; }

        /* Cohesive Flat Action Control Buttons System */
        .action-button-group { display: flex; flex-direction: column; gap: 10px; }
        
        .download-btn { background: #0f172a; color: #ffffff; height: 44px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.15s ease; width: 100%; box-sizing: border-box; }
        .download-btn:hover { background: #1e293b; }
        
        .back-link-btn { background: #ffffff; color: #475569; height: 44px; border: 1px solid #cbd5e1; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: all 0.15s ease; width: 100%; box-sizing: border-box; }
        .back-link-btn:hover { background: #f8fafc; border-color: #94a3b8; color: #0f172a; }
    </style>
</head>
<body>

    <div class="success-container">
        <!-- Status Verification Check Shield badge -->
        <div class="status-badge-circle">
            <svg xmlns="http://w3.org" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        
        <<!-- Open qr-success.blade.php -->
        <h1>Registration Complete!</h1>
        <div class="subtitle">Your entry credentials for {{ env('APP_NAME', 'the university') }} have been issued successfully.</div>


        <!-- Professional Warning Box -->
        <div class="warning-banner">
            <svg xmlns="http://w3.org" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            Valid for single-use campus entry only
        </div>

        <!-- Crisp QR Frame Area Matrix -->
        <div class="qr-frame-box">
            <!-- Renders your high-res dynamic server package vector graphic seamlessly -->
            {!! $qrCode !!}
        </div>

        <!-- Technical Parameters Summary Grid -->
        <div class="meta-data-list">
            <div class="meta-data-row">
                <span class="meta-label">Visitor Name</span>
                <span class="meta-value">{{ $visitor->full_name }}</span>
            </div>
            <div class="meta-data-row">
                <span class="meta-label">Visiting Target</span>
                <span class="meta-value">{{ $visitor->person_to_visit }}</span>
            </div>
            <div class="meta-data-row">
                <span class="meta-label">Purpose of Entry</span>
                <span class="meta-value">{{ $visitor->purpose_of_visit }}</span>
            </div>
            
            <div class="token-display-field">
                <span class="meta-label" style="display:block; margin-bottom:6px; font-size:10px; text-align:center;">Unique Pass Token ID Code</span>
                <div class="token-string-text" id="passTokenString">{{ $visitor->qr_code_token }}</div>
            </div>
        </div>

        <!-- Shared Action Button Layout Controls Bundle -->
        <div class="action-button-group">
            <!-- Solid Primary Action Download Button -->
            <button onclick="downloadPassImage()" class="download-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download QR Pass Image
            </button>

            <!-- Slate Gray Outline Back Link Navigation Button -->
            <a href="{{ route('visitor.register') }}" class="back-link-btn">
                <svg xmlns="http://w3.org" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Register Another Visitor
            </a>
        </div>
    </div>

    <!-- Client-Side Vector To PNG Image Packaging Downloader Script -->
    <script>
        function downloadPassImage() {
            // Find the dynamic vector grid graphic generated by SimpleQR
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
                
                // Add breathing room padding so scan readers lock focus edge contrast easily
                const borderOffsetPadding = 30;
                canvas.width = imageRunner.width + (borderOffsetPadding * 2);
                canvas.height = imageRunner.height + (borderOffsetPadding * 2);
                
                // Set plain pristine white canvas base background layer
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Draw vector grid pixels directly onto fresh canvas area block
                ctx.drawImage(imageRunner, borderOffsetPadding, borderOffsetPadding);
                
                // Extract file naming using the visitor code parameter token
                const rawTokenStr = document.getElementById('passTokenString').innerText.trim();
                const cleanFilename = 'PASS_' + rawTokenStr + '.png';
                
                // Trigger dynamic anchor browser attachment download sequence
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
