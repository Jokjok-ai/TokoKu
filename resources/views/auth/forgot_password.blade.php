<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4 col-sm-8 col-10">
            <div class="card shadow-lg p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                    <h3 class="fw-bold">Welcome Back</h3>
                    <p class="text-muted">Please login to continue</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Sama struktur seperti login, ganti form dan judul -->
                <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label for="email">Email Anda</label>
        <input type="email" class="form-control" name="email" required>
    </div>
    <button class="btn btn-primary w-100">Kirim Link Reset</button>
</form>

<p class="mt-3 text-center">
    <a href="{{ route('login') }}">Kembali ke Login</a>
</p>


            </div>
        </div>
    </div>
</div>

<!-- Theme toggle button -->
<div class="theme-toggle" onclick="toggleTheme()" title="Toggle dark mode">
    <i class="fas fa-moon"></i>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleTheme() {
        const html = document.querySelector('html');
        const theme = html.dataset.bsTheme === 'light' ? 'dark' : 'light';
        html.dataset.bsTheme = theme;
        
        // Update icon
        const icon = document.querySelector('.theme-toggle i');
        icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        
        // Update title
        document.querySelector('.theme-toggle').title = theme === 'light' 
            ? 'Toggle dark mode' 
            : 'Toggle light mode';
    }
    
    // Initialize theme icon
    document.addEventListener('DOMContentLoaded', function() {
        const html = document.querySelector('html');
        const icon = document.querySelector('.theme-toggle i');
        if (html.dataset.bsTheme === 'dark') {
            icon.className = 'fas fa-sun';
            document.querySelector('.theme-toggle').title = 'Toggle light mode';
        }
    });
</script>
</body>
</html>