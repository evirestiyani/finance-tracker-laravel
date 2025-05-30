<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'FinTrack')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(71, 85, 105, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(71, 85, 105, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(71, 85, 105, 0.01) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
            z-index: 2;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInDown 1s ease-out;
        }

        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .brand-tagline {
            color: #64748b;
            font-size: 16px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .header-section {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 40px;
            align-items: center;
            margin-bottom: 50px;
            padding: 40px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
            animation: slideInLeft 1s ease-out 0.2s both;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #64748b, transparent);
        }

        .welcome-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1e293b;
        }

        .welcome-subtitle {
            color: #64748b;
            font-size: 18px;
            font-weight: 300;
        }

        .balance-display {
            text-align: right;
            position: relative;
        }

        .balance-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .balance-amount {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 700;
            color: #1e293b;
            position: relative;
        }

        .balance-amount::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #64748b, transparent);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .metric-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            animation: slideInUp 1s ease-out calc(0.1s * var(--i)) both;
            transition: all 0.4s ease;
        }

        .metric-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: #94a3b8;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .metric-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #475569;
        }

        .metric-trend {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 20px;
            background: #dcfce7;
            color: #16a34a;
            font-weight: 500;
        }

        .metric-trend.down {
            background: #fee2e2;
            color: #dc2626;
        }

        .metric-value {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .metric-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 400;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .form-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            animation: slideInLeft 1s ease-out 0.4s both;
        }

        .panel-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .panel-title i {
            color: #475569;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            background: #f8fafc;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            color: #1e293b;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            background: #ffffff;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-luxury {
            width: 100%;
            padding: 18px 24px;
            background: #1e293b;
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-luxury::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-luxury:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(30, 41, 59, 0.3);
            background: #334155;
        }

        .btn-luxury:hover::before {
            left: 100%;
        }

        .chart-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            animation: slideInRight 1s ease-out 0.4s both;
        }

        .chart-container {
            position: relative;
            height: 400px;
            margin-top: 20px;
        }

        .transactions-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            animation: slideInUp 1s ease-out 0.6s both;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            background: #f8fafc;
            margin-top: 20px;
        }

        .luxury-table {
            width: 100%;
            border-collapse: collapse;
        }

        .luxury-table th,
        .luxury-table td {
            padding: 18px 20px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .luxury-table th {
            background: #f1f5f9;
            color: #374151;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .luxury-table td {
            color: #1e293b;
            font-weight: 400;
        }

        .luxury-table tr:hover {
            background: #f8fafc;
        }

        .transaction-income {
            color: #16a34a;
            font-weight: 600;
        }

        .transaction-expense {
            color: #dc2626;
            font-weight: 600;
        }

        .footer-actions {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 50px;
            animation: fadeInUp 1s ease-out 0.8s both;
        }

        .btn-outline {
            padding: 14px 28px;
            background: transparent;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-outline:hover {
            background: #f8fafc;
            border-color: #9ca3af;
            transform: translateY(-2px);
        }

        .btn-danger {
            border-color: #fca5a5;
            color: #dc2626;
        }

        .btn-danger:hover {
            background: #fef2f2;
            border-color: #f87171;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1200px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header-section {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 20px;
            }

            .balance-display {
                text-align: center;
            }

            .footer-actions {
                flex-direction: column;
                align-items: center;
            }
        }

            /* Panel Header */
            .panel-header {
                margin-bottom: 2rem;
            }

            .panel-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: #1f2937;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .panel-title i {
                color: #1f2937;
                font-size: 1.25rem;
            }

            /* Enhanced Search Container */
            .search-container {
                margin-bottom: 2rem;
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                padding: 1.5rem;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            }

            .search-form {
                max-width: 600px;
                margin: 0 auto;
            }

            .search-input-wrapper {
                position: relative;
                display: flex;
                align-items: center;
                background: white;
                border-radius: 12px;
                border: 2px solid #e2e8f0;
                transition: all 0.3s ease;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }

            .search-input-wrapper:focus-within {
                border-color: #1f2937;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            }

            .search-icon {
                position: absolute;
                left: 1rem;
                color: #9ca3af;
                font-size: 1rem;
                z-index: 2;
            }

            .search-input {
                flex: 1;
                padding: 1rem 1rem 1rem 3rem;
                border: none;
                outline: none;
                font-size: 1rem;
                color: #374151;
                background: transparent;
            }

            .search-input::placeholder {
                color: #9ca3af;
            }

            .search-btn {
                padding: 1rem 1.5rem;
                background: linear-gradient(135deg, #1f2937 0%, #1f2937 100%);
                color: white;
                border: none;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 500;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .search-btn:hover {
                background: linear-gradient(135deg, #1f2937 0%, #1f2937 100%);
                transform: translateY(-1px);
            }

            .search-btn i {
                font-size: 0.875rem;
            }

            /* Table Enhancements */
            .luxury-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }

            .luxury-table thead {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            }

            .luxury-table th {
                padding: 1.25rem 1rem;
                text-align: left;
                font-weight: 600;
                color: #374151;
                border-bottom: 2px solid #e5e7eb;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .actions-header {
                text-align: center;
                width: 120px;
            }

            .table-row {
                transition: all 0.2s ease;
            }

            .table-row:hover {
                background-color: #f9fafb;
            }

            .luxury-table td {
                padding: 1rem;
                border-bottom: 1px solid #f3f4f6;
                color: #374151;
            }

            /* Type Badge */
            .type-badge {
                padding: 0.25rem 0.75rem;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .type-income {
                background-color: #dcfce7;
                color: #166534;
            }

            .type-expense {
                background-color: #fee2e2;
                color: #991b1b;
            }

            /* Amount Cell */
            .amount-cell {
                font-weight: 600;
                color: #059669;
            }

            .description-cell {
                max-width: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            /* Action Buttons */
            .actions-cell {
                text-align: center;
            }

            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 0.5rem;
            }

            .action-btn {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                cursor: pointer;
                position: relative;
                text-decoration: none;
            }

            .edit-btn {
                background-color: #fef3c7;
                color: #d97706;
                border: 1px solid #fcd34d;
            }

            .edit-btn:hover {
                background-color: #fde68a;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(217, 119, 6, 0.2);
            }

            .delete-btn {
                background-color: #fee2e2;
                color: #dc2626;
                border: 1px solid #fca5a5;
            }

            .delete-btn:hover {
                background-color: #fecaca;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(220, 38, 38, 0.2);
            }

            .delete-form {
                display: inline;
            }

            /* Tooltip */
            .action-btn[data-tooltip]:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                bottom: 120%;
                left: 50%;
                transform: translateX(-50%);
                background-color: #374151;
                color: white;
                padding: 0.5rem 0.75rem;
                border-radius: 6px;
                font-size: 0.75rem;
                white-space: nowrap;
                z-index: 10;
            }

            .action-btn[data-tooltip]:hover::before {
                content: '';
                position: absolute;
                bottom: 110%;
                left: 50%;
                transform: translateX(-50%);
                border: 4px solid transparent;
                border-top-color: #374151;
                z-index: 10;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .search-input-wrapper {
                    flex-direction: column;
                }

                .search-btn {
                    width: 100%;
                    justify-content: center;
                    border-radius: 0 0 12px 12px;
                }

                .luxury-table {
                    font-size: 0.875rem;
                }

                .luxury-table th,
                .luxury-table td {
                    padding: 0.75rem 0.5rem;
                }

                .description-cell {
                    max-width: 120px;
                }
            }
    </style>
</head>

<body>
   
</body>
  <main class="container">
        @yield('content')
    </main>
</html>
