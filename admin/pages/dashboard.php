<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .tab-btn.active {
            @apply text-blue-600 border-b-2 border-blue-600;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .stat-card {
            @apply bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 shadow-sm hover:shadow-md transition-all;
        }

        .stat-card.green {
            @apply from-green-50 to-green-100;
        }

        .stat-card.purple {
            @apply from-purple-50 to-purple-100;
        }

        .stat-card.orange {
            @apply from-orange-50 to-orange-100;
        }

        .stat-card.red {
            @apply from-red-50 to-red-100;
        }

        .badge-pending {
            @apply bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold;
        }

        .badge-approved {
            @apply bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold;
        }

        .badge-rejected {
            @apply bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold;
        }

        .badge-active {
            @apply bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold;
        }

        .badge-inactive {
            @apply bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold;
        }

        .table-row {
            @apply border-b border-gray-200 hover:bg-gray-50 transition-colors;
        }

        .action-btn {
            @apply p-2 hover:bg-gray-100 rounded-lg transition-colors;
        }

        .modal {
            display: none;
            @apply fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50;
        }

        .modal.active {
            display: flex;
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="flex h-screen bg-gray-900 text-white">
        <div class="w-64 bg-gray-900 shadow-lg overflow-y-auto">
            <div class="p-6 border-b border-gray-800">
                <div class="flex items-center space-x-3">
                    <iconify-icon icon="mdi:shield-admin" width="32" height="32"></iconify-icon>
                    <h1 class="text-2xl font-bold">AdminHub</h1>
                </div>
            </div>

            <nav class="p-6 space-y-4">
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-4">Main Menu</div>

                <a href="#"
                    class="nav-link active flex items-center space-x-3 px-4 py-3 rounded-lg bg-blue-600 transition-all"
                    onclick="switchTab('dashboard')">
                    <iconify-icon icon="mdi:chart-box" width="20" height="20"></iconify-icon>
                    <span>Dashboard</span>
                </a>

                <a href="#"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-all"
                    onclick="switchTab('employees')">
                    <iconify-icon icon="mdi:account-multiple" width="20" height="20"></iconify-icon>
                    <span>Employees</span>
                </a>

                <a href="#"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-all"
                    onclick="switchTab('leaves')">
                    <iconify-icon icon="mdi:calendar-check" width="20" height="20"></iconify-icon>
                    <span>Leave Requests</span>
                </a>

                <a href="#"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-all"
                    onclick="switchTab('users')">
                    <iconify-icon icon="mdi:account-tie" width="20" height="20"></iconify-icon>
                    <span>Users & Roles</span>
                </a>

                <a href="#"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-all"
                    onclick="switchTab('attendance')">
                    <iconify-icon icon="mdi:clock-check-outline" width="20" height="20"></iconify-icon>
                    <span>Attendance</span>
                </a>

                <a href="#"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-all"
                    onclick="switchTab('reports')">
                    <iconify-icon icon="mdi:file-document" width="20" height="20"></iconify-icon>
                    <span>Reports</span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-800 bg-gray-800 bg-opacity-50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <iconify-icon icon="mdi:account" width="20" height="20"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Admin User</p>
                        <p class="text-xs text-gray-400">admin@company.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900" id="pageTitle">Dashboard</h2>
                        <p class="text-gray-600 mt-1">Welcome back to your admin panel</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <iconify-icon icon="mdi:bell" width="24" height="24" class="text-gray-600"></iconify-icon>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <iconify-icon icon="mdi:cog" width="24" height="24" class="text-gray-600"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8">
                <!-- Dashboard Tab -->
                <div id="dashboard" class="tab-content active">
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="stat-card">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Total Employees</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2" id="totalEmp">245</p>
                                </div>
                                <iconify-icon icon="mdi:account-multiple" width="40" height="40"
                                    class="text-blue-600 opacity-50"></iconify-icon>
                            </div>
                        </div>

                        <div class="stat-card green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Active Users</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">192</p>
                                </div>
                                <iconify-icon icon="mdi:check-circle" width="40" height="40"
                                    class="text-green-600 opacity-50"></iconify-icon>
                            </div>
                        </div>

                        <div class="stat-card purple">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Pending Leaves</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2" id="pendingLeaves">12</p>
                                </div>
                                <iconify-icon icon="mdi:clock-outline" width="40" height="40"
                                    class="text-purple-600 opacity-50"></iconify-icon>
                            </div>
                        </div>

                        <div class="stat-card orange">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">On Leave Today</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">8</p>
                                </div>
                                <iconify-icon icon="mdi:calendar-blank" width="40" height="40"
                                    class="text-orange-600 opacity-50"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Overview -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Recent Leaves -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Leave Requests</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <iconify-icon icon="mdi:account" width="20" height="20"
                                                class="text-blue-600"></iconify-icon>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">John Doe</p>
                                            <p class="text-xs text-gray-600">Sick Leave</p>
                                        </div>
                                    </div>
                                    <span class="badge-pending">Pending</span>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <iconify-icon icon="mdi:account" width="20" height="20"
                                                class="text-green-600"></iconify-icon>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Sarah Smith</p>
                                            <p class="text-xs text-gray-600">Annual Leave</p>
                                        </div>
                                    </div>
                                    <span class="badge-approved">Approved</span>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Overview -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Department Breakdown</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="mdi:briefcase" width="20" height="20"
                                            class="text-blue-600"></iconify-icon>
                                        <span class="text-gray-700 font-medium">Engineering</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">65</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="mdi:human-greeting-variant" width="20" height="20"
                                            class="text-green-600"></iconify-icon>
                                        <span class="text-gray-700 font-medium">Sales</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: 45%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">45</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="mdi:headset" width="20" height="20"
                                            class="text-purple-600"></iconify-icon>
                                        <span class="text-gray-700 font-medium">Support</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 35%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">35</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <iconify-icon icon="mdi:finance" width="20" height="20"
                                            class="text-orange-600"></iconify-icon>
                                        <span class="text-gray-700 font-medium">Finance</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-orange-600 h-2 rounded-full" style="width: 30%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">30</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employees Tab -->
                <div id="employees" class="tab-content">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900">Employee Directory</h3>
                            <button
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <iconify-icon icon="mdi:plus" width="20" height="20"></iconify-icon>
                                <span>Add Employee</span>
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Position
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Department
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Join Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-row">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-blue-700">JD</span>
                                                </div>
                                                <span class="font-medium text-gray-900">John Doe</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">john.doe@company.com</td>
                                        <td class="px-6 py-4 text-gray-700">Senior Developer</td>
                                        <td class="px-6 py-4 text-gray-700">Engineering</td>
                                        <td class="px-6 py-4"><span class="badge-active">Active</span></td>
                                        <td class="px-6 py-4 text-gray-700">Jan 15, 2022</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button class="action-btn" title="Edit">
                                                    <iconify-icon icon="mdi:pencil" width="18" height="18"
                                                        class="text-blue-600"></iconify-icon>
                                                </button>
                                                <button class="action-btn" title="View">
                                                    <iconify-icon icon="mdi:eye" width="18" height="18"
                                                        class="text-gray-600"></iconify-icon>
                                                </button>
                                                <button class="action-btn" title="Delete">
                                                    <iconify-icon icon="mdi:delete" width="18" height="18"
                                                        class="text-red-600"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-green-700">SS</span>
                                                </div>
                                                <span class="font-medium text-gray-900">Sarah Smith</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">sarah.smith@company.com</td>
                                        <td class="px-6 py-4 text-gray-700">Product Manager</td>
                                        <td class="px-6 py-4 text-gray-700">Product</td>
                                        <td class="px-6 py-4"><span class="badge-active">Active</span></td>
                                        <td class="px-6 py-4 text-gray-700">Mar 20, 2021</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button class="action-btn" title="Edit">
                                                    <iconify-icon icon="mdi:pencil" width="18" height="18"
                                                        class="text-blue-600"></iconify-icon>
                                                </button>
                                                <button class="action-btn" title="View">
                                                    <iconify-icon icon="mdi:eye" width="18" height="18"
                                                        class="text-gray-600"></iconify-icon>
                                                </button>
                                                <button class="action-btn" title="Delete">
                                                    <iconify-icon icon="mdi:delete" width="18" height="18"
                                                        class="text-red-600"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-purple-700">MJ</span>
                                                </div>
                                                <span class="font-medium text-gray-900">Mike Johnson</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">mike.johnson@company.com</td>
                                        <td class="px-6 py-4 text-gray-700">HR Specialist</td>
                                        <td class="px-6 py-4 text-gray-700">Human Resources</td>
                                        <td class="px-6 py-4"><span class="badge-inactive">Inactive</span></td>
                                        <td class="px-6 py-4 text-gray-700">Jul 10, 2020</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button class="action-btn" title="Edit">
                                                    <iconify-icon icon="mdi:pencil" width="18" height="18"
                                                        class="text-blue-600"></iconify-icon>
                                                </button>
                                                <button class="action-btn" title="View">
                                                    <iconify-icon icon="mdi:eye" width="18" height="18"
                                                        class="text-gray-600"></iconify-icon>
                                                </button>
                                                <button class="action-btn" title="Delete">
                                                    <iconify-icon icon="mdi:delete" width="18" height="18"
                                                        class="text-red-600"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Leaves Tab -->
                <div id="leaves" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Pending Requests</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">12</p>
                                </div>
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <iconify-icon icon="mdi:clock" width="24" height="24"
                                        class="text-yellow-600"></iconify-icon>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Approved This Month</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <iconify-icon icon="mdi:check-circle" width="24" height="24"
                                        class="text-green-600"></iconify-icon>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Rejected</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">3</p>
                                </div>
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <iconify-icon icon="mdi:close-circle" width="24" height="24"
                                        class="text-red-600"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Leave Requests</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Employee
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Leave Type
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">From - To
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Days</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-row">
                                        <td class="px-6 py-4 font-medium text-gray-900">John Doe</td>
                                        <td class="px-6 py-4 text-gray-700">Sick Leave</td>
                                        <td class="px-6 py-4 text-gray-700">Oct 15 - Oct 17</td>
                                        <td class="px-6 py-4 text-gray-700">3 days</td>
                                        <td class="px-6 py-4"><span class="badge-pending">Pending</span></td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button
                                                    class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded hover:bg-green-200 transition-colors">Approve</button>
                                                <button
                                                    class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded hover:bg-red-200 transition-colors">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="px-6 py-4 font-medium text-gray-900">Sarah Smith</td>
                                        <td class="px-6 py-4 text-gray-700">Annual Leave</td>
                                        <td class="px-6 py-4 text-gray-700">Oct 20 - Oct 31</td>
                                        <td class="px-6 py-4 text-gray-700">12 days</td>
                                        <td class="px-6 py-4"><span class="badge-approved">Approved</span></td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button class="action-btn" title="View">
                                                    <iconify-icon icon="mdi:eye" width="18" height="18"
                                                        class="text-gray-600"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="px-6 py-4 font-medium text-gray-900">Mike Johnson</td>
                                        <td class="px-6 py-4 text-gray-700">Maternity Leave</td>
                                        <td class="px-6 py-4 text-gray-700">Nov 01 - Dec 31</td>
                                        <td class="px-6 py-4 text-gray-700">61 days</td>
                                        <td class="px-6 py-4"><span class="badge-pending">Pending</span></td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button
                                                    class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded hover:bg-green-200