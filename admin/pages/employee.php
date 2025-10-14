<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Employee List</h1>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Full Name
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Position</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Department
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Date Hired
                            </th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody" class="divide-y divide-gray-200">
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <span class="iconify inline-block text-4xl mb-2 animate-spin"
                                    data-icon="svg-spinners:ring-resize"></span>
                                <div>Loading employees...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Component -->
            <div id="paginationContainer"></div>
        </div>
    </div>
</div>

<script src="./utils/"></script>
<script>
    let currentPage = 1;
    let totalPages = 1;
    const perPage = 18;

    function loadEmployees(page) {
        const params = new URLSearchParams({
            "paging_options[page]": page,
            "paging_options[per_page]": perPage,
            "filters[0][property]": "status_id",
            "filters[0][value]": 1
        });

        fetch("api/dashboard/show_employee.php?" + params.toString())
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    console.log("🚀 ~ result.success && result.data:", result.success && result.data);
                    const tbody = document.getElementById("employeeTableBody");
                    tbody.innerHTML = "";

                    result.data.employees.forEach(emp => {
                        const tr = document.createElement("tr");
                        tr.className = "hover:bg-gray-50 transition-colors";
                        tr.innerHTML = `
                            <td class="px-6 py-4 text-indigo-600 font-semibold font-mono">#${emp.id}</td>
                            <td class="px-6 py-4 text-gray-900 font-medium">${emp.full_name}</td>
                            <td class="px-6 py-4 text-gray-500">@${emp.username}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    ${emp.position}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    ${emp.department}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">${new Date(emp.date_hired).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</td>
                        `;
                        tbody.appendChild(tr);
                    });

                    // Update pagination
                    const total = result.data.total_count || result.data.employees.length;
                    totalPages = Math.ceil(total / perPage);
                    currentPage = page;

                    const showingFrom = (page - 1) * perPage + 1;
                    const showingTo = Math.min(page * perPage, total);

                    // Render pagination component
                    renderPagination({
                        currentPage: currentPage,
                        totalPages: totalPages,
                        showingFrom: showingFrom,
                        showingTo: showingTo,
                        totalRecords: total,
                        showPageNumbers: true,
                        onPrevious: () => {
                            if (currentPage > 1) {
                                loadEmployees(currentPage - 1);
                            }
                        },
                        onNext: () => {
                            if (currentPage < totalPages) {
                                loadEmployees(currentPage + 1);
                            }
                        },
                        onPageClick: (page) => {
                            loadEmployees(page);
                        }
                    });
                } else {
                    document.getElementById("employeeTableBody").innerHTML =
                        '<tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No employees found.</td></tr>';
                }
            })
            .catch(err => {
                document.getElementById("employeeTableBody").innerHTML =
                    '<tr><td colspan="6" class="px-6 py-12 text-center text-red-500">Error loading data. Please try again.</td></tr>';
                console.error("Error fetching data:", err);
            });
    }

    // Initial load
    loadEmployees(1);
</script>