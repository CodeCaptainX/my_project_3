<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }
</style>

<div class="bg-gray-100 min-h-full">
    <div class=" p-2">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-500">Welcome back, Admin</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 hover:bg-gray-100 rounded-lg">
                    <iconify-icon icon="mdi:bell" width="20"></iconify-icon>
                </button>
                <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    A
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div id="statsGrid" class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4"></div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Recent Leaves -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Leave Requests</h3>
                <div id="leaveRequests" class="space-y-3"></div>
            </div>

            <!-- Department Breakdown -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Departments</h3>
                <div id="departments" class="space-y-4"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data
    const stats = [
        { icon: 'mdi:account-multiple', value: '245', label: 'Total Employees', color: 'blue' },
        { icon: 'mdi:check-circle', value: '192', label: 'Active Users', color: 'green' },
        { icon: 'mdi:clock-outline', value: '12', label: 'Pending Leaves', color: 'orange' },
        { icon: 'mdi:calendar-blank', value: '8', label: 'On Leave Today', color: 'purple' }
    ];

    const leaveRequests = [
        { name: 'John Doe', type: 'Sick Leave', days: '3 days', status: 'Pending', color: 'blue', statusColor: 'yellow' },
        { name: 'Sarah Smith', type: 'Annual Leave', days: '12 days', status: 'Approved', color: 'green', statusColor: 'green' },
        { name: 'Mike Johnson', type: 'Casual Leave', days: '2 days', status: 'Rejected', color: 'purple', statusColor: 'red' },
        { name: 'Emily Wilson', type: 'Maternity Leave', days: '61 days', status: 'Pending', color: 'orange', statusColor: 'yellow' }
    ];

    const departments = [
        { name: 'Engineering', count: 65, percentage: 65, color: 'blue' },
        { name: 'Sales', count: 45, percentage: 45, color: 'green' },
        { name: 'Support', count: 35, percentage: 35, color: 'purple' },
        { name: 'Finance', count: 30, percentage: 30, color: 'orange' },
        { name: 'HR', count: 25, percentage: 25, color: 'pink' }
    ];

    // Render Stats
    const statsGrid = document.getElementById('statsGrid');
    stats.forEach(stat => {
        statsGrid.innerHTML += `
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between mb-2">
                <iconify-icon icon="${stat.icon}" width="24" class="text-${stat.color}-600"></iconify-icon>
            </div>
            <p class="text-2xl font-bold text-gray-900">${stat.value}</p>
            <p class="text-xs text-gray-600">${stat.label}</p>
        </div>
    `;
    });

    // Render Leave Requests
    const leaveRequestsDiv = document.getElementById('leaveRequests');
    leaveRequests.forEach(req => {
        leaveRequestsDiv.innerHTML += `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-${req.color}-100 rounded-full flex items-center justify-center">
                    <iconify-icon icon="mdi:account" width="18" class="text-${req.color}-600"></iconify-icon>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">${req.name}</p>
                    <p class="text-xs text-gray-500">${req.type} • ${req.days}</p>
                </div>
            </div>
            <span class="text-xs font-semibold px-2 py-1 bg-${req.statusColor}-100 text-${req.statusColor}-800 rounded-full">${req.status}</span>
        </div>
    `;
    });

    // Render Departments
    const departmentsDiv = document.getElementById('departments');
    departments.forEach(dept => {
        departmentsDiv.innerHTML += `
        <div>
            <div class="flex items-center justify-between mb-1">
                <span class="text-sm text-gray-700 font-medium">${dept.name}</span>
                <span class="text-sm font-bold text-gray-900">${dept.count}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-${dept.color}-600 h-2 rounded-full" style="width: ${dept.percentage}%"></div>
            </div>
        </div>
    `;
    });
</script>