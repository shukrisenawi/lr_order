<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SumoPod</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e1e5e9;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #4285f4;
            border-radius: 8px;
            margin-right: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-item:hover {
            background: #f8f9fa;
            color: #333;
        }

        .nav-item.active {
            background: #e3f2fd;
            color: #4285f4;
            border-right: 3px solid #4285f4;
        }

        .nav-item-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
        }

        .user-name {
            font-weight: 500;
            color: #333;
        }

        .user-email {
            font-size: 0.875rem;
            color: #666;
        }

        .logout-btn {
            background: none;
            border: 1px solid #e1e5e9;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            color: #666;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .logout-btn:hover {
            background: #f8f9fa;
        }

        .content-area {
            flex: 1;
            padding: 2rem;
        }

        .billing-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .billing-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .billing-subtitle {
            color: #666;
        }

        .billing-actions {
            display: flex;
            gap: 1rem;
            margin-left: auto;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary {
            background: white;
            color: #666;
            border: 1px solid #e1e5e9;
        }

        .btn-primary {
            background: #4285f4;
            color: white;
        }

        .credit-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .credit-icon {
            width: 48px;
            height: 48px;
            background: #e3f2fd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4285f4;
        }

        .credit-info h3 {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.25rem;
        }

        .credit-amount {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .transactions-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .transactions-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e1e5e9;
            display: flex;
            gap: 2rem;
        }

        .tab {
            padding: 0.5rem 0;
            color: #666;
            border-bottom: 2px solid transparent;
            cursor: pointer;
        }

        .tab.active {
            color: #4285f4;
            border-bottom-color: #4285f4;
        }

        .transactions-table {
            width: 100%;
        }

        .table-header {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e1e5e9;
            display: grid;
            grid-template-columns: 1fr 2fr 1fr 1fr;
            gap: 1rem;
            font-weight: 600;
            color: #666;
            font-size: 0.875rem;
        }

        .table-row {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e1e5e9;
            display: grid;
            grid-template-columns: 1fr 2fr 1fr 1fr;
            gap: 1rem;
            align-items: center;
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .transaction-type {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .type-usage {
            color: #dc3545;
        }

        .type-purchase {
            color: #28a745;
        }

        .amount-negative {
            color: #dc3545;
        }

        .amount-positive {
            color: #28a745;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon">S</div>
                SumoPod
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Learning</div>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">📚</div>
                    Learn
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">👥</div>
                    Community
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Services</div>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">🤖</div>
                    AI
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">⚙️</div>
                    Services
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Infrastructure</div>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">💾</div>
                    VPS
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">🗄️</div>
                    Database
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Account</div>
                <a href="#" class="nav-item active">
                    <div class="nav-item-icon">💳</div>
                    Billing
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">🔗</div>
                    Affiliate
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">⚙️</div>
                    Settings
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-item-icon">❓</div>
                    Support
                </a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="page-title">Billing</h1>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">U</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-email">{{ Auth::user()->email ?? 'shukrisenawi@gmail.com' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <div class="content-area">
            <div class="billing-header">
                <div>
                    <h2 class="billing-title">Billing</h2>
                    <p class="billing-subtitle">Manage your balance and view transaction history</p>
                </div>
                <div class="billing-actions">
                    <a href="#" class="btn btn-secondary">🔄 Redeem</a>
                    <a href="#" class="btn btn-primary">+ Add Credit</a>
                </div>
            </div>

            <div class="credit-card">
                <div class="credit-icon">💳</div>
                <div class="credit-info">
                    <h3>Current Credits</h3>
                    <div class="credit-amount">Rp 195.000</div>
                </div>
            </div>

            <div class="transactions-section">
                <div class="transactions-header">
                    <div class="tab active">📊 Transactions</div>
                    <div class="tab">💰 Payments</div>
                </div>

                <div class="table-header">
                    <div>DATE</div>
                    <div>DESCRIPTION</div>
                    <div>TYPE</div>
                    <div>AMOUNT</div>
                </div>

                <div class="table-row">
                    <div>8/21/2025</div>
                    <div>Purchase Managed DB - Jamukal JGI (Monthly)</div>
                    <div class="transaction-type type-usage">⬇ Usage</div>
                    <div class="amount-negative">Rp -10.000 credits</div>
                </div>

                <div class="table-row">
                    <div>8/25/2025</div>
                    <div>Credit purchase: 200000 credits</div>
                    <div class="transaction-type type-purchase">⬆ Purchase</div>
                    <div class="amount-positive">+Rp 200.000 credits</div>
                </div>

                <div class="table-row">
                    <div>8/17/2025</div>
                    <div>Service purchase: nBn (monthly)</div>
                    <div class="transaction-type type-usage">⬇ Usage</div>
                    <div class="amount-negative">Rp -60.000 credits</div>
                </div>

                <div class="table-row">
                    <div>8/17/2025</div>
                    <div>Service purchase: WALA (monthly)</div>
                    <div class="transaction-type type-usage">⬇ Usage</div>
                    <div class="amount-negative">Rp -35.000 credits</div>
                </div>

                <div class="table-row">
                    <div>8/17/2025</div>
                    <div>Credit purchase: 100000 credits</div>
                    <div class="transaction-type type-purchase">⬆ Purchase</div>
                    <div class="amount-positive">+Rp 100.000 credits</div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
