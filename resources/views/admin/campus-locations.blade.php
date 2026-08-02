<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'State University') }} - Campus Locations</title>
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

        nav {
            width: 100%;
            max-width: 620px;
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

        .card {
            width: 100%;
            max-width: 1180px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 24px;
            box-sizing: border-box;
        }

        h2 {
            margin: 0 0 8px 0;
            font-size: 26px;
            color: #0f172a;
        }

        .subtitle {
            margin: 0 0 24px 0;
            color: #64748b;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
        }

        input, select, textarea {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 12px;
            font: inherit;
            color: #0f172a;
            background: #ffffff;
            box-sizing: border-box;
        }

        textarea {
            min-height: 44px;
            resize: vertical;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 40px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1px solid transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: #0f172a;
            color: #ffffff;
        }

        .btn-secondary {
            background: #ffffff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .btn-danger {
            background: #ffffff;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .banner {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 600;
        }

        .banner-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
            font-size: 13px;
            vertical-align: top;
        }

        th {
            background: #f8fafc;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-size: 11px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-visit { background: #eff6ff; color: #1d4ed8; }
        .badge-scanner { background: #f5f3ff; color: #6d28d9; }
        .badge-shared { background: #ecfeff; color: #0e7490; }
        .badge-active { background: #f0fdf4; color: #166534; }
        .badge-inactive { background: #f8fafc; color: #64748b; }

        .row-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .location-row-editor {
            display: flex;
            gap: 12px;
            align-items: flex-end;
            justify-content: space-between;
            padding: 12px 14px;
        }

        .location-edit-form {
            flex: 1;
            min-width: 0;
        }

        .location-edit-grid {
            display: grid;
            grid-template-columns: 2.1fr 1fr 0.7fr 0.8fr 1.1fr;
            gap: 10px;
            align-items: end;
        }

        .location-delete-form {
            flex-shrink: 0;
        }

        .check {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #0f172a;
        }

        .empty-state {
            padding: 24px;
            text-align: center;
            color: #64748b;
        }

        @media (max-width: 760px) {
            body { padding: 16px; }
            nav { width: calc(100vw - 32px); max-width: none; }
            .grid { grid-template-columns: 1fr; }
            .card { padding: 18px; }
        }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('gate.scanner') }}" style="{{ request()->routeIs('gate.scanner') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">📟 Terminal</a>
    <a href="{{ route('admin.dashboard') }}" style="{{ request()->routeIs('admin.dashboard') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">📊 Dashboard</a>
    <a href="{{ route('users.index') }}" style="{{ request()->routeIs('users.index') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">👤 Users</a>
    <a href="{{ route('campus.locations.index') }}" style="{{ request()->routeIs('campus.locations.index') ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' }}">🗺️ Locations</a>
</nav>

<div class="card">
    <h2>Campus Locations</h2>
    <p class="subtitle">Manage the visitor destination list and scanner station locations used across the dashboard.</p>

    @if(session('success'))
        <div class="banner banner-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('campus.locations.store') }}" method="POST" style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #e2e8f0;">
        @csrf
        <div class="grid">
            <div class="form-group">
                <label for="name">Location Name</label>
                <input type="text" id="name" name="name" placeholder="e.g. Registrar" required>
            </div>
            <div class="form-group">
                <label for="usage_scope">Usage Scope</label>
                <select id="usage_scope" name="usage_scope" required>
                    <option value="visit">Visitor Destination</option>
                    <option value="scanner">Scanner Station</option>
                    <option value="shared">Shared</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Optional note for staff"></textarea>
            </div>
        </div>

        <label style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px;">
            <input type="checkbox" class="check" name="is_active" value="1" checked>
            <span style="font-size: 13px; font-weight: 600; color: #334155; text-transform: none; letter-spacing: 0;">Active</span>
        </label>

        <div>
            <button type="submit" class="btn btn-primary">Add Location</button>
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Scope</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campusLocations as $location)
                    <tr>
                        <td colspan="6" style="padding: 0;">
                            <div class="location-row-editor">
                                <form action="{{ route('campus.locations.update', $location) }}" method="POST" class="location-edit-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="location-edit-grid">
                                        <div class="form-group" style="margin: 0;">
                                            <label>Name</label>
                                            <input type="text" name="name" value="{{ $location->name }}" required>
                                        </div>
                                        <div class="form-group" style="margin: 0;">
                                            <label>Scope</label>
                                            <select name="usage_scope" required>
                                                <option value="visit" {{ $location->usage_scope === 'visit' ? 'selected' : '' }}>Visit</option>
                                                <option value="scanner" {{ $location->usage_scope === 'scanner' ? 'selected' : '' }}>Scanner</option>
                                                <option value="shared" {{ $location->usage_scope === 'shared' ? 'selected' : '' }}>Shared</option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="margin: 0;">
                                            <label>Sort</label>
                                            <input type="number" name="sort_order" value="{{ $location->sort_order }}" min="0">
                                        </div>
                                        <div class="form-group" style="margin: 0;">
                                            <label>Status</label>
                                            <label style="display: inline-flex; align-items: center; gap: 8px; margin: 0; text-transform: none; letter-spacing: 0; font-size: 13px; font-weight: 600;">
                                                <input type="checkbox" class="check" name="is_active" value="1" {{ $location->is_active ? 'checked' : '' }}>
                                                <span>{{ $location->is_active ? 'Active' : 'Inactive' }}</span>
                                            </label>
                                        </div>
                                        <div class="form-group" style="margin: 0;">
                                            <label>Description</label>
                                            <input type="text" name="description" value="{{ $location->description }}" placeholder="Optional note">
                                        </div>
                                    </div>
                                    <div class="row-actions" style="margin-top: 12px;">
                                        <button type="submit" class="btn btn-secondary">Save Changes</button>
                                    </div>
                                </form>

                                <form action="{{ route('campus.locations.destroy', $location) }}" method="POST" class="location-delete-form" onsubmit="return confirm('Delete this location?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No campus locations have been added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>