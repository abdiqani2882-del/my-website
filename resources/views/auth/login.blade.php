<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portfolio & Document Manager</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            background: #FFFFFF;
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .brand-header {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            padding: 40px 30px;
            text-align: center;
            color: #FFFFFF;
        }
        .brand-header i {
            font-size: 3rem;
            margin-bottom: 15px;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #E2E8F0;
            background-color: #F8FAFC;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            background-color: #FFFFFF;
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .btn-primary {
            background-color: #2563EB;
            border-color: #2563EB;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #1D4ED8;
            border-color: #1D4ED8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .text-muted-custom {
            color: #64748B;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-header">
        <i class="fa-solid fa-briefcase"></i>
        <h4 class="mb-1 fw-bold">Portfolio Manager</h4>
        <p class="mb-0 opacity-75 small">Document Management System</p>
    </div>
    <div class="login-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label text-muted-custom small fw-medium">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-light text-muted"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control border-start-0 bg-light" placeholder="admin@portfolio.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label text-muted-custom small fw-medium">Password</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted-custom small" for="remember">
                        Remember Me
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                Sign In <i class="fa-solid fa-right-to-bracket ms-2"></i>
            </button>
        </form>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
