<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Security Authorization Result</title>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: #0f172a; /* Sleek dark terminal theme background */
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px; 
            box-sizing: border-box; 
        }
        .card { 
            background: #1e293b; 
            padding: 35px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); 
            text-align: center; 
            max-width: 400px; 
            width: 100%; 
            box-sizing: border-box;
            border-top: 10px solid {{ $success ? '#10b981' : '#ef4444' }}; /* Dynamic color border bar */
        }
        
        /* Dynamic Status Feedback Badges */
        .status-badge { 
            width: 72px; 
            height: 72px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 20px; 
            font-size: 32px; 
            font-weight: bold;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            background: {{ $success ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' }};
            color: {{ $success ? '#10b981' : '#ef4444' }};
            border: 2px solid {{ $success ? '#10b981' : '#ef4444' }};
        }

        h1 { 
            font-size: 26px; 
            margin: 0; 
            font-weight: 900; 
            color: #f8fafc; 
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        
        .message-box {
            font-size: 14px; 
            color: #94a3b8; 
            margin: 10px 0 25px 0; 
            line-height: 1.5;
            font-weight: 500;
        }

        /* Profile Data Block */
        .data-box { 
            text-align: left; 
            background: #0f172a; 
            padding: 20px; 
            border-radius: 16px; 
            font-size: 14px; 
            color: #cbd5e1; 
            border: 1px solid #334155;
            margin-bottom: 25px;
        }
        .data-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .data-row:last-child { margin-bottom: 0; }
        .label { font-weight: 700; color: #64748b; text-transform: uppercase; font-size: 10px; tracking-wide: 0.5px; }
        .val { font-weight: 600; color: #f1f5f9; }
        
        .action-btn { 
            display: block; 
            width: 100%; 
            background: #334155; 
            color: #f1f5f9; 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 13px; 
            border: none; 
            cursor: pointer; 
            text-align: center; 
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
        }
        .action-btn:hover { 
            background: #475569; 
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Status Indicator Icon Badge -->
        <div class="status-badge">
            {{ $success ? '✓' : '✕' }}
        </div>
        
        <h1>{{ $title }}</h1>
        <div class="message-box">{{ $message }}</div>

        <!-- Displays profile summaries only if a record was discovered -->
        @if($visitor)
            <div class="data-box">
                <div class="data-row"><span class="label">Visitor Profile</span> <span class="val">{{ $visitor->full_name }}</span></div>
                <div class="data-row"><span class="label">Purpose Logged</span> <span class="val">{{ $visitor->purpose_of_visit }}</span></div>
                <div class="data-row"><span class="label">Target Escort</span> <span class="val">{{ $visitor->person_to_visit }}</span></div>
                
                <!-- 🆕 NEW VEHICLE TYPE FIELD LINKED TO SECURITY SUMMARY -->
                <div class="data-row">
                    <span class="label">Vehicle Type</span> 
                    <span class="val">
                        @switch($visitor->vehicle_type)
                            @case('none') None (Pedestrian) @break
                            @case('motorcycle') Motorcycle @break
                            @case('tricycle') Tricycle @break
                            @case('car_sedan') Car / Sedan @break
                            @case('suv_van') SUV / Van @break
                            @case('bicycle') Bicycle @break
                            @default {{ ucfirst(str_replace('_', ' ', $visitor->vehicle_type)) }}
                        @endswitch
                    </span>
                </div>

                <div class="data-row">
                    <span class="label">Pass Status</span> 
                    <span class="val" style="color: {{ $success ? '#10b981' : '#ef4444' }}; text-transform: uppercase; font-size: 12px; font-weight:800;">
                        {{ str_replace('_', ' ', $visitor->status) }}
                    </span>
                </div>
            </div>
        @else
            <div class="data-box" style="text-align: center; color: #64748b; font-style: italic; padding: 25px 15px;">
                No university trace payload available.
            </div>
        @endif

        <a href="{{ route('gate.scanner') }}" class="action-btn">Return to Guard Terminal</a>
    </div>

</body>
</html>
