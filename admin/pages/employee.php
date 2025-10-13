<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            /* padding: 20px; */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            animation: slideDown 0.6s ease-out;
        }

        .header h1 {
            color: white;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1em;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-out 0.1s backwards;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .stat-value {
            color: #667eea;
            font-size: 2em;
            font-weight: 700;
        }

        .table-wrapper {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideUp 0.6s ease-out 0.2s backwards;
        }

        .table-header {
            padding: 25px;
            border-bottom: 2px solid #f5f5f5;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .table-header h2 {
            color: #333;
            font-size: 1.5em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            color: #666;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f9fafb;
            transform: scale(1.01);
            box-shadow: inset 0 0 10px rgba(102, 126, 234, 0.05);
        }

        td {
            padding: 16px 20px;
            color: #333;
        }

        .id-cell {
            color: #667eea;
            font-weight: 600;
            font-family: 'Monaco', monospace;
        }

        .name-cell {
            font-weight: 500;
            color: #222;
        }

        .username-cell {
            color: #888;
            font-size: 0.95em;
        }

        .position-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .department-tag {
            display: inline-block;
            background: #e0e7ff;
            color: #667eea;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8em;
            }

            table {
                font-size: 0.9em;
            }

            th,
            td {
                padding: 12px 10px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Employee Dashboard</h1>
            <p>Team Overview & Management</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Total Employees</div>
                <div class="stat-value" id="totalEmployees">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Departments</div>
                <div class="stat-value" id="totalDepts">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Positions</div>
                <div class="stat-value" id="totalPositions">0</div>
            </div>
        </div>

        <div class="table-wrapper">
            <div class="table-header">
                <h2>Employees</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Date Hired</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    <tr>
                        <td colspan="6" class="loading">
                            <div class="spinner"></div>
                            Loading employees...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        fetch("api/dashboard/show_employee.php")
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const tbody = document.getElementById("employeeTableBody");
                    tbody.innerHTML = "";

                    const departments = new Set();
                    const positions = new Set();

                    result.data.forEach((emp, index) => {
                        departments.add(emp.department);
                        positions.add(emp.position);

                        const tr = document.createElement("tr");
                        tr.style.animationDelay = (index * 0.05) + "s";
                        tr.innerHTML = `
              <td class="id-cell">#${emp.id}</td>
              <td class="name-cell">${emp.full_name}</td>
              <td class="username-cell">@${emp.username}</td>
              <td><span class="position-badge">${emp.position}</span></td>
              <td><span class="department-tag">${emp.department}</span></td>
              <td>${new Date(emp.date_hired).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</td>
            `;
                        tbody.appendChild(tr);
                    });

                    document.getElementById("totalEmployees").textContent = result.data.length;
                    document.getElementById("totalDepts").textContent = departments.size;
                    document.getElementById("totalPositions").textContent = positions.size;
                } else {
                    document.getElementById("employeeTableBody").innerHTML =
                        '<tr><td colspan="6" class="loading">Failed to load employees. Please try again.</td></tr>';
                    console.error("Failed to load employees.");
                }
            })
            .catch(err => {
                document.getElementById("employeeTableBody").innerHTML =
                    '<tr><td colspan="6" class="loading">Error loading data. Please check your connection.</td></tr>';
                console.error("Error fetching data:", err);
            });
    </script>
</body>

</html>