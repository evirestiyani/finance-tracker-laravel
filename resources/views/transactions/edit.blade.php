@extends('layout.app')

@section('title', 'Edit Transaction - FinTrack')

@section('content')
<div class="container">
    <!-- Brand Header -->
    <header class="brand-header">
        <div class="brand-logo">FinTrack</div>
        <div class="brand-tagline">Financial Management</div>
    </header>

    <!-- Page Header -->
    <section class="page-header-section">
        <div class="page-header-content">
            <div class="header-navigation">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <span class="nav-separator">/</span>
                <span class="nav-current">Edit Transaction</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Transaction
            </h1>
            <p class="page-subtitle">Modify your transaction details with precision</p>
        </div>
    </section>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert-panel error-panel">
            <div class="alert-header">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Attention Required!</strong>
            </div>
            <div class="alert-content">
                <p>Please correct the following errors:</p>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Edit Form -->
    <section class="edit-form-section">
        <div class="form-panel enhanced-panel">
            <div class="panel-header-enhanced">
                <div class="panel-icon-wrapper">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <div class="panel-header-text">
                    <h3 class="panel-title-enhanced">Transaction Details</h3>
                    <p class="panel-description">Update the information below to modify your transaction</p>
                </div>
            </div>

            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="luxury-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Transaction Type -->
                    <div class="form-group enhanced-group">
                        <label class="form-label-enhanced">
                            <i class="fas fa-exchange-alt label-icon"></i>
                            Transaction Type
                        </label>
                        <div class="select-wrapper">
                            <select class="form-control-enhanced" name="type" required>
                                <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>
                                    💰 Income
                                </option>
                                <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>
                                    💸 Expense
                                </option>
                            </select>
                            <i class="fas fa-chevron-down select-arrow"></i>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="form-group enhanced-group">
                        <label class="form-label-enhanced">
                            <i class="fas fa-tags label-icon"></i>
                            Category
                        </label>
                        <div class="select-wrapper">
                            <select class="form-control-enhanced" name="category_id" id="category_id">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->icon ?? '📁' }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down select-arrow"></i>
                        </div>
                    </div>

                    <!-- New Category -->
                    <div class="form-group enhanced-group full-width">
                        <label class="form-label-enhanced">
                            <i class="fas fa-plus label-icon"></i>
                            New Category (Optional)
                        </label>
                        <input type="text" class="form-control-enhanced" name="new_category" 
                               placeholder="Create a new category if existing ones don't fit">
                        <small class="form-hint">This will create a new category if provided</small>
                    </div>

                    <!-- Amount -->
                    <div class="form-group enhanced-group">
                        <label class="form-label-enhanced">
                            <i class="fas fa-dollar-sign label-icon"></i>
                            Amount
                        </label>
                        <div class="input-wrapper">
                            <span class="input-prefix">Rp</span>
                            <input type="number" class="form-control-enhanced amount-input" 
                                   name="amount" value="{{ $transaction->amount }}" 
                                   placeholder="0" required step="0.01" min="0">
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group enhanced-group">
                        <label class="form-label-enhanced">
                            <i class="fas fa-calendar label-icon"></i>
                            Transaction Date
                        </label>
                        <input type="date" class="form-control-enhanced" name="date" 
                               value="{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group enhanced-group full-width">
                        <label class="form-label-enhanced">
                            <i class="fas fa-sticky-note label-icon"></i>
                            Description
                        </label>
                        <textarea class="form-control-enhanced textarea-enhanced" name="description" 
                                  rows="4" placeholder="Add detailed notes about this transaction...">{{ $transaction->description }}</textarea>
                        <small class="form-hint">Provide additional context or details</small>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions-section">
                    <div class="actions-wrapper">
                        <button type="submit" class="btn-luxury btn-primary-action">
                            <i class="fas fa-save"></i>
                            <span>Save Changes</span>
                            <div class="btn-glow"></div>
                        </button>
                        
                        <a href="{{ route('dashboard') }}" class="btn-luxury btn-secondary-action">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Dashboard</span>
                        </a>
                    </div>
                    
                    <div class="form-meta">
                        <small class="meta-text">
                            <i class="fas fa-info-circle"></i>
                            Transaction ID: #{{ $transaction->id }} • Last updated: {{ $transaction->updated_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<style>
/* Page Header Enhancements */
.page-header-section {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 40px;
    margin-bottom: 40px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    animation: slideInDown 0.8s ease-out;
    position: relative;
    overflow: hidden;
}

.page-header-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #64748b, transparent);
}

.page-header-content {
    text-align: center;
}

.header-navigation {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 14px;
}

.nav-link {
    color: #64748b;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    color: #1e293b;
    background: #f1f5f9;
}

.nav-separator {
    color: #cbd5e1;
    font-weight: 300;
}

.nav-current {
    color: #1e293b;
    font-weight: 600;
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.page-subtitle {
    color: #64748b;
    font-size: 16px;
    font-weight: 300;
}

/* Alert Panel */
.alert-panel {
    background: #ffffff;
    border: 1px solid #fca5a5;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 30px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    animation: slideInUp 0.6s ease-out;
}

.error-panel {
    border-left: 4px solid #dc2626;
    background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
}

.alert-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    color: #dc2626;
    font-weight: 600;
}

.alert-header i {
    font-size: 18px;
}

.error-list {
    list-style: none;
    padding: 0;
    margin: 12px 0 0 0;
}

.error-list li {
    padding: 8px 0;
    color: #7f1d1d;
    position: relative;
    padding-left: 20px;
}

.error-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #dc2626;
    font-weight: bold;
}

/* Enhanced Form Styling */
.edit-form-section {
    animation: slideInUp 0.8s ease-out 0.2s both;
}

.enhanced-panel {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 0;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
}

.enhanced-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #64748b, transparent);
}

.panel-header-enhanced {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 32px 40px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 20px;
}

.panel-icon-wrapper {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    box-shadow: 0 4px 6px rgba(30, 41, 59, 0.2);
}

.panel-title-enhanced {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.panel-description {
    color: #64748b;
    margin: 4px 0 0 0;
    font-size: 14px;
}

.luxury-form {
    padding: 40px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 40px;
}

.enhanced-group.full-width {
    grid-column: 1 / -1;
}

.form-label-enhanced {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #374151;
    font-weight: 600;
    margin-bottom: 12px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.label-icon {
    color: #64748b;
    font-size: 12px;
}

.form-control-enhanced {
    width: 100%;
    padding: 16px 20px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    color: #1e293b;
    font-size: 16px;
    transition: all 0.3s ease;
    font-weight: 400;
}

.form-control-enhanced:focus {
    outline: none;
    border-color: #1e293b;
    box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
    background: #ffffff;
}

.select-wrapper {
    position: relative;
}

.select-arrow {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    font-size: 12px;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix {
    position: absolute;
    left: 16px;
    color: #64748b;
    font-weight: 600;
    z-index: 2;
}

.amount-input {
    padding-left: 50px;
}

.textarea-enhanced {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

.form-hint {
    color: #9ca3af;
    font-size: 12px;
    margin-top: 6px;
    display: block;
}

/* Form Actions */
.form-actions-section {
    border-top: 1px solid #f3f4f6;
    padding-top: 32px;
}

.actions-wrapper {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 20px;
}

.btn-primary-action {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    position: relative;
    overflow: hidden;
}

.btn-primary-action:hover {
    background: linear-gradient(135deg, #334155 0%, #475569 100%);
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(30, 41, 59, 0.3);
}

.btn-secondary-action {
    background: transparent;
    border: 2px solid #e2e8f0;
    color: #64748b;
}

.btn-secondary-action:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #1e293b;
    transform: translateY(-2px);
}

.btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-primary-action:hover .btn-glow {
    left: 100%;
}

.form-meta {
    text-align: center;
}

.meta-text {
    color: #9ca3af;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .enhanced-group.full-width {
        grid-column: 1;
    }
    
    .actions-wrapper {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-luxury {
        width: 100%;
        max-width: 300px;
    }
    
    .panel-header-enhanced {
        padding: 24px 20px;
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }
    
    .luxury-form {
        padding: 24px 20px;
    }
}

/* Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
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
</style>

@endsection