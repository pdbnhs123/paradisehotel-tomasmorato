<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise Hotel - Admin Dashboard</title>
    <script src="https://kit.fontawesome.com/a2d9d5bd8b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="logo-container">
            <span class="logo-text">PARADISE HOTEL</span>
        </div>

        <a href="dashboard.php" class="menu-item active">
            <span>Dashboard</span>
        </a>

        <div class="menu-item" id="dataInsightMenu">
            <span>Data Insight</span>
            <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
        </div>
        <div class="sub-menu" id="dataInsightSubMenu">
            <a href="data_insight.html" class="sub-menu-item">Analytics</a>
        </div>

        <a href="employee.html" class="menu-item">
            <span>Employee & Shift Management</span>
        </a>

        <a href="leave.html" class="menu-item">
            <span>Leave Management</span>
        </a>

        <a href="violation.html" class="menu-item">
            <span>Employee Violation</span>
        </a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="burger-menu" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>Admin Dashboard</h2>
            </div>
            <div class="header-buttons">
                <div class="user-info" onclick="toggleUserDropdown()">
                    <a style="text-decoration: none;" href="../logout.php" onclick="signOut()"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                    <i class="fas fa-caret-down"></i>
                </div>
            </div>
        </div>


        <h1 class="dashboard-title">Welcome to Paradise Hotel Management</h1>

        <!-- Recent Activities Section -->
        <div class="section">
            <h3 class="section-title">Recent Activities</h3>
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Activity</th>
                        <th>Department</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody id="recentActivitiesTable">
                    <!-- Will be filled by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (sidebar.style.width === '70px') {
                sidebar.style.width = '250px';
                mainContent.style.marginLeft = '250px';
                mainContent.style.width = 'calc(100% - 250px)';

                // Show menu item text
                document.querySelectorAll('.menu-item span').forEach(el => {
                    el.style.display = 'inline';
                });

                // Show logo text
                document.querySelector('.logo-text').style.display = 'inline';
            } else {
                sidebar.style.width = '70px';
                mainContent.style.marginLeft = '70px';
                mainContent.style.width = 'calc(100% - 70px)';

                // Hide menu item text
                document.querySelectorAll('.menu-item span').forEach(el => {
                    el.style.display = 'none';
                });

                // Hide logo text
                document.querySelector('.logo-text').style.display = 'none';
            }
        }

        // Toggle user dropdown
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.user-info') && !event.target.closest('.user-info')) {
                const dropdowns = document.getElementsByClassName("user-dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        }

        // Sign out function
        function signOut() {
            // Add your sign out logic here
            alert('Signing out...');
            // window.location.href = 'login.html'; // Redirect to login page
        }

        // Sample data for Recent Activities with more variety
        const recentActivities = [{
            employee: "John Smith",
            activity: "Leave Request",
            department: "Housekeeping",
            time: "10:30 AM",
            status: "Pending",
            details: "Requested 3 days leave starting tomorrow"
        }, {
            employee: "Sarah Johnson",
            activity: "Shift Change",
            department: "Front Desk",
            time: "9:15 AM",
            status: "Approved",
            details: "Changed from morning to evening shift next week"
        }, {
            employee: "Michael Brown",
            activity: "Late Arrival",
            department: "Maintenance",
            time: "8:45 AM",
            status: "Reported",
            details: "Arrived 25 minutes late due to transportation issues"
        }, {
            employee: "Emily Davis",
            activity: "Overtime Request",
            department: "Food & Beverage",
            time: "Yesterday",
            status: "Pending",
            details: "Requested 2 hours overtime for banquet event"
        }, {
            employee: "Robert Wilson",
            activity: "Training Completed",
            department: "Security",
            time: "Yesterday",
            status: "Completed",
            details: "Completed emergency response training"
        }, {
            employee: "Lisa Wong",
            activity: "Equipment Request",
            department: "Housekeeping",
            time: "2 days ago",
            status: "Approved",
            details: "Requested new vacuum cleaner for floor 5"
        }, {
            employee: "David Miller",
            activity: "Complaint Received",
            department: "Front Desk",
            time: "2 days ago",
            status: "In Progress",
            details: "Guest complaint about room cleanliness"
        }, {
            employee: "Jessica Lee",
            activity: "New Hire",
            department: "Food & Beverage",
            time: "3 days ago",
            status: "Completed",
            details: "Completed onboarding for new waiter position"
        }, {
            employee: "Carlos Garcia",
            activity: "Maintenance Report",
            department: "Maintenance",
            time: "3 days ago",
            status: "New",
            details: "Reported AC malfunction in room 302"
        }, {
            employee: "Aisha Patel",
            activity: "Inventory Update",
            department: "Housekeeping",
            time: "4 days ago",
            status: "Completed",
            details: "Updated linen inventory for all floors"
        }, {
            employee: "Thomas Chen",
            activity: "Performance Review",
            department: "Management",
            time: "5 days ago",
            status: "Completed",
            details: "Annual performance review completed"
        }, {
            employee: "Olivia Martin",
            activity: "Violation Report",
            department: "Security",
            time: "1 week ago",
            status: "Reported",
            details: "Reported unauthorized access to staff area"
        }];

        // Function to get status class
        function getStatusClass(status) {
            switch (status.toLowerCase()) {
                case 'pending':
                    return 'status-pending';
                case 'approved':
                    return 'status-approved';
                case 'declined':
                    return 'status-declined';
                case 'reported':
                    return 'status-reported';
                case 'completed':
                    return 'status-completed';
                case 'in progress':
                    return 'status-in-progress';
                case 'new':
                    return 'status-new';
                default:
                    return '';
            }
        }

        // Function to populate the recent activities table
        function populateRecentActivitiesTable() {
            const activitiesTable = document.getElementById('recentActivitiesTable');
            if (activitiesTable) {
                activitiesTable.innerHTML = ''; // Clear existing rows

                recentActivities.forEach(activity => {
                    const row = document.createElement('tr');
                    const statusClass = getStatusClass(activity.status);

                    row.innerHTML = `
                        <td>${activity.employee}</td>
                        <td>${activity.activity}</td>
                        <td>${activity.department}</td>
                        <td>${activity.time}</td>
                        <td><span class="status-badge ${statusClass}">${activity.status}</span></td>
                        <td>${activity.details}</td>
                    `;
                    activitiesTable.appendChild(row);
                });
            }
        }

        const dataInsightMenu = document.getElementById('dataInsightMenu');
        // Wait for DOM to be fully loaded before populating the tables
        document.addEventListener('DOMContentLoaded', function() {
            populateRecentActivitiesTable();
        });
          // Toggle data insight menu
          dataInsightMenu.addEventListener('click', toggleDataInsightMenu);

          function toggleDataInsightMenu() {
            dataInsightSubMenu.classList.toggle('show');
        }

// Search employees
searchEmployees.addEventListener('input', (e) => {
    renderEmployeeDirectory(e.target.value);
});
    </script>
</body>

</html>