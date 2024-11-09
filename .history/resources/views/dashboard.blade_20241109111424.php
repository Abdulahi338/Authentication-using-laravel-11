<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email Management Dashboard</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Icons (Bootstrap Icons) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .sidebar {
        height: 100vh;
        width: 250px;
        background-color: #343a40;
        color: #fff;
        position: fixed;
    }
    .sidebar .nav-link {
        color: #adb5bd;
        padding: 10px 15px;
    }
    .sidebar .nav-link.active {
        background-color: #495057;
        color: #fff;
    }
    .sidebar .btn {
        width: 100%;
        margin-bottom: 10px;
        text-align: left;
    }
    .content {
        margin-left: 250px;
        padding: 20px;
    }
</style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-center py-3">Email Manager</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="fas fa-inbox me-2"></i> Incoming Emails</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="fas fa-paper-plane me-2"></i> Outgoing Emails</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/posts') }}"  class="nav-link"><i class="fas fa-envelope-open-text me-2"></i> Create Email</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/posts/create') }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i> Create Post</a>           
            </li>
            <li class="nav-item">
                <a href="{{ url('/posts') }}" class="btn btn-secondary"><i class="fas fa-table me-2"></i> Go to Posts</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="fas fa-cog me-2"></i> Settings</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i> Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Dashboard Overview Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Incoming Emails</h5>
                        <h2>50</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Outgoing Emails</h5>
                        <h2>30</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5>Total Emails</h5>
                        <h2>80</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Table -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                Email Overview
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Type</th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-info">Incoming</span></td>
                            <td>john@example.com</td>
                            <td>Project Update</td>
                            <td>2024-11-08</td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-success">Outgoing</span></td>
                            <td>me@example.com</td>
                            <td>Meeting Schedule</td>
                            <td>2024-11-08</td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
