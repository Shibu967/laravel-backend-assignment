<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin-Customer Inventory System</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 text-center" style="max-width: 520px; width: 100%;">
            <h2 class="mb-3 fw-bold">
                Admin-Customer Inventory System
            </h2>
            <p class="text-muted">
                This system provides separate access for Admins and Customers,
                with features like product management, bulk import, and real-time monitoring.
            </p>
            <hr>
            <h5 class="mb-3">Login As</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.login') }}" class="btn btn-primary">
                    Admin Login
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                    Customer Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
