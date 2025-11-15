<div id="dashboard" class="h-full bg-gradient-to-br from-slate-50 to-slate-100  p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Report Dashboard</h1>
            <p class="text-gray-600">Real-time workforce reports and analytics</p>
        </div>
        <button onclick="refreshData()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <span class="iconify" data-icon="mdi:refresh"></span>
            Refresh Data
        </button>
    </div>

    <div id="reportCards" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Cards will be rendered here -->
    </div>

    <div id="statsRow" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Stats will be rendered here -->
    </div>
</div>

<!-- Iconify Script -->
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<script>
// API Data Structure
const reportData = {
    attendance: {
        title: "Attendance Summary",
        icon: "mdi:calendar-check",
        color: "blue",
        metrics: [{
                label: "Present Today",
                value: 245,
                color: "green"
            },
            {
                label: "Absent",
                value: 12,
                color: "red"
            },
            {
                label: "Late Arrivals",
                value: 8,
                color: "yellow"
            }
        ],
        progress: {
            label: "Attendance Rate",
            value: 95.3,
            color: "blue"
        }
    },
    leave: {
        title: "Leave Summary",
        icon: "mdi:calendar-clock",
        color: "purple",
        metrics: [{
                label: "On Leave",
                value: 18,
                color: "purple"
            },
            {
                label: "Pending Requests",
                value: 7,
                color: "orange"
            },
            {
                label: "Approved",
                value: 42,
                color: "green"
            }
        ],
        additional: [{
                label: "Sick Leave",
                value: 8
            },
            {
                label: "Vacation",
                value: 10
            }
        ]
    },
    employee: {
        title: "Employee Statistics",
        icon: "mdi:account-group",
        color: "emerald",
        metrics: [{
                label: "Total Employees",
                value: 275,
                color: "emerald"
            },
            {
                label: "Full-time",
                value: 230,
                color: "blue"
            },
            {
                label: "Part-time",
                value: 45,
                color: "indigo"
            }
        ],
        additional: [{
                label: "New This Month",
                value: "+12",
                color: "green"
            },
            {
                label: "Departments",
                value: 8
            }
        ]
    }
};

const statsData = [{
        label: "Avg. Work Hours",
        value: "8.2h",
        icon: "mdi:clock-outline",
        color: "cyan"
    },
    {
        label: "Productivity",
        value: "92%",
        icon: "mdi:chart-line",
        color: "rose"
    },
    {
        label: "Satisfaction",
        value: "4.5/5",
        icon: "mdi:star",
        color: "amber"
    },
    {
        label: "Performance",
        value: "Excellent",
        icon: "mdi:trophy",
        color: "violet"
    }
];

// Render Report Card
function renderReportCard(data) {
    const metricsHTML = data.metrics.map(metric => `
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">${metric.label}</span>
                    <span class="text-2xl font-bold text-${metric.color}-600">${metric.value}</span>
                </div>
            `).join('');

    const additionalHTML = data.additional ? `
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="space-y-2">
                        ${data.additional.map(item => `
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">${item.label}</span>
                                <span class="font-medium ${item.color ? `text-${item.color}-600` : 'text-gray-800'}">${item.value}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : '';

    const progressHTML = data.progress ? `
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">${data.progress.label}</span>
                        <span class="text-sm font-semibold text-${data.progress.color}-600">${data.progress.value}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-${data.progress.color}-600 h-2 rounded-full" style="width: ${data.progress.value}%"></div>
                    </div>
                </div>
            ` : '';

    return `
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-${data.color}-100 rounded-lg flex items-center justify-center">
                                <span class="iconify text-${data.color}-600 text-2xl" data-icon="${data.icon}"></span>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-800">${data.title}</h2>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        ${metricsHTML}
                    </div>

                    ${progressHTML}
                    ${additionalHTML}

                    <button onclick="viewDetails('${data.title}')" class="w-full mt-4 bg-${data.color}-50 hover:bg-${data.color}-100 text-${data.color}-600 font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="mdi:eye"></span>
                        View Details
                    </button>
                </div>
            `;
}

// Render Stats Card
function renderStatCard(stat) {
    return `
                <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-${stat.color}-100 rounded-lg flex items-center justify-center">
                            <span class="iconify text-${stat.color}-600 text-xl" data-icon="${stat.icon}"></span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">${stat.label}</p>
                            <p class="text-xl font-bold text-gray-800">${stat.value}</p>
                        </div>
                    </div>
                </div>
            `;
}

// Initialize Dashboard
function initDashboard() {
    const reportCardsContainer = document.getElementById('reportCards');
    const statsRowContainer = document.getElementById('statsRow');

    // Render Report Cards
    reportCardsContainer.innerHTML = Object.values(reportData)
        .map(data => renderReportCard(data))
        .join('');

    // Render Stats
    statsRowContainer.innerHTML = statsData
        .map(stat => renderStatCard(stat))
        .join('');
}

// Refresh Data (simulated)
function refreshData() {
    console.log('Refreshing data...');
    // Here you would fetch from your PHP APIs
    // fetch('/api/attendance-summary')
    // fetch('/api/leave-summary')
    // fetch('/api/employee-statistics')

    // Simulate refresh
    const dashboard = document.getElementById('dashboard');
    dashboard.style.opacity = '0.5';

    setTimeout(() => {
        initDashboard();
        dashboard.style.opacity = '1';
        alert('Dashboard refreshed!');
    }, 500);
}

// View Details Handler
function viewDetails(title) {
    console.log(`Viewing details for: ${title}`);
    alert(`Opening detailed report for: ${title}`);
    // Navigate to detailed page or open modal
    // window.location.href = `/reports/${title.toLowerCase().replace(/ /g, '-')}`;
}

// Fetch data from API (example)
async function fetchReportData() {
    try {
        // Example: Fetch from your PHP APIs
        // const attendance = await fetch('/api/attendance-summary').then(r => r.json());
        // const leave = await fetch('/api/leave-summary').then(r => r.json());
        // const employee = await fetch('/api/employee-statistics').then(r => r.json());

        // Update reportData object with API responses
        // reportData.attendance = attendance;
        // reportData.leave = leave;
        // reportData.employee = employee;

        initDashboard();
    } catch (error) {
        console.error('Error fetching report data:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    initDashboard();
    // Or use: fetchReportData() to fetch from APIs
});
</script>