<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Security Admin Dashboard</title>
    <script src="{{ asset('chart.js') }}"></script>
    <script src="https://unpkg.com"></script>

    
    <style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background-color: #f8fafc; margin: 0; padding: 30px; color: #0f172a; }
    .container { max-width: 1100px; margin: 0 auto; }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; color: #0f172a; }
    .btn-group { display: flex; gap: 8px; align-items: center; }
    .stats-grid { display: flex; gap: 20px; margin-bottom: 30px; }
    
    /* Clean, Professional Summary Cards */
    .stat-card { background: white; padding: 20px; border-radius: 8px; flex: 1; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .stat-label { font-size: 11px; text-transform: uppercase; font-weight: 600; color: #64748b; letter-spacing: 0.5px; }
    .stat-val { font-size: 24px; font-weight: 700; margin-top: 5px; color: #0f172a; }
    
    /* Table Styling */
    .table-card { background: white; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
    th { background: #f1f5f9; padding: 12px 16px; font-weight: 600; color: #475569; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
    td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    
    /* Professional Muted Badges (No bright neon colors) */
    .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; border: 1px solid transparent; }
    .badge.pending { background: #f8fafc; color: #475569; border-color: #cbd5e1; }
    .badge.checked_in { background: #f1f5f9; color: #0f172a; border-color: #94a3b8; }
    .badge.checked_out { background: #ffffff; color: #64748b; border-color: #e2e8f0; }

    /* Interactive Buttons - High-End Minimalist Black & White Theme */
    .primary-btn { background: #0f172a; color: #ffffff; border: 1px solid #0f172a; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; box-sizing: border-box; transition: background 0.15s ease; white-space: nowrap !important; line-height: 38px !important; }
    .primary-btn:hover { background: #1e293b; border-color: #1e293b; }
    
    .print-btn { background: #ffffff; color: #334155; border: 1px solid #cbd5e1; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-sizing: border-box; transition: background 0.15s ease; white-space: nowrap !important; line-height: 38px !important; }
    .print-btn:hover { background: #f8fafc; border-color: #94a3b8; }
    
    .logout-btn { background: #ffffff; color: #334155; border: 1px solid #cbd5e1; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-sizing: border-box; transition: all 0.15s ease; white-space: nowrap !important; line-height: 38px !important; }
    .logout-btn:hover { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }

    /* Modernized Date Picker Layout Box */
    #dateFilterGroup { display: inline-flex; align-items: center; height: 38px; gap: 8px; background: white; padding: 0 12px; border-radius: 6px; border: 1px solid #cbd5e1; box-sizing: border-box; }
    #dateFilterGroup label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; }
    
    /* Strip Default Browser Windows Styles from Inputs & Lock Center Baseline */
    #dateFilterGroup input[type="date"] { 
        border: none; 
        outline: none; 
        font-size: 13px; 
        color: #334155; 
        font-family: inherit; 
        background: transparent; 
        padding: 0;
        margin: 0;
        display: inline-flex;
        align-items: center;
        height: 100%; 
    }
    
    #dateFilterGroup button { background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0 4px; display: inline-flex; align-items: center; justify-content: center; transition: color 0.15s ease; }
    #dateFilterGroup button:hover { color: #ef4444; }

    /* Force absolute vertical centering for Chrome/Edge date pickers */
    #dateFilterGroup input[type="date"]::-webkit-calendar-picker-indicator,
    #dateFilterGroup input[type="date"]::-webkit-datetime-edit,
    #dateFilterGroup input[type="date"]::-webkit-datetime-edit-fields-wrapper,
    #dateFilterGroup input[type="date"]::-webkit-datetime-edit-text,
    #dateFilterGroup input[type="date"]::-webkit-datetime-edit-month-field,
    #dateFilterGroup input[type="date"]::-webkit-datetime-edit-day-field,
    #dateFilterGroup input[type="date"]::-webkit-datetime-edit-year-field {
        display: inline-flex !important;
        align-items: center !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }

    #dateFilterGroup input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        vertical-align: middle !important;
    }

    /* Form display handler */
    .logout-form-wrapper { margin: 0; display: inline-flex; align-items: center; }

    /* Table Action Delete Button */
    .action-delete-btn { background: #ffffff; color: #475569; border: 1px solid #e2e8f0; padding: 6px 10px; border-radius: 4px; font-weight: 500; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: all 0.15s ease; }
    .action-delete-btn:hover { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
    
    /* Pagination Components */
    .pagination-bar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 12px 24px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 15px; }
    .pagination-info { font-size: 13px; color: #64748b; font-weight: 500; }
    .pagination-btn { background: #ffffff; color: #334155; border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .pagination-btn:hover:not(:disabled) { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; }
    .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; background: #f1f5f9; color: #94a3b8; }

    @media print {
        body { background: white; padding: 0; color: black; }
        .primary-btn, .print-btn, .logout-btn, #searchContainer, .pagination-bar, form, #dateFilterGroup { display: none !important; }
        .table-card { box-shadow: none; border: 1px solid #cbd5e1; }
        tr[data-date-hidden="true"] { display: none !important; }
    }

    /* Master Action Center Positioning for the Button Bar */
.btn-group {
    display: flex;
    gap: 8px;
    align-items: center;
}

/* Centered Modal Popup Window Backdrop */
.date-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.3); /* Premium soft dark blur background */
    backdrop-filter: blur(4px);
    display: none; /* Hidden by default system rules */
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Premium Floating Center Modal Box Control */
.date-modal-card {
    background: #ffffff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    max-width: 420px;
    width: 100%;
    animation: modalFadeIn 0.2s ease-out;
}

.date-modal-title {
    margin: 0 0 16px 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
}

.date-modal-inputs {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

.date-input-field-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.date-input-field-group label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
}

.date-input-field-group input[type="date"] {
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 0 12px;
    font-size: 14px;
    color: #334155;
    outline: none;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
}

.date-input-field-group input[type="date"]:focus {
    border-color: #0f172a;
}

.date-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

</style>

</head>
<body>

    <div class="container">
    <div class="header">
        <div>
    <!-- Reads the SYSTEM_SUBTITLE from .env, defaults back to "Campus Security Admin Log" if empty -->
    <h1>{{ env('SYSTEM_SUBTITLE', 'Campus Security Admin Log') }}</h1>
    
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
        {{ env('APP_NAME', 'Laravel') }} {{ env('SYSTEM_DEPARTMENT', 'Visitor Management Control') }}
    </div>
</div>
        
        <div class="btn-group">
            <!-- Print Logs button now opens the prompt center map logic -->
            <button onclick="openPrintModal()" class="print-btn">
                <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>Print Logs Report
            </button>

            <a href="{{ route('visitor.register') }}" class="primary-btn">
                <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>Registration Portal
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form-wrapper">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- ⭐ HIDDEN POPUP MODAL CENTER BOX SYSTEM ⭐ -->
    <div id="printModalOverlay" class="date-modal-overlay">
        <div class="date-modal-card">
            <h3 class="date-modal-title">Select Log Date Range</h3>
            
            <div class="date-modal-inputs">
                <div class="date-input-field-group">
                    <label>From Date</label>
                    <input type="date" id="startDate">
                </div>
                <div class="date-input-field-group">
                    <label>To Date</label>
                    <input type="date" id="endDate">
                </div>
            </div>
            
            <div class="date-modal-footer">
                <!-- Cancel Close Action Button -->
                <button onclick="closePrintModal()" class="print-btn" style="height: 34px; padding: 0 12px;">Cancel</button>
                <!-- Proceed Action Print Button -->
                <button onclick="triggerSystemPrint()" class="primary-btn" style="height: 34px; padding: 0 12px;">Proceed to Print</button>
            </div>
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
            <div class="stat-val" style="color: #0f172a;">{{ $currentlyInside }}</div>
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
<div id="searchContainer" style="margin-bottom: 20px; display: flex; gap: 10px; background: white; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); align-items: center;">
    
    <!-- Flat Vector Line Search Icon (Guaranteed to render) -->
    <svg xmlns="http://w3.org" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; display: block;">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    
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
                        <button class="action-delete-btn">
    <!-- Flat Vector Line Trash Icon (Guaranteed to render) -->
    <svg xmlns="http://w3.org" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
        <path d="M3 6h18"></path>
        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
    </svg>
    Delete
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

        document.addEventListener("DOMContentLoaded", function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        } else {
            console.error("Lucide script failed to load from the network link.");
        }
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

    // Opens the centering date picker overlay prompt layout box
function openPrintModal() {
    document.getElementById('printModalOverlay').style.display = 'flex';
}

// Closes the modal popup box field window safely
function closePrintModal() {
    document.getElementById('printModalOverlay').style.display = 'none';
}

// Triggers the system print sheet output logic directly
function triggerSystemPrint() {
    // Hidden backdrop closes automatically right before print processes spawn
    closePrintModal();
    
    // Slight micro delay timeout engine ensures modal closes before browser prints
    setTimeout(function() {
        window.print();
    }, 150);
}

</script>

