<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor QR Pass Generated</title>
    <style>
        body { font-family: -apple-system, sans-serif; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; }
        .card { background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); text-align: center; max-width: 350px; width: 100%; border-top: 8px solid #10b981; box-sizing: border-box; }
        .checkmark { width: 44px; height: 44px; background: #d1fae5; color: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-weight: bold; font-size: 20px; }
        h1 { font-size: 22px; color: #1e293b; margin: 0; font-weight: 800; }
        p { font-size: 13px; color: #94a3b8; margin: 5px 0 20px; }
        .qr-box { background: #ffffff; padding: 15px; display: inline-block; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
        .data-box { text-align: left; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #f1f5f9; font-size: 14px; color: #334155; margin-bottom: 20px; }
        .data-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .label { font-weight: bold; color: #94a3b8; text-transform: uppercase; font-size: 10px; }
        .val { font-weight: 600; color: #0f172a; }
        .token { font-family: monospace; font-size: 11px; color: #64748b; word-break: break-all; margin-top: 4px; }
        .download-btn { display: block; width: 100%; background: #0f172a; color: white; padding: 12px; border-radius: 10px; font-weight: bold; font-size: 14px; border: none; cursor: pointer; text-align: center; text-decoration: none; margin-bottom: 10px; transition: background 0.2s; }
        .download-btn:hover { background: #1e293b; }
        .back-link { display: inline-block; font-size: 12px; color: #d97706; font-weight: bold; text-decoration: none; text-transform: uppercase; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card">
        <div class="checkmark">✓</div>
        <h1>Registration Complete!</h1>
        <p style="color: #ef4444; font-weight: 600; margin-bottom: 15px;">⚠️ Valid for ONE-TIME entry only.</p>

        <!-- Container housing your pure text matrix layout block -->
        <div class="qr-box" id="qrCaptureArea">
            {!! $tableGrid !!}
        </div>

        <div class="data-box">
            <div class="data-row"><span class="label">Visitor</span> <span class="val">{{ $visitor->full_name }}</span></div>
            <div class="data-row"><span class="label">Visiting</span> <span class="val">{{ $visitor->person_to_visit }}</span></div>
            <div class="data-row"><span class="label">Purpose</span> <span class="val">{{ $visitor->purpose_of_visit }}</span></div>
            <div style="border-top: 1px solid #e2e8f0; margin: 10px 0;"></div>
            <div style="display: flex; flex-direction: column;">
                <span class="label">Pass Token ID</span> 
                <span class="token" id="tokenValue">{{ $visitor->qr_code_token }}</span>
            </div>
        </div>

        <!-- Re-added: Download Button Trigger -->
        <button onclick="downloadPassImage()" class="download-btn">DOWNLOAD QR PASS</button>
        <a href="{{ route('visitor.register') }}" class="back-link">← Register Another Visitor</a>
    </div>

    <!-- Smart browser script to save text grids as standalone image attachments with metadata -->
    <script>
        function downloadPassImage() {
            const table = document.querySelector("#qrCaptureArea table");
            const tokenText = document.getElementById("tokenValue").innerText;
            if (!table) return alert("System formatting error. Refresh the page.");

            const rows = table.querySelectorAll("tr");
            const cellSize = 20; 
            const canvas = document.createElement("canvas");
            canvas.width = 10 * cellSize; 
            canvas.height = 10 * cellSize;
            const ctx = canvas.getContext("2d");

            // Fill background canvas area
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Scan the textual blocks map and paint real image pixel structures
            rows.forEach((row, rIdx) => {
                const cells = row.querySelectorAll("td");
                cells.forEach((cell, cIdx) => {
                    const bgColor = window.getComputedStyle(cell).backgroundColor;
                    ctx.fillStyle = (bgColor === "rgb(15, 23, 42)" || bgColor === "#0f172a") ? "#0f172a" : "#ffffff";
                    ctx.fillRect(cIdx * cellSize, rIdx * cellSize, cellSize, cellSize);
                });
            });

            // Trigger standard browser asset attachment link download
            const link = document.createElement("a");
            link.href = canvas.toDataURL("image/png");
            
            // Encode the real token directly inside the filename so our offline engine can read it instantly!
            link.download = "PASS_" + tokenText + ".png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

</body>
</html>
