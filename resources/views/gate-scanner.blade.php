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
        <select id="stationLocation" class="form-select">
    <option value="Main Gate (Entrance Gate)">Main Gate (Entrance Gate)</option>
    <option value="Main Gate (Exit Gate)">Main Gate (Exit Gate)</option>
            
            <option value="Registrar Office">Registrar's Office</option>
            <option value="Dean Office">Dean's Office</option>
            <option value="Accounting Department">Accounting Department</option>
            <option value="University Library">University Library</option>
        </select>
    </div>



    <input type="file" id="qrFileInput" accept="image/*" style="display: none;">

    <!-- GCash Style Smart Instant Viewfinder Layout Container -->
<div id="camera-viewport-wrap" style="position: relative; width: 100%; max-width: 500px; margin: 0 auto; display: none;">
    <!-- Live Camera Feed Stream -->
    <video id="native-video-preview" style="width: 100%; height: auto; border-radius: 8px;" playsinline></video>
    
    <!-- Transparent Darkened Alignment Mask Layout Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 40px solid rgba(15, 23, 42, 0.65); border-radius: 8px; pointer-events: none;">
        <!-- Smart Centered Targeting Guide Box -->
        <div id="scan-target-box" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 220px; height: 220px; border: 3px solid #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); display: flex; align-items: center; justify-content: center;">
            <!-- Animated High-Speed Laser Line Element -->
            <div id="scan-laser-line" style="width: 100%; height: 2px; background-color: #10b981; box-shadow: 0 0 8px #10b981; position: absolute; animation: gcashLaserMove 2s linear infinite;"></div>
            <span id="scan-status-badge" style="color: #ffffff; font-size: 11px; font-weight: bold; background: #10b981; padding: 4px 10px; border-radius: 4px; position: absolute; bottom: 10px; text-transform: uppercase;">SCANNING ACTIVE</span>
        </div>
    </div>

    <button type="button" id="close-camera-btn" style="width: 100%; margin-top: 12px; padding: 12px; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
        ✕ Close Live Scanner
    </button>
</div>

<style>
    @keyframes gcashLaserMove { 0% { top: 0%; } 50% { top: 100%; } 100% { top: 0%; } }
</style>

    <!-- Your File Upload Box Area -->
    <div id="original-dropzone" class="upload-zone" onclick="document.getElementById('qrFileInput').click()">
        <span class="upload-icon">📁</span>
        <span class="upload-text">Select Downloaded QR Pass File</span>
    </div>

    <!-- PLACE THIS RIGHT BELOW THE CLOSING </div> OF YOUR UPLOAD ZONE -->
<div id="camera-btn-wrap" class="form-group text-center" style="margin-top: 16px; margin-bottom: 0;">
    <button type="button" id="open-camera-btn" style="padding: 12px 20px; background-color: #0f172a; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; transition: background 0.15s ease;">
        📷 Open Camera Scanner
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

@if(auth()->check() && auth()->user()->role === 'guard')
    <div style="margin-top: 25px; padding-top: 20px; display: flex; justify-content: center; width: 100%;">
        <a href="{{ url()->previous() }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; color: #4b5563; font-weight: 500; font-size: 14px; background: #f3f4f6; padding: 10px 24px; border-radius: 6px; border: 1px solid #e5e7eb; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
            <svg xmlns="http://w3.org" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
            Back to Guard Dashboard
        </a>
    </div>
@endif


@vite(['resources/js/gate-scanner.js'])
</body>
</html>


