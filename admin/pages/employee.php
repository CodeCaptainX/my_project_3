<div class="bg-gradient-to-br from-slate-50 to-slate-100 h-full ">
    <div class="p-2">
        <!-- Header with Filters -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="mdi:users-group" style="font-size: 24px; color: #4f46e5;"></iconify-icon>
                        <h1 class="text-lg font-bold text-gray-900">Employee Directory</h1>
                    </div>
                    <span class="text-xs font-semibold bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full"
                        id="totalCount">0 Staff</span>
                </div>

                <!-- Search & Filter Bar -->
                <div class="flex flex-col sm:flex-row gap-2">
                    <div class="flex-1 relative">
                        <iconify-icon icon="mdi:magnify"
                            style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 18px;"></iconify-icon>
                        <input type="text" id="searchInput" placeholder="Search by name or username..."
                            class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <select id="departmentFilter"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white cursor-pointer">
                        <option value="">All Departments</option>
                    </select>
                    <select id="positionFilter"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white cursor-pointer">
                        <option value="">All Positions</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class=" bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-lg text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Name</th>
                            <th class="px-4 py-3 text-left font-semibold">Username</th>
                            <th class="px-4 py-3 text-left font-semibold">Position</th>
                            <th class="px-4 py-3 text-left font-semibold">Department</th>
                            <th class="px-4 py-3 text-left font-semibold">Hired</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody" class="divide-y divide-gray-100">
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                <div class="flex items-center justify-center gap-2">
                                    <iconify-icon icon="mdi:loading" style="font-size: 20px;"
                                        class="animate-spin"></iconify-icon>
                                    Loading...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="paginationContainer"></div>
        </div>
    </div>
</div>

<script src="./utils/component/pagination.js"></script>
<script>
    let currentPage = 1;
    let totalPages = 1;
    let allEmployees = [];
    const perPage = 18;
    const departmentSet = new Set();
    const positionSet = new Set();

    function loadEmployees(page) {
        const params = new URLSearchParams({
            "paging_options[page]": page,
            "paging_options[per_page]": perPage,
            "filters[0][property]": "status_id",
            "filters[0][value]": 1
        });

        fetch("api/dashboard/show.php?")
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    allEmployees = result.data.employees;
                    populateFilterOptions();
                    renderTable(allEmployees);

                    const total = result.data.total_count || allEmployees.length;
                    totalPages = Math.ceil(total / perPage);
                    currentPage = page;

                    document.getElementById("totalCount").textContent = total + " Staff";

                    renderPagination({
                        currentPage: currentPage,
                        totalPages: totalPages,
                        showingFrom: (page - 1) * perPage + 1,
                        showingTo: Math.min(page * perPage, total),
                        totalRecords: total,
                        showPageNumbers: true,
                        onPrevious: () => currentPage > 1 && loadEmployees(currentPage - 1),
                        onNext: () => currentPage < totalPages && loadEmployees(currentPage + 1),
                        onPageClick: (p) => loadEmployees(p)
                    });
                }
            })
            .catch(err => {
                document.getElementById("employeeTableBody").innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-red-500"><iconify-icon icon="mdi:alert-circle"></iconify-icon> Error loading data</td></tr>';
            });
    }

    function renderTable(employees) {
        const tbody = document.getElementById("employeeTableBody");
        if (!employees.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">No employees found</td></tr>';
            return;
        }

        tbody.innerHTML = employees.map(emp => `
            <tr class="hover:bg-indigo-50 transition-colors">
                <td class="px-4 py-3 font-medium text-gray-900">${emp.full_name}</td>
                <td class="px-4 py-3 text-gray-500 text-xs font-mono">@${emp.username}</td>
                <td class="px-4 py-3"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">${emp.position}</span></td>
                <td class="px-4 py-3"><span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-semibold">${emp.department}</span></td>
                <td class="px-4 py-3 text-gray-600 text-xs">${new Date(emp.date_hired).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
            </tr>
        `).join('');
    }

    function populateFilterOptions() {
        allEmployees.forEach(emp => {
            departmentSet.add(emp.department);
            positionSet.add(emp.position);
        });

        const deptSelect = document.getElementById("departmentFilter");
        const posSelect = document.getElementById("positionFilter");

        Array.from(departmentSet).sort().forEach(dept => {
            const opt = document.createElement("option");
            opt.value = dept;
            opt.textContent = dept;
            deptSelect.appendChild(opt);
        });

        Array.from(positionSet).sort().forEach(pos => {
            const opt = document.createElement("option");
            opt.value = pos;
            opt.textContent = pos;
            posSelect.appendChild(opt);
        });
    }

    function applyFilters() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const dept = document.getElementById("departmentFilter").value;
        const pos = document.getElementById("positionFilter").value;

        const filtered = allEmployees.filter(emp =>
            (emp.full_name.toLowerCase().includes(search) || emp.username.toLowerCase().includes(search)) &&
            (!dept || emp.department === dept) &&
            (!pos || emp.position === pos)
        );

        renderTable(filtered);
    }

    document.getElementById("searchInput").addEventListener("input", applyFilters);
    document.getElementById("departmentFilter").addEventListener("change", applyFilters);
    document.getElementById("positionFilter").addEventListener("change", applyFilters);

    loadEmployees(1);
</script>