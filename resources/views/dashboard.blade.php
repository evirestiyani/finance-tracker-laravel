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
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fas fa-history"></i>
                    Recent Transactions
                </h3>
            </div>

            <!-- Enhanced Search Form -->
            <form action="{{ route('dashboard') }}" method="GET" class="search-form">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" class="search-input" placeholder="Search transactions..."
                        value="{{ request('search') }}">
                    <button class="search-btn" type="submit">
                        <i class="fas fa-search"></i>
                        <span>Search</span>
                    </button>
                </div>
            </form>

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
                            <th class="actions-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="table-row">
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>
                                    <span class="type-badge type-{{ strtolower($transaction->type) }}">
                                        {{ $transaction->type }}
                                    </span>
                                </td>
                                <td>{{ $transaction->category->name ?? '-' }}</td>
                                <td class="amount-cell">
                                    <span class="amount">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="description-cell">{{ $transaction->description }}</td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <!-- Edit Button -->
                                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                                            class="action-btn edit-btn" data-tooltip="Edit Transaction">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                            method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn"
                                                data-tooltip="Delete Transaction"
                                                onclick="return confirm('Are you sure you want to delete this transaction?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $transactions->links() }}
                </div>
            </div>
        </section>



        <div class="footer-actions">
            <a href="{{ route('export.pdf') }}" class="btn-outline">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-outline btn-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
@endsection
