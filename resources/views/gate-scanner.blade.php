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
        flex-direction: column; /* 👈 Stacks the navbar on top of the card */
        align-items: center; 
        justify-content: flex-start; /* 👈 Flows elements smoothly from the top down */
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
        <!-- PLACE THIS EXACTLY ABOVE YOUR CLOSING </head> TAG -->
    <script src="https://unpkg.com" type="text/javascript"></script>
</head>

</head>
<body>
   <!-- REPLACE YOUR EXISTING <nav> BLOCK IN ALL THREE VIEWS WITH THIS SECURE VERSION -->
<nav style="width: 100%; max-width: 480px; margin: 0 auto 24px auto; background: #ffffff; padding: 12px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 10px 15px -3px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; display: flex; gap: 8px; box-sizing: border-box;">
    
    <!-- Tab 1: Terminal Link (Guards and Admins can ALWAYS see this) -->
    <a href="{{ route('gate.scanner') }}" style="flex: 1; text-align: center; padding: 10px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 8px; text-decoration: none; transition: all 0.15s ease; {{ request()->routeIs('gate.scanner') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">
        📟 Terminal
    </a>

    <!-- ⭐ SECURE SECURITY LOCK: Only render Dashboard and Users options if the user is an Admin -->
    @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- Tab 2: Dashboard Link -->
        <a href="{{ route('admin.dashboard') }}" style="flex: 1; text-align: center; padding: 10px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 8px; text-decoration: none; transition: all 0.15s ease; {{ request()->routeIs('admin.dashboard') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">
            📊 Dashboard
        </a>

        <!-- Tab 3: Users Control Link -->
        <a href="{{ route('users.index') }}" style="flex: 1; text-align: center; padding: 10px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 8px; text-decoration: none; transition: all 0.15s ease; {{ request()->routeIs('users.index') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">
            👤 Users
        </a>
    @endif
</nav>



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
            <!-- ✅ FIXED: The values now explicitly match what your controller expects -->
            <option value="Main Gate - Entrance">Main Gate (Entrance Gate)</option>
            <option value="Main Gate - Exit">Main Gate (Exit Gate)</option>
            
            <option value="Registrar Office">Registrar's Office</option>
            <option value="Dean Office">Dean's Office</option>
            <option value="Accounting Department">Accounting Department</option>
            <option value="University Library">University Library</option>
        </select>
    </div>



    <input type="file" id="qrFileInput" accept="image/*" style="display: none;">

    <!-- PLACE THIS INSTEAD OF YOUR OLD SCANNER CONTAINER CONTAINER -->
<div id="camera-viewport-wrap" style="display: none; width: 100%; max-width: 400px; margin: 0 auto 20px; background: #000; border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; position: relative;">
    <!-- NATIVE ELEMENT: Video stream maps straight to this element -->
    <video id="native-video-preview" autoplay playsinline style="width: 100%; height: auto; display: block; background: #000;"></video>
    
    <button type="button" id="close-camera-btn" style="width: 100%; padding: 12px; background: #ef4444; color: white; border: none; font-weight: 600; cursor: pointer; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
        ✕ Close Live Scanner
    </button>
</div>


    <div id="camera-viewport-wrap" style="display: none; width: 100%; background: #000; border-radius: 12px; overflow: hidden; margin-bottom: 20px; border: 1px solid #cbd5e1;">
    <div id="qr-reader" style="width: 100%;"></div>
    <button type="button" id="close-camera-btn" style="width: 100%; padding: 12px; background: #ef4444; color: white; border: none; font-weight: 600; cursor: pointer; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
        ✕ Close Live Scanner
    </button>
</div>

    <!-- Your File Upload Box Area -->
    <div id="original-dropzone" class="upload-zone" onclick="document.getElementById('qrFileInput').click()">
        <span class="upload-icon">📁</span>
        <span class="upload-text">Select Downloaded QR Pass File</span>
    </div>

    <!-- PLACE THIS RIGHT BELOW THE CLOSING </div> OF YOUR UPLOAD ZONE -->
<div id="camera-btn-wrap" class="form-group text-center" style="margin-top: 16px; margin-bottom: 0;">
    <button type="button" id="open-camera-btn" style="padding: 12px 20px; background-color: #0f172a; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; transition: background 0.15s ease;">
        📷 Open Phone Camera Scanner
    </button>
</div>


    <div id="result-box">Terminal standby engine active.</div>

    <div class="divider">Or Manual Input Entry</div>

    <div class="manual-box">
        <label for="tokenField">Pass Token ID Code</label>
        <div class="input-group">
            <input type="text" id="tokenField" placeholder="Paste token code here..." autocomplete="off">
            <button id="verifyBtn" onclick="verifyManualToken()" class="go-btn">Verify</button>
        </div>
    </div>
</div>


    <script>
    let localStreamTrack = null;
    let frameDetectionInterval = null;

    const fileSelector = document.getElementById('qrFileInput');
    const resultDisplay = document.getElementById('result-box');
    const openCameraBtn = document.getElementById('open-camera-btn');
    const closeCameraBtn = document.getElementById('close-camera-btn');
    const cameraViewportWrap = document.getElementById('camera-viewport-wrap');
    const originalDropzone = document.getElementById('original-dropzone');
    const cameraBtnWrap = document.getElementById('camera-btn-wrap');
    const tokenField = document.getElementById('tokenField');
    const videoPreviewElement = document.getElementById('native-video-preview');

    // =================================================================
    // NATIVE OFFLINE LIVE SCANNER CYCLE ENGINE
    // =================================================================
    if (openCameraBtn) {
        openCameraBtn.addEventListener('click', () => {
            if (!('BarcodeDetector' in window)) {
                alert("Browser Error: Native barcode detector engine is missing or disabled on this device software.");
                return;
            }

            if (originalDropzone) originalDropzone.style.display = 'none';
            if (cameraBtnWrap) cameraBtnWrap.style.display = 'none';
            if (cameraViewportWrap) cameraViewportWrap.style.display = 'block';

            resultDisplay.style.color = "#475569";
            resultDisplay.innerText = "Requesting device camera interface access...";

            // Access hardware video feeds natively without third party scripts
            navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: "environment" } } // Requests rear camera lens layout
            })
            .then((stream) => {
                localStreamTrack = stream;
                videoPreviewElement.srcObject = stream;
                resultDisplay.innerText = "Live tracking canvas stream active.";

                // Initialize native parsing engine matrix directly
                const qrDetectorEngine = new BarcodeDetector({ formats: ['qr_code'] });

                // Frame processor loop capturing images continuously
                frameDetectionInterval = setInterval(() => {
                    if (videoPreviewElement.readyState === videoPreviewElement.HAVE_ENOUGH_DATA) {
                        qrDetectorEngine.detect(videoPreviewElement)
                            .then((barcodes) => {
                                if (barcodes.length > 0) {
                                    const cleanToken = barcodes[0].rawValue.trim();
                                    const selectedLocation = document.getElementById("stationLocation").value;

                                    if (tokenField) tokenField.value = cleanToken;

                                    resultDisplay.style.color = "#10b981";
                                    resultDisplay.innerText = "Pass token matched natively! Routing...";

                                    stopNativeScanner();
                                    routeToVerify(cleanToken, selectedLocation);
                                }
                            })
                            .catch((err) => console.debug("Parsing loop interval trace skipped: ", err));
                    }
                }, 250); // Checks 4 frames per second to optimize battery consumption on devices
            })
            .catch((err) => {
                console.error("Native hardware stream failed:", err);
                alert("Hardware Blocked: Check permission flags or confirm address matches HTTPS protocol completely.");
                stopNativeScanner();
            });
        });
    }

    function stopNativeScanner() {
        // Halt analytical parsing timer arrays
        if (frameDetectionInterval) {
            clearInterval(frameDetectionInterval);
            frameDetectionInterval = null;
        }

        // Drop physical stream hardware connections cleanly
        if (localStreamTrack) {
            localStreamTrack.getTracks().forEach(track => track.stop());
            localStreamTrack = null;
        }

        if (videoPreviewElement) {
            videoPreviewElement.srcObject = null;
        }

        resetUI();
    }

    function resetUI() {
        if (cameraViewportWrap) cameraViewportWrap.style.display = 'none';
        if (originalDropzone) originalDropzone.style.display = 'block';
        if (cameraBtnWrap) cameraBtnWrap.style.display = 'block';
        
        resultDisplay.style.color = "#475569";
        resultDisplay.innerText = "Terminal standby engine active.";
    }

    if (closeCameraBtn) {
        closeCameraBtn.addEventListener('click', stopNativeScanner);
    }

    // =================================================================
    // PRE-EXISTING FILE SELECTOR IMAGE PROCESSOR UTILITIES
    // =================================================================
    if (fileSelector) {
        fileSelector.addEventListener('change', e => {
            if (!e.target.files || e.target.files.length === 0) return;
            
            const file = e.target.files[0];
            resultDisplay.style.color = "#cbd5e1";
            resultDisplay.innerText = "Analyzing file grid matrix layers...";

            const selectedLocation = document.getElementById("stationLocation").value;
            const filename = file.name;

            if (filename.startsWith("PASS_")) {
                const extractedToken = filename.replace("PASS_", "").split('.')[0];
                routeToVerify(extractedToken, selectedLocation);
                return;
            }

            const img = new Image();
            img.src = URL.createObjectURL(file);
            
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);
                
                URL.revokeObjectURL(img.src);
                
                if ('BarcodeDetector' in window) {
                    const detector = new BarcodeDetector({ formats: ['qr_code'] });
                    detector.detect(canvas)
                        .then(barcodes => {
                            if (barcodes.length > 0) {
                                resultDisplay.style.color = "#10b981";
                                resultDisplay.innerText = "Pass token matched via matrix! Routing...";
                                routeToVerify(barcodes[0].rawValue.trim(), selectedLocation);
                            } else {
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
    }

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


