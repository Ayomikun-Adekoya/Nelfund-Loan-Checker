<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NELFUND Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: float 25s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-30px, -30px) rotate(180deg); }
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 18px;
            opacity: 0.8;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section {
            grid-column: 1 / -1;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
            letter-spacing: 0.025em;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #ffffff;
            color: #111827;
            font-weight: 500;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
            transform: translateY(-2px);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
            font-family: 'Courier New', monospace;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.025em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a, #3730a3);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .status-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .status-tab {
            padding: 10px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .status-tab.active {
            background: #1e3a8a;
            color: white;
            border-color: #1e3a8a;
        }

        .bulk-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .bulk-upload-area:hover {
            border-color: #1e3a8a;
            background: rgba(30, 58, 138, 0.05);
        }

        .bulk-upload-area.dragover {
            border-color: #1e3a8a;
            background: rgba(30, 58, 138, 0.1);
        }

        .upload-icon {
            font-size: 48px;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .records-table th,
        .records-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .records-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: linear-gradient(135deg, #059669, #047857);
        }

        .notification.error {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            background: white;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover {
            background: #1e3a8a;
            color: white;
        }

        .pagination button.active {
            background: #1e3a8a;
            color: white;
            border-color: #1e3a8a;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-card.total .stat-number { color: #1e3a8a; }
        .stat-card.approved .stat-number { color: #059669; }
        .stat-card.pending .stat-number { color: #d97706; }
        .stat-card.rejected .stat-number { color: #dc2626; }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="header">
            <h1>🛡️ NELFUND Admin Dashboard</h1>
            <p>Manage loan applications and student records</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number" id="totalCount">0</div>
                <div class="stat-label">Total Applications</div>
            </div>
            <div class="stat-card approved">
                <div class="stat-number" id="approvedCount">0</div>
                <div class="stat-label">Approved</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-number" id="pendingCount">0</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card rejected">
                <div class="stat-number" id="rejectedCount">0</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Single Record Entry -->
            <div class="card">
                <h2>➕ Add Single Record</h2>
                <form id="singleRecordForm">
                    <div class="form-group">
                        <label for="matric">Matric Number</label>
                        <input type="text" id="matric" name="matric" required placeholder="e.g., UI/2020/001234">
                    </div>
                    
                    <div class="form-group">
                        <label for="trackingID">Tracking ID</label>
                        <input type="text" id="trackingID" name="trackingID" required placeholder="e.g., NELFUND123456">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="session">Session</label>
                            <select id="session" name="session" required>
                                <option value="">Select Session</option>
                                <option value="2020/2021">2020/2021</option>
                                <option value="2021/2022">2021/2022</option>
                                <option value="2022/2023">2022/2023</option>
                                <option value="2023/2024">2023/2024</option>
                                <option value="2024/2025">2024/2025</option>
                                <option value="2025/2026">2025/2026</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="batch">Batch</label>
                            <select id="batch" name="batch" required>
                                <option value="">Select Batch</option>
                                <option value="1">Batch 1</option>
                                <option value="2">Batch 2</option>
                                <option value="3">Batch 3</option>
                                <option value="4">Batch 4</option>
                                <option value="5">Batch 5</option>
                                <option value="6">Batch 6</option>
                                <option value="7">Batch 7</option>
                                <option value="8">Batch 8</option>
                                <option value="9">Batch 9</option>
                                <option value="10">Batch 10</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </div>
                </form>
            </div>

            <!-- Bulk Upload -->
            <div class="card">
                <h2>📂 Bulk Upload</h2>
                <div class="bulk-upload-area" id="bulkUploadArea">
                    <div class="upload-icon">📄</div>
                    <h3>Drop CSV file here or click to browse</h3>
                    <p>CSV format: matric,trackingID,session,batch,status</p>
                    <input type="file" id="csvFileInput" accept=".csv" style="display: none;">
                </div>
                
                <div class="form-group">
                    <label for="bulkData">Or paste CSV data:</label>
                    <textarea id="bulkData" placeholder="matric,trackingID,session,batch,status&#10;UI/2020/001234,NELFUND123456,2023/2024,1,approved&#10;UI/2020/001235,NELFUND123457,2023/2024,1,pending"></textarea>
                </div>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" id="processBulkBtn">Process Bulk Data</button>
                </div>
            </div>
        </div>

        <!-- Records Management -->
        <div class="card form-section">
            <h2>📋 Manage Records</h2>
            
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search by matric number, tracking ID, or status...">
            </div>
            
            <div class="status-tabs">
                <div class="status-tab active" data-status="all">All Records</div>
                <div class="status-tab" data-status="approved">Approved</div>
                <div class="status-tab" data-status="pending">Pending</div>
                <div class="status-tab" data-status="rejected">Rejected</div>
            </div>
            
            <div style="overflow-x: auto;">
                <table class="records-table">
                    <thead>
                        <tr>
                            <th>Matric Number</th>
                            <th>Tracking ID</th>
                            <th>Session</th>
                            <th>Batch</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTableBody">
                        <!-- Records will be loaded here -->
                    </tbody>
                </table>
            </div>
            
            <div class="pagination" id="pagination">
                <!-- Pagination buttons will be generated here -->
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Global variables
        let currentPage = 1;
        let currentStatus = 'all';
        let searchQuery = '';
        const recordsPerPage = 10;

        // Initialize dashboard
        $(document).ready(function() {
            loadRecords();
            updateStats();
            
            // Auto-uppercase inputs
            $('#matric, #trackingID').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });
        });

        // Single record form submission
        $('#singleRecordForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                matric: $('#matric').val().trim(),
                trackingID: $('#trackingID').val().trim(),
                session: $('#session').val(),
                batch: $('#batch').val(),
                status: $('#status').val()
            };
            
            // Validate all fields
            if (!formData.matric || !formData.trackingID || !formData.session || !formData.batch || !formData.status) {
                showNotification('All fields are required', 'error');
                return;
            }
            
            // Simulate API call - replace with actual endpoint
            addSingleRecord(formData);
        });

        // Bulk upload handling
        $('#bulkUploadArea').on('click', function() {
            $('#csvFileInput').click();
        });

        $('#csvFileInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type === 'text/csv') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#bulkData').val(e.target.result);
                };
                reader.readAsText(file);
            }
        });

        // Drag and drop
        $('#bulkUploadArea').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });

        $('#bulkUploadArea').on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });

        $('#bulkUploadArea').on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0 && files[0].type === 'text/csv') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#bulkData').val(e.target.result);
                };
                reader.readAsText(files[0]);
            }
        });

        // Process bulk data
        $('#processBulkBtn').on('click', function() {
            const csvData = $('#bulkData').val().trim();
            if (!csvData) {
                showNotification('Please provide CSV data', 'error');
                return;
            }
            
            processBulkData(csvData);
        });

        // Status tabs
        $('.status-tab').on('click', function() {
            $('.status-tab').removeClass('active');
            $(this).addClass('active');
            currentStatus = $(this).data('status');
            currentPage = 1;
            loadRecords();
        });

        // Search functionality
        $('#searchInput').on('input', function() {
            searchQuery = $(this).val().trim();
            currentPage = 1;
            loadRecords();
        });

        // Functions
        function addSingleRecord(data) {
            // Simulate API call - replace with actual endpoint
            setTimeout(() => {
                showNotification('Record added successfully!', 'success');
                $('#singleRecordForm')[0].reset();
                loadRecords();
                updateStats();
            }, 500);
        }

        function processBulkData(csvData) {
            const lines = csvData.split('\n').filter(line => line.trim());
            const records = [];
            
            // Skip header row if exists
            const startIndex = lines[0].toLowerCase().includes('matric') ? 1 : 0;
            
            for (let i = startIndex; i < lines.length; i++) {
                const columns = lines[i].split(',').map(col => col.trim());
                if (columns.length >= 5) {
                    records.push({
                        matric: columns[0],
                        trackingID: columns[1],
                        session: columns[2],
                        batch: columns[3],
                        status: columns[4].toLowerCase()
                    });
                }
            }
            
            if (records.length === 0) {
                showNotification('No valid records found in CSV data', 'error');
                return;
            }
            
            // Simulate bulk upload - replace with actual endpoint
            setTimeout(() => {
                showNotification(`${records.length} records processed successfully!`, 'success');
                $('#bulkData').val('');
                loadRecords();
                updateStats();
            }, 1000);
        }

        function loadRecords() {
            // Simulate loading records - replace with actual API call
            const sampleRecords = [
                { id: 1, matric: 'UI/2020/001234', trackingID: 'NELFUND123456', session: '2023/2024', batch: '1', status: 'approved' },
                { id: 2, matric: 'UI/2020/001235', trackingID: 'NELFUND123457', session: '2023/2024', batch: '1', status: 'pending' },
                { id: 3, matric: 'UI/2020/001236', trackingID: 'NELFUND123458', session: '2023/2024', batch: '2', status: 'rejected' },
                { id: 4, matric: 'UI/2020/001237', trackingID: 'NELFUND123459', session: '2022/2023', batch: '1', status: 'approved' },
                { id: 5, matric: 'UI/2020/001238', trackingID: 'NELFUND123460', session: '2023/2024', batch: '3', status: 'pending' }
            ];
            
            let filteredRecords = sampleRecords;
            
            // Filter by status
            if (currentStatus !== 'all') {
                filteredRecords = filteredRecords.filter(record => record.status === currentStatus);
            }
            
            // Filter by search query
            if (searchQuery) {
                filteredRecords = filteredRecords.filter(record => 
                    record.matric.toLowerCase().includes(searchQuery.toLowerCase()) ||
                    record.trackingID.toLowerCase().includes(searchQuery.toLowerCase()) ||
                    record.status.toLowerCase().includes(searchQuery.toLowerCase())
                );
            }
            
            displayRecords(filteredRecords);
            generatePagination(filteredRecords.length);
        }

        function displayRecords(records) {
            const tbody = $('#recordsTableBody');
            tbody.empty();
            
            const startIndex = (currentPage - 1) * recordsPerPage;
            const endIndex = startIndex + recordsPerPage;
            const paginatedRecords = records.slice(startIndex, endIndex);
            
            paginatedRecords.forEach(record => {
                const row = `
                    <tr>
                        <td>${record.matric}</td>
                        <td>${record.trackingID}</td>
                        <td>${record.session}</td>
                        <td>Batch ${record.batch}</td>
                        <td><span class="status-badge ${record.status}">${record.status}</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 6px 12px; font-size: 14px; margin-right: 8px;" onclick="editRecord(${record.id})">Edit</button>
                            <button class="btn btn-danger" style="padding: 6px 12px; font-size: 14px;" onclick="deleteRecord(${record.id})">Delete</button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
            
            if (paginatedRecords.length === 0) {
                tbody.append('<tr><td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">No records found</td></tr>');
            }
        }

        function generatePagination(totalRecords) {
            const totalPages = Math.ceil(totalRecords / recordsPerPage);
            const pagination = $('#pagination');
            pagination.empty();
            
            if (totalPages <= 1) return;
            
            // Previous button
            if (currentPage > 1) {
                pagination.append(`<button onclick="changePage(${currentPage - 1})">Previous</button>`);
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                pagination.append(`<button class="${activeClass}" onclick="changePage(${i})">${i}</button>`);
            }
            
            // Next button
            if (currentPage < totalPages) {
                pagination.append(`<button onclick="changePage(${currentPage + 1})">Next</button>`);
            }
        }

        function changePage(page) {
            currentPage = page;
            loadRecords();
        }

        function editRecord(id) {
            // Implement edit functionality
            showNotification('Edit functionality coming soon!', 'success');
        }

        function deleteRecord(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                // Simulate deletion - replace with actual API call
                setTimeout(() => {
                    showNotification('Record deleted successfully!', 'success');
                    loadRecords();
                    updateStats();
                }, 500);
            }
        }

        function updateStats() {
            // Simulate stats update - replace with actual API call
            $('#totalCount').text('150');
            $('#approvedCount').text('85');
            $('#pendingCount').text('45');
            $('#rejectedCount').text('20');
        }

        function showNotification(message, type) {
            const notification = $('#notification');
            notification.removeClass('success error').addClass(type);
            notification.text(message);
            notification.addClass('show');
            
            setTimeout(() => {
                notification.removeClass('show');
            }, 4000);
        }
    </script>
</body>

</html>