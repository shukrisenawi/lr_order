<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4895ef;
        --bg-color: #f8f9fa;
        --text-color: #2b2d42;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-color);
        color: var(--text-color);
    }

    .dashboard-container {
        padding: 20px;
        max-width: 1800px;
        margin: 0 auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card h3 {
        color: var(--primary-color);
        margin: 0 0 10px 0;
    }

    .stat-value {
        font-size: 2em;
        color: var(--secondary-color);
    }

    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .chart {
        height: 300px;
    }

    .recent-activity {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .activity-item i {
        font-size: 1.2em;
        color: var(--primary-color);
        margin-right: 10px;
    }

    .button {
        padding: 8px 16px;
        border-radius: 8px;
        background: var(--primary-color);
        color: white;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .button:hover {
        background: var(--secondary-color);
    }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Dashboard Overview</h1>
            <div class="date">Last updated: {{ date('Y-m-d H:i') }}</div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="stat-value">RM 12,345</div>
                <div class="stat-change">+12% from last month</div>
            </div>

            <div class="stat-card">
                <h3>Active Users</h3>
                <div class="stat-value">1,234</div>
                <div class="stat-change">+8% from last month</div>
            </div>

            <div class="stat-card">
                <h3>New Orders</h3>
                <div class="stat-value">456</div>
                <div class="stat-change">+5% from last month</div>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <div class="activity-item">
                <i class="fas fa-shopping-cart"></i>
                New order #123456 placed
                <span class="time">2 hours ago</span>
            </div>
            <div class="activity-item">
                <i class="fas fa-user"></i>
                New customer registered
                <span class="time">4 hours ago</span>
            </div>
            <div class="activity-item">
                <i class="fas fa-chart-line"></i>
                Revenue milestone reached
                <span class="time">1 day ago</span>
            </div>
        </div>
    </div>

    <script>
        // Sample chart initialization
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: '#4361ee',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Revenue Trend'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
