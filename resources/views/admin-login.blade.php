<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System Authentication Security Lock</title>
    <style>
        body { font-family: -apple-system, sans-serif; background-color: #0f172a; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .login-card { background: #1e293b; padding: 40px; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3); max-width: 360px; width: 100%; border-top: 8px solid #f59e0b; text-align: center; }
        h1 { color: #f8fafc; font-size: 24px; margin: 0 0 5px; font-weight: 800; text-transform: uppercase; }
        p { color: #64748b; font-size: 13px; margin: 0 0 25px; }
        .input-group { text-align: left; margin-bottom: 20px; }
        label { display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; }
        input { width: 100%; padding: 12px; border: 1px solid #334155; border-radius: 10px; font-size: 14px; color: white; background: #0f172a; box-sizing: border-box; }
        input:focus { outline: none; border-color: #f59e0b; }
        .login-btn { width: 100%; background: #f59e0b; color: white; padding: 14px; border: none; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; text-transform: uppercase; margin-top: 10px; }
        .login-btn:hover { background: #d97706; }
        .alert { background: #fef2f2; color: #991b1b; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Admin Portal</h1>
        <p>Security authorization checkpoint required.</p>

        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Security Username</label>
                <input type="text" name="username" placeholder="e.g., admin" required autocomplete="off">
            </div>
            <div class="input-group">
                <label>Security Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="login-btn">Authorize Access</button>
        </form>
    </div>

</body>
</html>
