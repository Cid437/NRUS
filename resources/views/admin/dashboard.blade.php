@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="bg-dark text-white py-4" style="margin: -1.5rem -1.5rem 2rem -1.5rem;">
        <div class="container">
            <h1 class="display-5 fw-bold mb-0">Admin Dashboard</h1>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Sales</h6>
                        <h3 class="text-primary">{{ format_currency(\App\Models\Transaction::sum('total')) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Orders</h6>
                        <h3 class="text-success">{{ \App\Models\Transaction::count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Users</h6>
                        <h3 class="text-info">{{ \App\Models\User::count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Products</h6>
                        <h3 class="text-warning">{{ \App\Models\Product::count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Monthly Sales (Current Year)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="yearlySalesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Sales by Product</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Range Filter for Sales Chart -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Sales by Date Range</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">From Date</label>
                                <input type="date" id="fromDate" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">To Date</label>
                                <input type="date" id="toDate" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100" onclick="loadRangeChart()">Filter</button>
                            </div>
                        </div>
                        <canvas id="rangeSalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.products.index') }}" class="card text-decoration-none text-dark shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6>Manage Products</h6>
                        <p class="text-muted mb-0">{{ \App\Models\Product::count() }} products</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.users.index') }}" class="card text-decoration-none text-dark shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6>Manage Users</h6>
                        <p class="text-muted mb-0">{{ \App\Models\User::count() }} users</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.reviews.index') }}" class="card text-decoration-none text-dark shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6>Manage Reviews</h6>
                        <p class="text-muted mb-0">{{ \App\Models\Review::count() }} reviews</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.transactions.index') }}" class="card text-decoration-none text-dark shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6>Manage Transactions</h6>
                        <p class="text-muted mb-0">{{ \App\Models\Transaction::count() }} orders</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Sales Chart
fetch('{{ route("charts.monthly") }}')
    .then(response => response.json())
    .then(data => {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthlyData = new Array(12).fill(0);
        data.forEach(item => {
            if (item.month) monthlyData[item.month - 1] = item.total;
        });
        new Chart(document.getElementById('yearlySalesChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Sales',
                    data: monthlyData,
                    borderColor: '#000',
                    backgroundColor: 'rgba(0,0,0,0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });

// Product Pie Chart
fetch('{{ route("charts.pie") }}')
    .then(response => response.json())
    .then(data => {
        const colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        new Chart(document.getElementById('productPieChart'), {
            type: 'pie',
            data: {
                labels: data.map(d => d.name),
                datasets: [{
                    data: data.map(d => d.total),
                    backgroundColor: colors
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });

// Range Sales Chart
function loadRangeChart() {
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;
    const url = `{{ route("charts.range") }}?from=${from}&to=${to}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('rangeSalesChart'), {
                type: 'bar',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Sales',
                        data: data.map(d => d.total),
                        backgroundColor: '#000'
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
}
</script>
@endpush