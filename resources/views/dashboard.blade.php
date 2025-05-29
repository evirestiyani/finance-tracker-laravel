@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <header class="brand-header">
            <div class="brand-logo">FinTrack</div>
            <div class="brand-tagline">Financial Management</div>
        </header>

        <section class="header-section">
            <div class="welcome-content">
                <h1>Welcome back, {{ Auth::user()->name }}</h1>
                <p class="welcome-subtitle">Here's your financial overview for today</p>
            </div>
            <div class="balance-display">
                <div class="balance-label">Total Balance</div>
                <div class="balance-amount">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>

            </div>

        </section>

        <div class="metrics-grid">
            <div class="metric-card" style="--i: 1;">
                <div class="metric-header">
                    <div class="metric-icon">
                        <i class="fas fa-arrow-trend-up"></i>
                    </div>
                </div>
                <div class="metric-value">Rp {{ number_format($totalIncome, 2) }}</div>
                <div class="metric-label">Monthly Income</div>
            </div>

            <div class="metric-card" style="--i: 2;">
                <div class="metric-header">
                    <div class="metric-icon">
                        <i class="fas fa-arrow-trend-down"></i>
                    </div>
                </div>
                <div class="metric-value">Rp {{ number_format($totalExpense, 2) }}</div>
                <div class="metric-label">Monthly Expenses</div>
            </div>

            <div class="metric-card" style="--i: 4;">
                <div class="metric-header">
                    <div class="metric-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="metric-value">{{ $totalTransactions }}</div>
                <div class="metric-label">Total Transactions</div>
            </div>
        </div>


        <div class="main-content">
            <section class="form-panel">
                <h3 class="panel-title">
                    <i class="fas fa-plus-circle"></i>
                    Add Transaction
                </h3>
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Transaction Type</label>
                        <select class="form-control" name="type" required>
                            <option value="income">💰 Income</option>
                            <option value="expense">💸 Expense</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select class="form-control" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon ?? '' }} {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <small class="form-text text-muted mt-2">Belum ada kategori yang sesuai?</small>
                        <input type="text" class="form-control mt-1" name="new_category"
                            placeholder="Tambah kategori baru (opsional)">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount..." required />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Add notes (optional)..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required />
                    </div>

                    <button type="submit" class="btn-luxury">
                        <i class="fas fa-save"></i>
                        Save Transaction
                    </button>
                </form>
            </section>


            <section class="chart-panel">
                <h3 class="panel-title">
                    <i class="fas fa-chart-bar"></i>
                    Financial Analytics
                </h3>
                <div class="chart-container">
                    <canvas id="luxuryChart"></canvas>
                </div>
            </section>
        </div>

        <section class="transactions-panel">
            <h3 class="panel-title">
                <i class="fas fa-history"></i>
                Recent Transactions
            </h3>
            <div class="table-wrapper">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ $transaction->category->name ?? '-' }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <div class="footer-actions">
            <a href="#" class="btn-outline">
                <i class="fas fa-file-pdf"></i>
                Export PDF
            </a>
            <a href="#" class="btn-outline">
                <i class="fas fa-file-excel"></i>
                Export Excel
            </a>
            <button class="btn-outline btn-danger">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('luxuryChart').getContext('2d');

        const months = @json($months);
        const incomeData = @json($incomeData);
        const expenseData = @json($expenseData);

        const luxuryChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Income',
                    data: incomeData,
                    borderColor: '#475569',
                    backgroundColor: 'rgba(71, 85, 105, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#475569',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }, {
                    label: 'Expenses',
                    data: expenseData,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#dc2626',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#374151',
                            font: {
                                weight: 600,
                                size: 14
                            },
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: {
                                weight: 500
                            }
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    },
                    y: {
                        min: 0,
                        max: 20000000,
                        ticks: {
                            stepSize: 5000000,
                            color: '#64748b',
                            font: {
                                weight: 500
                            },
                            callback: function(value) {
                                return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    </script>

@endsection
