<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - User Management</title>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            background-color: #f8fafc; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: flex-start; 
            min-height: 100vh; 
            margin: 0; 
            padding: 24px; 
            box-sizing: border-box;
            color: #0f172a;
        }
        
        /* Locate this section near Line 33 inside resources/views/admin/users/index.blade.php */
            nav {
            width: 100%; 
            max-width: 480px; /* 👈 CHANGE THIS FROM 600px TO 480px */
            margin: 0 auto 24px auto; 
            background: #ffffff; 
            padding: 12px; 
            border-radius: 16px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 10px 15px -3px rgba(0,0,0,0.02); 
            border: 1px solid #e2e8f0; 
            display: flex; 
            gap: 8px; 
            box-sizing: border-box;
       }

        nav a {
            flex: 1; 
            text-align: center; 
            padding: 10px; 
            font-size: 12px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
            border-radius: 8px; 
            text-decoration: none; 
            transition: all 0.15s ease;
        }
        .nav-inactive { background: #f1f5f9; color: #475569; }
        .nav-active { background: #0f172a; color: #ffffff; }

        .card { 
            background: #ffffff; 
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 10px 30px -5px rgba(0, 0, 0, 0.03); 
            width: 100%; 
            max-width: 600px; 
            border: 1px solid #e2e8f0;
            box-sizing: border-box;
        }
        h2 { font-size: 20px; color: #0f172a; margin: 0 0 6px 0; font-weight: 700; letter-spacing: -0.5px; }
        h3 { font-size: 15px; color: #0f172a; margin: 24px 0 12px 0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .subtitle { font-size: 13px; color: #64748b; margin: 0 0 24px 0; font-weight: 400; }
        
        .form-group { margin-bottom: 16px; text-align: left; }
        label { display: block; font-size: 11px; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        
        select, input { 
            width: 100%; height: 42px; padding: 0 14px; border: 1px solid #cbd5e1; border-radius: 8px; 
            font-size: 14px; color: #0f172a; background-color: #ffffff; box-sizing: border-box; 
            transition: all 0.15s ease; outline: none; font-family: inherit;
        }
        select:focus, input:focus { border-color: #0f172a; box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06); }
        
        .go-btn { 
            display: inline-flex; align-items: center; justify-content: center; background: #0f172a; 
            color: white; border: none; width: 100%; height: 42px; border-radius: 8px; 
            font-weight: 600; font-size: 13px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px;
            transition: background 0.15s ease;
        }
        .go-btn:hover { background: #1e293b; }

        /* User Profile Items */
        .user-item {
            display: flex; justify-content: space-between; align-items: center; 
            padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 10px;
        }
        .user-info strong { font-size: 14px; color: #0f172a; display: block; }
        .user-info span { font-size: 12px; color: #64748b; }
        .role-badge {
            display: inline-block; padding: 2px 8px; font-size: 10px; font-weight: 700; 
            text-transform: uppercase; border-radius: 6px; letter-spacing: 0.5px; margin-top: 4px;
        }
        .badge-admin { background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; }
        .badge-guard { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        .action-group { display: flex; gap: 8px; align-items: center; }
        .edit-select { height: 32px; font-size: 12px; padding: 0 8px; width: auto; }
        .del-btn {
            background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; padding: 0 12px; 
            height: 32px; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; text-transform: uppercase;
        }
        .del-btn:hover { background: #ffe4e6; }
        
        /* Message Banner */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; margin-bottom: 20px; text-align: center; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
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
        <h2>User Account Management</h2>
        <p class="subtitle">Create and configure credentials for security guards and administrators</p>

        <!-- Dynamic Success Message Banner -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- 1. ACCOUNT SUBMISSION FORM BLOCK -->
        <form action="{{ route('users.store') }}" method="POST" style="margin-bottom: 32px; border-bottom: 1px solid #e2e8f0; padding-bottom: 24px;">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="e.g. Officer Juan Dela Cruz" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="username@university.edu.ph" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">Account Password</label>
                <input type="password" id="password" name="password" required placeholder="Minimum 8 characters">
            </div>

            <div class="form-group">
                <label for="role">System Access Role Clearance</label>
                <select id="role" name="role">
                    <option value="guard">Gate Guard (Terminal Scanner Only)</option>
                    <option value="admin">System Administrator (Full Dashboard Controls)</option>
                </select>
            </div>

            <button type="submit" class="go-btn">+ Save System Account</button>
        </form>

        <!-- 2. REGISTERED ROSTER ACCOUNT SYSTEM GRID LIST LOOP -->
        <h3>Active Accounts Roster</h3>
        <div style="display: flex; flex-direction: column;">
            @foreach($users as $user)
                <div class="user-item">
                    <div class="user-info">
                        <strong>{{ $user->name }}</strong>
                        <span>{{ $user->email }}</span>
                        <div>
                            <span class="role-badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-guard' }}">
                                {{ $user->role }}
                            </span>
                        </div>
                    </div>

                    <div class="action-group">
    <!-- Inline Clearance Level Selector Update Form -->
    <form action="{{ route('users.update', $user->id) }}" method="POST" style="margin: 0;">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        
        <select name="role" class="edit-select" onchange="this.form.submit()">
            <option value="guard" {{ $user->role == 'guard' ? 'selected' : '' }}>Guard</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </form>

    <!-- Prevent accidental self-deletion lockout events -->
    @if($user->id !== auth()->id())
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you completely sure you want to permanently delete this account?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="del-btn">Remove</button>
        </form>
    @endif
</div>

                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
