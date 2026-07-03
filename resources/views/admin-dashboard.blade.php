<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Security Admin Dashboard</title>
    <script src="{{ asset('chart.js') }}"></script>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background-color: #f1f5f9; margin: 0; padding: 30px; color: #1e293b; }
        .container { max-width: 1100px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
        .btn-group { display: flex; gap: 10px; }
        .stats-grid { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; flex: 1; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border-left: 5px solid #64748b; }
        .stat-card.active { border-left-color: #10b981; }
        .stat-card.pending { border-left-color: #f59e0b; }
        .stat-label { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px; }
        .stat-val { font-size: 28px; font-weight: 800; margin-top: 5px; color: #0f172a; }
        .table-card { background: white; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background: #f8fafc; padding: 15px; font-weight: 700; color: #64748b; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 11px; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge.pending { background: #fef3c7; color: #d97706; }
        .badge.checked_in { background: #d1fae5; color: #065f46; }
        .badge.checked_out { background: #f1f5f9; color: #475569; }
        
        /* Interactive Buttons */
        .primary-btn { background: #0f172a; color: white; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
        .print-btn { background: #10b981; color: white; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; }
        .logout-btn { background: #ef4444; color: white; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; }
        
        /* Pagination Display Components */
        .pagination-bar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-top: 15px; }
        .pagination-info { font-size: 13px; color: #64748b; font-weight: 500; }
        .pagination-btn { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .pagination-btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
        .pagination-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        @media print {
    body { background: white; padding: 0; color: black; }
    
    /* Hide menus, filters, buttons, and the top date selection box */
    .primary-btn, .print-btn, .logout-btn, #searchContainer, .pagination-bar, form, #dateFilterGroup { 
        display: none !important; 
    }
    
    .table-card { box-shadow: none; border: 1px solid #cbd5e1; }
    
    /* ⭐ CLEAN UP: We removed the forcing rules from here! ⭐ */
    
    /* This rule will now successfully hide rows that do not match your chosen dates */
    tr[data-date-hidden="true"] { 
        display: none !important; 
    }
}


        
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div>
                <h1>Campus Security Admin Log</h1>
                <div style="font-size: 13px; color: #64748b; margin-top: 4px;">State University Visitor Management Control</div>
            </div>
            <div class="btn-group" style="display: flex; align-items: center; gap: 15px;">
    <!-- ⭐ NEW: Date Range Selection Inputs Group ⭐ -->
    <div id="dateFilterGroup" style="display: flex; align-items: center; gap: 8px; background: white; padding: 6px 12px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border: 1px solid #cbd5e1;">
        <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">From:</label>
        <input type="date" id="startDate" style="border: none; outline: none; font-size: 13px; color: #334155; font-family: inherit;">
        
        <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-left: 5px;">To:</label>
        <input type="date" id="endDate" style="border: none; outline: none; font-size: 13px; color: #334155; font-family: inherit;">
        
        <button onclick="clearDateFilter()" style="background: none; border: none; color: #ef4444; font-weight: 700; cursor: pointer; font-size: 12px; padding: 0 5px;" title="Clear Dates">✕</button>
    </div>
                <button onclick="window.print()" class="print-btn">🖨️ Print Logs Report</button>
                <a href="{{ route('visitor.register') }}" class="primary-btn">+ Registration Portal</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Log Out</button>
                </form>
            </div>
        </div>

        <!-- Analytics counters box -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-label">Total Passes Issued</div>
                <div class="stat-val">{{ $totalRegistered }}</div>
            </div>
            <div class="stat-card active">
                <div class="stat-label">Currently On Campus</div>
                <div class="stat-val" style="color: #10b981;">{{ $currentlyInside }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Checked Out</div>
                <div class="stat-val">{{ $totalCheckedOut }}</div>
            </div>
        </div>


       <!-- Charts Visualization Row Grid -->
<div style="display: flex; gap: 20px; margin-bottom: 30px;">
    <!-- Bar Chart Container Box -->
    <div style="background: white; padding: 20px; border-radius: 16px; flex: 2; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 14px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Weekly Arrival Traffic Volume</h3>
        <div style="height: 210px; position: relative;"> <!-- 👈 CHANGED TO 210px -->
            <canvas id="trafficBarChart" width="600" height="210"></canvas>
        </div>
    </div>

    <!-- Pie Chart Container Box -->
    <div style="background: white; padding: 20px; border-radius: 16px; flex: 1; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 14px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Live Campus Status Share</h3>
        <div style="height: 210px; position: relative; display: flex; justify-content: center;"> <!-- 👈 CHANGED TO 210px -->
            <canvas id="statusPieChart" width="300" height="210"></canvas>
        </div>
    </div>
</div>




        <!-- Realtime filtering field container -->
        <div id="searchContainer" style="margin-bottom: 20px; display: flex; gap: 10px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); align-items: center;">
            <span style="font-size: 18px; color: #94a3b8;">🔍</span>
            <input type="text" id="dashboardSearch" placeholder="Search visitors by name, purpose, or location..." 
                style="width: 100%; border: none; font-size: 14px; color: #0f172a; outline: none; background: transparent;">
        </div>

        <!-- Logs database records panel container -->
        <div class="table-card">
            <table cellspacing="0">
    <thead>
        <tr>
            <!-- Added inline styles to force all headers to center perfectly -->
            <th style="text-align: center;">Visitor Name</th>
            <th style="text-align: center;">ID NUMBER</th>
            <th style="text-align: center;">Purpose of Visit</th>
            <th style="text-align: center;">Person Visiting</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;">Current Location</th>
            <th style="text-align: center;">Tracking History Timeline</th>
            <th style="text-align: center;">Checked In At</th>
            <th style="text-align: center;">Checked Out At</th>
            <th style="text-align: center;">ACTIONS</th>
        </tr>
    </thead>
    <tbody id="visitorTableBody">
        @forelse($allVisitors as $v)
            <tr class="visitor-row" data-date="{{ $v->created_at->format('Y-m-d') }}">
                <!-- Added text-align: center and vertical alignment centering -->
                <td style="text-align: center; vertical-align: middle;"><strong>{{ $v->full_name }}</strong></td>
                <td style="text-align: center; vertical-align: middle;">{{ $v->id_number ?? 'N/A' }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $v->purpose_of_visit }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $v->person_to_visit }}</td>
                <td style="text-align: center; vertical-align: middle;">
                    <span class="badge {{ $v->status }}">{{ $v->status }}</span>
                </td>
                <td style="text-align: center; vertical-align: middle;">{{ $v->current_location }}</td>
                
                <!-- History Timeline Column -->
                <td style="text-align: center; vertical-align: middle; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; border-bottom: none;">
                    @foreach($v->movements as $movement)
                        <div>{{ $movement->location_name }} <small style="display: block; color: #64748b;">({{ $movement->created_at->format('h:i A') }})</small></div>
                    @endforeach
                </td>

                <td style="text-align: center; vertical-align: middle;">{{ $v->checked_in_at ? $v->checked_in_at->format('M d, h:i A') : '—' }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $v->checked_out_at ? $v->checked_out_at->format('M d, h:i A') : '—' }}</td>
                
                <!-- Action Delete Button Centered -->
                <td style="text-align: center; vertical-align: middle;">
                    <form action="{{ route('admin.delete-visitor', $v->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this visitor record?');" style="margin:0; display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 11px; cursor: pointer;">
                            🗑️ Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" style="text-align: center; vertical-align: middle;">No visitor logs found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                <!-- Dynamic client-side layout navigator component -->
        <div class="pagination-bar">
            <div class="pagination-info">
                Showing 1 to {{ $allVisitors->count() }} of {{ $allVisitors->count() }} entries
            </div>
            <div class="btn-group">
                <button class="pagination-btn" disabled>Previous</button>
                <button class="pagination-btn" disabled>Next</button>
            </div>
        </div>

    </div> <!-- Close container -->

    <script>
        // Simple search filter script for the search bar
        document.getElementById('dashboardSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#visitorTableBody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                if(text.includes(filter)) {
                    row.style.display = '';
                } else {
                    if(!row.querySelector('td[colspan]')) {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>


<script>
    // ----------------------------------------------------
    // 1. SYSTEM PAGINATION & EXTENDED FILTERING STATE VARIABLES
    // ----------------------------------------------------
    const rowsPerPage = 5; 
    let currentPage = 1;
    let activeRows = [];

    // Main Extended Mapping Engine: Checks BOTH your search input text and calendar dates
    function initPaginationExtended() {
        const tableRows = Array.from(document.querySelectorAll('.visitor-row'));
        
        activeRows = tableRows.filter(row => 
            row.getAttribute('data-search-match') !== 'false' && 
            row.getAttribute('data-date-hidden') !== 'true'
        );
        
        currentPage = 1;
        renderTable();
    }

    // ----------------------------------------------------
    // 2. LIVE DATA TABLE RENDER VIEW MODULE
    // ----------------------------------------------------
    function renderTable() {
        const totalRecords = activeRows.length;
        const totalPages = Math.ceil(totalRecords / rowsPerPage) || 1;

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIdx = (currentPage - 1) * rowsPerPage;
        const endIdx = startIdx + rowsPerPage;

        // Hide every row first to clear the slate layout
        const masterRows = document.querySelectorAll('.visitor-row');
        masterRows.forEach(row => {
            row.style.display = "none";
        });

        // Slice out and display exactly 5 matching items for the current active page
        activeRows.slice(startIdx, endIdx).forEach(row => {
            row.style.display = "";
        });

        // Update the lower pagination entry numbers counter text
        const infoDisplay = document.getElementById('paginationInfo');
        if (infoDisplay) {
            if (totalRecords === 0) {
                infoDisplay.innerText = "Showing 0 to 0 of 0 entries";
            } else {
                const currentEnd = Math.min(endIdx, totalRecords);
                infoDisplay.innerText = `Showing ${startIdx + 1} to ${currentEnd} of ${totalRecords} entries`;
            }
        }

        // Handle disabled visual locked states for your previous/next action elements safely
        const prevButton = document.getElementById('prevBtn');
        if (prevButton) {
            prevButton.disabled = (currentPage === 1);
        }

        const nextButton = document.getElementById('nextBtn');
        if (nextButton) {
            nextButton.disabled = (currentPage === totalPages || totalRecords === 0);
        }
    }

    // Page selector button jumping switcher logic
    function changePage(direction) {
        currentPage += direction;
        renderTable();
    }

    // ----------------------------------------------------
    // 3. SECURE CALENDAR TIMESTAMP FILTER METHOD
    // ----------------------------------------------------
    function filterByDates() {
        const startInput = document.getElementById('startDate').value;
        const endInput = document.getElementById('endDate').value;
        
        // Convert to numerical timestamps to fix direct mathematical evaluation boundaries
        const startTime = startInput ? new Date(startInput + "T00:00:00").getTime() : null;
        const endTime = endInput ? new Date(endInput + "T23:59:59").getTime() : null;

        const rows = document.querySelectorAll('.visitor-row');

        rows.forEach(row => {
            const rowDateStr = row.getAttribute('data-date');
            if (!rowDateStr) return;

            const rowTime = new Date(rowDateStr + "T12:00:00").getTime();
            let isVisible = true;

            // Enforce calendar limits
            if (startTime && rowTime < startTime) isVisible = false;
            if (endTime && rowTime > endTime) isVisible = false;

            // Flag attributes matching our CSS print display controllers
            if (isVisible) {
                row.removeAttribute('data-date-hidden');
            } else {
                row.setAttribute('data-date-hidden', 'true');
            }
        });

        // Re-calculate the table pagination structure
        initPaginationExtended();
    }

    // Reset button handler clear routine
    function clearDateFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        
        document.querySelectorAll('.visitor-row').forEach(row => {
            row.removeAttribute('data-date-hidden');
        });
        
        initPaginationExtended();
    }

    // ----------------------------------------------------
    // 4. BIND EVENT LISTENERS & INITIATE SYSTEM
    // ----------------------------------------------------
    document.addEventListener("DOMContentLoaded", function() {
        // Wire up calendar selectors reactive loops
        document.getElementById('startDate').addEventListener('input', filterByDates);
        document.getElementById('endDate').addEventListener('input', filterByDates);

        // Wire up search input box key filter loop
        document.getElementById('dashboardSearch').addEventListener('keyup', function() {
            const searchQuery = this.value.toLowerCase().trim();
            const searchRows = document.querySelectorAll('.visitor-row');
            
            searchRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.setAttribute('data-search-match', rowText.includes(searchQuery) ? 'true' : 'false');
            });

            initPaginationExtended(); 
        });

        // Initialize active table grid layouts
        initPaginationExtended();

        // ----------------------------------------------------
        // 5. OFFLINE GRAPHICS CUSTOM CANVAS CHARTS LOADERS
        // ----------------------------------------------------
        const barCtx = document.getElementById('trafficBarChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Visitors Admitted',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: '#0f172a',
                    borderRadius: 6,
                }]
            }
        });

        const pieCtx = document.getElementById('statusPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Checked In', 'Checked Out', 'Pending'],
                datasets: [{
                    data: [{{ $currentlyInside }}, {{ $totalCheckedOut }}, {{ $totalPending }}],
                    backgroundColor: ['#10b981', '#64748b', '#f59e0b'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            }
        });
    });
</script>

