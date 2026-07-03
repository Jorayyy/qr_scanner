<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Security Admin Dashboard</title>
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
            .primary-btn, .print-btn, .logout-btn, #searchContainer, .pagination-bar, form { display: none !important; }
            .table-card { box-shadow: none; border: 1px solid #cbd5e1; }
            tr { display: table-row !important; } 
            .visitor-row { display: table-row !important; }
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
            <div class="btn-group">
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
                        <th>Visitor Name</th>
                        <th>ID NUMBER</th>
                        <th>Purpose of Visit</th>
                        <th>Person Visiting</th>
                        <th>Status</th>
                        <th>Current Location</th>
                        <th>Tracking History Timeline</th>
                        <th>Checked In At</th>
                        <th>Checked Out At</th>
                    </tr>
                </thead>
                <tbody id="visitorTableBody">
    @forelse($allVisitors as $v)
        <tr>
            <!-- 1. Name Column -->
            <td><strong>{{ $v->full_name }}</strong></td>
            
            <!-- 2. ID Number Column -->
            <td>{{ $v->id_number ?? 'N/A' }}</td>
            
            <!-- 3. Purpose Column -->
            <td>{{ $v->purpose_of_visit }}</td>
            
            <!-- 4. Person Visiting Column -->
            <td>{{ $v->person_to_visit }}</td>
            
            <!-- Check your remaining columns below to ensure they use $v instead of $visitor -->
            <td>{{ $v->status }}</td>

            <td>{{ $v->current_location }}</td>

            <td>
            <!-- Look at your original code for the timeline loop here. It probably looks like: -->
            @foreach($v->movements as $movement)
            <div>{{ $movement->location_name }} <small>({{ $movement->created_at->format('h:i A') }})</small></div>
            @endforeach
            </td>

            <!-- 8. Checked In At -->
           <td>{{ $v->checked_in_at ? $v->checked_in_at->format('M d, h:i A') : '—' }}</td>
    
           <!-- 9. Checked Out At -->
           <td>{{ $v->checked_out_at ? $v->checked_out_at->format('M d, h:i A') : '—' }}</td>
            
            <!-- ... your tracking history timeline and check-in times blocks ... -->
        </tr>
    @empty
        <tr>
            <td colspan="9" style="text-align: center;">No visitor logs found.</td>
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


    <!-- Combined Pagination + Live Filter Engine Script -->
    <script>
        const rowsPerPage = 5; // Change this to 10 if you want 10 per page!
        let currentPage = 1;
        let activeRows = [];

        // 1. Map rows and filter out search hidden items
        function initPagination() {
            const tableRows = Array.from(document.querySelectorAll('.visitor-row'));
            activeRows = tableRows.filter(row => row.getAttribute('data-search-match') !== 'false');
            currentPage = 1;
            renderTable();
        }

        // 2. Main Page Render Module
        function renderTable() {
            const totalRecords = activeRows.length;
            const totalPages = Math.ceil(totalRecords / rowsPerPage) || 1;

            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIdx = (currentPage - 1) * rowsPerPage;
            const endIdx = startIdx + rowsPerPage;

            // Hide absolutely every single row first
            const masterRows = document.querySelectorAll('.visitor-row');
            masterRows.forEach(row => {
                row.style.display = "none";
            });

            // Slice out and reveal ONLY the 5 rows for this specific page number
            activeRows.slice(startIdx, endIdx).forEach(row => {
                row.style.display = "";
            });

            // Update the record counter label text
            const infoDisplay = document.getElementById('paginationInfo');
            if (infoDisplay) {
                if (totalRecords === 0) {
                    infoDisplay.innerText = "Showing 0 to 0 of 0 entries";
                } else {
                    const currentEnd = Math.min(endIdx, totalRecords);
                    infoDisplay.innerText = `Showing ${startIdx + 1} to ${currentEnd} of ${totalRecords} entries`;
                }
            }

            // Lock or unlock button tags based on page position
            document.getElementById('prevBtn').disabled = (currentPage === 1);
            document.getElementById('nextBtn').disabled = (currentPage === totalPages || totalRecords === 0);
        }

        // 3. Page Swapper Handler
        function changePage(direction) {
            currentPage += direction;
            renderTable();
        }

        // 4. Live Keyup Search Filter Listener
        document.getElementById('dashboardSearch').addEventListener('keyup', function() {
            const searchQuery = this.value.toLowerCase().trim();
            const searchRows = document.querySelectorAll('.visitor-row');
            
            searchRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.setAttribute('data-search-match', rowText.includes(searchQuery) ? 'true' : 'false');
            });

            initPagination(); 
        });

        // Fire everything up when page loading finishes
        document.addEventListener("DOMContentLoaded", initPagination);
        
    </script>
