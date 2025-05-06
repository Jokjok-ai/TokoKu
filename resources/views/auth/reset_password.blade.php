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

<<div class="container">
    <h2>Reset Password</h2>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label>Password Baru</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</div>


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