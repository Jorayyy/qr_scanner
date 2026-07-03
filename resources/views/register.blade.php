<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Visitor Registration</title>
    
    <!-- Clean offline layout styles that center everything and add a sleek theme -->
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            background-color: #f1f5f9; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px; 
            box-sizing: border-box;
        }
        .card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); 
            width: 100%; 
            max-width: 420px; 
            border-top: 8px solid #f59e0b; /* Nice university amber/gold accent border */
            box-sizing: border-box;
        }
        .logo-circle {
            background-color: #f59e0b;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
        }
        .logo-text {
            color: white;
            font-weight: bold;
            font-size: 24px;
        }
        .text-center {
            text-align: center;
            margin-bottom: 30px;
        }
        h1 { 
            font-size: 24px; 
            color: #1e293b; 
            margin: 0; 
            font-weight: 900; 
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .subtitle { 
            font-size: 14px; 
            color: #64748b; 
            margin: 6px 0 0 0; 
            font-weight: 500;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label { 
            display: block; 
            font-size: 11px; 
            font-weight: 700; 
            color: #475569; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #cbd5e1; 
            border-radius: 10px; 
            font-size: 14px;
            color: #0f172a;
            background-color: #f8fafc;
            box-sizing: border-box;
            transition: all 0.2s;
        }
        input:focus {
            outline: none;
            border-color: #f59e0b;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }
        input::placeholder {
            color: #94a3b8;
        }
        .submit-btn { 
            display: block; 
            width: 100%; 
            background: #0f172a; 
            color: white; 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 14px; 
            border: none; 
            cursor: pointer; 
            text-align: center; 
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 25px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
            transition: background 0.2s;
        }
        .submit-btn:hover { 
            background: #1e293b; 
        }
    </style>
</head>
<body>

    <div class="card">
        <!-- University Badge Icon -->
        <div class="text-center">
            <div class="logo-circle">
                <span class="logo-text">SU</span>
            </div>
            <h1>State University</h1>
            <p class="subtitle">Campus Visitor Log Registration</p>
        </div>

        <!-- Form sends data to our route handler -->
        <form action="{{ route('visitor.store') }}" method="POST">
            @csrf 

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" placeholder="09123456789" required>
            </div>
             
            <div class="form-group mb-3">
                <label for="id_number" class="form-label">ID NUMBER</label>
                <input type="text" name="id_number" id="id_number" class="form-control" placeholder="e.g., 2026-12345" required>
            </div>

            <div class="form-group">
                <label>Purpose of Visit</label>
                <input type="text" name="purpose_of_visit" placeholder="e.g., Registrar, Submission, Meeting" required>
            </div>

            <div class="form-group">
                <label>Person to Visit</label>
                <input type="text" name="person_to_visit" placeholder="e.g., Dr. Smith, Dean Office" required>
            </div>

            <button type="submit" class="submit-btn">
                Generate Visitor QR Pass
            </button>
        </form>
        
        <!-- Add onsubmit to your form tag -->
<form action="{{ route('visitor.store') }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled=true;">
    @csrf
    <!-- Your input fields here... -->
    
    <button type="submit" class="btn btn-primary">Register</button>
</form>

    </div>

</body>
</html>
