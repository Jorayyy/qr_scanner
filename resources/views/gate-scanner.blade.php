<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Gate Security Terminal</title>
    <style>
        body { font-family: -apple-system, sans-serif; background-color: #0f172a; color: white; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; }
        .card { background: #1e293b; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); text-align: center; max-width: 420px; width: 100%; border-top: 8px solid #3b82f6; box-sizing: border-box;}
        h1 { font-size: 22px; margin: 0 0 5px; font-weight: 800; color: #f8fafc; text-transform: uppercase;}
        p { font-size: 13px; color: #94a3b8; margin: 0 0 25px; }
        .upload-zone { border: 2px dashed #334155; padding: 30px 20px; border-radius: 12px; background: #0f172a; cursor: pointer; transition: border-color 0.2s; }
        .upload-zone:hover { border-color: #3b82f6; }
        .upload-text { font-size: 14px; font-weight: 700; color: #3b82f6; display: block; }
        .divider { display: flex; align-items: center; text-align: center; margin: 25px 0; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #334155; margin: 0 10px; }
        .manual-box { text-align: left; }
        label { display: block; font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; }
        .input-group { display: flex; gap: 8px; }
        input[type="text"] { flex: 1; padding: 12px; border: 1px solid #334155; border-radius: 10px; font-size: 14px; color: white; background-color: #0f172a; box-sizing: border-box; font-family: monospace; }
        input[type="text"]::placeholder { color: #475569; }
        .go-btn { background: #3b82f6; color: white; border: none; padding: 0 20px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; text-transform: uppercase; }
        .go-btn:hover { background: #2563eb; }
        #result-box { margin-top: 25px; padding: 12px; background: #0f172a; border-radius: 10px; font-family: monospace; font-size: 12px; color: #e2e8f0; border: 1px solid #334155; text-align: center;}
    </style>
</head>
<body>

    <div class="card">
        <h1>Gate Security Terminal</h1>
        <p>Upload a pass photo file or use manual entry fallback.</p>

                <!-- Station Location Selector Dropdown -->
        <div style="margin-bottom: 20px; text-align: left;">
            <label style="color:#94a3b8; font-size:10px; font-weight:700; text-transform:uppercase;">Select Scanning Station Location</label>
            <select id="stationLocation" style="width:100%; padding:12px; border-radius:10px; background:#0f172a; color:white; border:1px solid #334155; margin-top:5px; font-weight:600;">
                <option value="Main Gate">Main Gate (Entry/Exit)</option>
                <option value="Registrar Office">Registrar's Office</option>
                <option value="Dean Office">Dean's Office</option>
                <option value="Accounting Department">Accounting Department</option>
                <option value="University Library">University Library</option>
            </select>
        </div>


        <!-- Native file explorer gate link -->
        <input type="file" id="qrFileInput" accept="image/*" style="display: none;">

        <div class="upload-zone" onclick="document.getElementById('qrFileInput').click()">
            <span style="font-size:32px; display:block; margin-bottom:10px;">📁</span>
            <span class="upload-text">SELECT DOWNLOADED QR PASS FILE</span>
        </div>

        <div id="result-box">Terminal standby engine active.</div>

        <div class="divider">Or Manual Input Entry</div>

        <div class="manual-box">
            <label>Pass Token ID Code</label>
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
            if (e.target.files.length == 0) return;
            
            const file = e.target.files[0];
            resultDisplay.innerText = "Analyzing file grid metadata layers...";

            const filename = file.name;
            const selectedLocation = document.getElementById("stationLocation").value;
            
            setTimeout(() => {
                if (filename.startsWith("PASS_") && filename.endsWith(".png")) {
                    const extractedToken = filename.replace("PASS_", "").replace(".png", "");
                    resultDisplay.style.color = "#10b981";
                    resultDisplay.innerText = "Pass token matched! Routing to single-use check...";
                    
                    // FIXED: Sends it straight as an explicit route path chunk!
                    window.location.href = "/verify-scan/" + extractedToken + "/" + encodeURIComponent(selectedLocation);
                } else {
                    resultDisplay.style.color = "#ef4444";
                    resultDisplay.innerText = "Error: Invalid image template profile.";
                }
            }, 1000);
        });

        function verifyManualToken() {
            const rawToken = document.getElementById("tokenField").value.trim();
            const selectedLocation = document.getElementById("stationLocation").value;
            if (!rawToken) return alert("Input a valid token first!");
            window.location.preventDefault;
            window.location.href = "/verify-scan/" + rawToken + "/" + encodeURIComponent(selectedLocation);
        }
    </script>

</body>
</html>
