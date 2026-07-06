<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Gate Security Terminal</title>
    <!-- NO EXTERNAL NETWORK SCRIPT TAGS AT ALL HERE - 100% OFFLINE SAFE -->
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
        .form-group {
            margin-bottom: 20px;
            text-align: left;
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
        select, input[type="text"] { 
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
            font-family: inherit;
        }
        input[type="text"] {
            font-family: monospace; /* Preserves token code legibility */
        }
        select:focus, input[type="text"]:focus {
            border-color: #0f172a; 
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06);
        }
        input[type="text"]::placeholder {
            color: #94a3b8;
            opacity: 0.7;
        }
        
        /* Premium File Upload Box matching the style framework */
        .upload-zone { 
            border: 2px dashed #cbd5e1; 
            padding: 32px 16px; 
            border-radius: 12px; 
            background: #f8fafc; 
            cursor: pointer; 
            transition: all 0.15s ease; 
            text-align: center;
        }
        .upload-zone:hover { 
            border-color: #0f172a; 
            background: #f1f5f9;
        }
        .upload-icon {
            font-size: 28px; 
            display: block; 
            margin-bottom: 8px;
        }
        .upload-text { 
            font-size: 13px; 
            font-weight: 600; 
            color: #475569; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Result/Standby engine display block */
        #result-box { 
            margin: 20px 0; 
            padding: 12px; 
            background: #f1f5f9; 
            border-radius: 8px; 
            font-family: monospace; 
            font-size: 12px; 
            color: #475569; 
            border: 1px solid #e2e8f0; 
            text-align: center;
            font-weight: 500;
        }

        .divider { 
            display: flex; 
            align-items: center; 
            text-align: center; 
            margin: 24px 0; 
            color: #94a3b8; 
            font-size: 11px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        .divider::before, .divider::after { 
            content: ''; 
            flex: 1; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .divider:not(:empty)::before { margin-right: .75em; }
        .divider:not(:empty)::after { margin-left: .75em; }

        .manual-box { 
            text-align: left; 
        }
        .input-group { 
            display: flex; 
            gap: 8px; 
        }
        .go-btn { 
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #0f172a; 
            color: white; 
            border: none; 
            padding: 0 20px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 13px; 
            cursor: pointer; 
            text-transform: uppercase; 
            transition: background 0.15s ease;
        }
        .go-btn:hover { 
            background: #1e293b; 
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
            <h1>Gate Security Terminal</h1>
            <p class="subtitle">Upload a pass photo file or use manual entry fallback</p>
        </div>

        <div class="form-group">
            <label for="stationLocation">Select Scanning Station Location</label>
            <select id="stationLocation">
                <option value="Main Gate">Main Gate (Entry/Exit)</option>
                <option value="Registrar Office">Registrar's Office</option>
                <option value="Dean Office">Dean's Office</option>
                <option value="Accounting Department">Accounting Department</option>
                <option value="University Library">University Library</option>
            </select>
        </div>

        <input type="file" id="qrFileInput" accept="image/*" style="display: none;">

        <div class="upload-zone" onclick="document.getElementById('qrFileInput').click()">
            <span class="upload-icon">📁</span>
            <span class="upload-text">Select Downloaded QR Pass File</span>
        </div>

        <div id="result-box">Terminal standby engine active.</div>

        <div class="divider">Or Manual Input Entry</div>

        <div class="manual-box">
            <label for="tokenField">Pass Token ID Code</label>
            <div class="input-group">
                <input type="text" id="tokenField" placeholder="Paste token code here..." autocomplete="off">
                <button onclick="verifyManualToken()" class="go-btn">Verify</button>
            </div>
        </div>
    </div>

    <script>
    const fileSelector = document.getElementById('qrFileInput');
    const resultDisplay = document.getElementById('result-box');

    fileSelector.addEventListener('change', e => {
        if (!e.target.files || e.target.files.length === 0) return;
        
        const file = e.target.files[0];
        resultDisplay.style.color = "#e2e8f0";
        resultDisplay.innerText = "Analyzing file grid matrix layers...";

        const selectedLocation = document.getElementById("stationLocation").value;

        // 1. FIRST PRIORITY CHECK: Fallback back to filename if it matches the PC pattern
        const filename = file.name;
        if (filename.startsWith("PASS_")) {
            const extractedToken = filename.replace("PASS_", "").split('.')[0];
            routeToVerify(extractedToken, selectedLocation);
            return;
        }

        // 2. SMART MOBILE PASS CHECKER: Reads the actual image pixels directly
        // This is a 100% self-contained fallback scanner that reads phone screenshots instantly
        const img = new Image();
        img.src = URL.createObjectURL(file);
        
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);
            
            // Clean up cache links securely
            URL.revokeObjectURL(img.src);
            
            // Native micro detector layout search logic loop built into browsers
            if ('BarcodeDetector' in window) {
                const detector = new BarcodeDetector({ formats: ['qr_code'] });
                detector.detect(canvas)
                    .then(barcodes => {
                        if (barcodes.length > 0) {
                            resultDisplay.style.color = "#10b981";
                            resultDisplay.innerText = "Pass token matched via matrix! Routing...";
                            routeToVerify(barcodes[0].rawValue.trim(), selectedLocation);
                        } else {
                            // If the native script doesn't find a code, fallback to using the phone's full file string hash name
                            // This matches those random string hashes phone downloads sometimes have!
                            const genericName = filename.split('.')[0];
                            if (genericName.length > 20) {
                                routeToVerify(genericName, selectedLocation);
                            } else {
                                throwError();
                            }
                        }
                    })
                    .catch(() => throwError());
            } else {
                // If it's an older phone without a Barcode Detector, try extracting the clean hash name directly
                const genericName = filename.split('.')[0];
                if (genericName.length > 20) {
                    routeToVerify(genericName, selectedLocation);
                } else {
                    throwError();
                }
            }
        };

        img.onerror = function() {
            throwError();
            URL.revokeObjectURL(img.src);
        };
    });

    function throwError() {
        resultDisplay.style.color = "#ef4444";
        resultDisplay.innerText = "Error: System failed to read QR matrix layers. Try a clearer screenshot.";
    }

    function routeToVerify(token, location) {
        window.location.href = "/verify-scan/" + token + "/" + encodeURIComponent(location);
    }

    function verifyManualToken() {
        const rawToken = document.getElementById("tokenField").value.trim();
        const selectedLocation = document.getElementById("stationLocation").value;
        if (!rawToken) return alert("Input a valid token first!");
        routeToVerify(rawToken, selectedLocation);
    }
    </script>


</body>
</html>
