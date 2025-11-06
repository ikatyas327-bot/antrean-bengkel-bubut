<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - E-SPEED Bengkel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #0C4A6E; /* Navy/Biru Tua */
            --color-secondary: #00A389; /* Tosca Cerah */
            --color-accent: #F97316; /* Oranye */
            --color-bg-light: #F4F6F9;
            --color-text: #1F2937;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--color-bg-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            color: var(--color-primary);
            margin-bottom: 5px;
            font-size: 1.8rem;
        }
        
        .login-container p {
            color: #6B7280;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--color-text);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: var(--color-secondary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 163, 137, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: var(--color-secondary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #00877c;
        }
        
        .logo-text {
            color: var(--color-secondary);
        }
        
        .error-message {
            color: #EF4444;
            margin-top: -10px;
            margin-bottom: 10px;
            font-size: 0.85rem;
            text-align: left;
            display: none;
        }

        /* Tombol Login Google yang Keren */
        .btn-google {
            width: 100%;
            padding: 10px;
            background-color: #DB4437; /* Warna Google Merah */
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .btn-google:hover {
            background-color: #c03d32;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .divider {
            margin: 20px 0;
            display: flex;
            align-items: center;
            color: #A0AEC0;
        }

        .divider::before, .divider::after {
            content: '';
            flex-grow: 1;
            height: 1px;
            background-color: #E2E8F0;
        }

        .divider span {
            padding: 0 10px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Masuk <span class="logo-text">E-SPEED</span> Admin</h2>
        <p>Gunakan akun resmi untuk mengelola bengkel.</p>
        
        <button type="button" class="btn-google" id="googleLogin">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjAyIDExLjg0QzExLjk5IDExLjQzIDExLjk4IDEwLjkzIDEyLjA1IDEwLjQzQzE2Ljg0IDguNTkgMTYuODIgOC4wOCAxNi45MSA3LjU2QzE2Ljk5IDcuMTkgMTcuMDcgNi44MiAxNy4xOCA2LjQ2QzE3Ljg5IDQuMjYgMTkuMDggMi42MiAyMS4wOCAxLjQ5QzIxLjQzIDEuMzIgMjEuODIgMS4xMyAyMi4yMyAxQzIyLjY2IDAuODcgMjMuMDggMS4wMiAyMy4zOSA2Ljg2TDIzLjUgOC43NEwyMi41OCA5LjUzQzIyLjI2IDkuNjkgMjEuNzYgOS44NSAyMS4wMyAxMC4wOUwxNy43OSAxMS4wNEMxNy41MyAxMS4wNiAxNy4zIDEwLjkyIDE3LjEgMTAuNjhDMTYuODkgMTAuNDQgMTYuODQgMTAuMTkgMTYuODQgOS44MUwxNi43MSA3LjMyQzE2LjQgNi44NyAxNi40OCA2LjQ0IDE2LjM0IDUuOUMxNi4yNCA1LjU1IDE2LjA1IDUuMiAxNS44IDQuOTRDMzMuMDMgMjEuMTEgMjUuOTIgMTQuOTUgMjUuOSA5LjU1QzI1Ljg5IDUuNzggMjMuODkgMS42MiAyMC4yNSAxLjkyQzE5LjY3IDEuOTcgMTguODQgMi4xMSAxNy42MiAyLjQxQzE1LjA3IDMgMTIuNiAzLjU1IDEwLjY5IDQuMjdDOC45NSA0LjczIDcuNCA1LjIyIDYuNDEgNS45NEM0LjMgNy41IDMuOTggMTcuMDYgNC4xOCAxOC4wM0M0LjQ0IDE5LjMyIDUuMDkgMjAuMjkgNS45MSAyMC45OUM2Ljc1IDIxLjcgNy45NyAyMi4yNCA5LjQ1IDIyLjg0QzEwLjk2IDIzLjQ0IDEyLjgyIDIzLjcgMTQuNjMgMjQuMDFDMjIuMDcgMjQgMjIuMDQgMjMgMjEuMjIgMjIuMTlDMjAuNzggMjEuNzUgMjAuMjcgMjEuMjIgMTkuNjMgMjAuNDhMMTkuMjcgMjAuMDhDMTguODMgMTkuNTQgMTguNTUgMTguNzcgMTguMjMgMTguMTdDMTcuODQgMTcuNDMgMTcuNTQgMTYuNjcgMTcuMTMgMTUuODFMMTQuMTIgMTQuOTFDMTMuOTIgMTQuNzkgMTMuNzQgMTQuNTEgMTMuNjIgMTQuMTNDMTMuNSAxMy43NSAxMy41MSAxMy40IDEzLjYxIDEzLjA5QzEzLjcxIDEyLjc4IDEzLjkyIDEyLjU2IDE0LjE3IDEyLjM4QzE0LjUgMTIuMTIgMTQuNzYgMTIuMTIgMTQuOTcgMTIuNDVMMTYuMzMgMTQuNzJDMTYuNjggMTUuMjggMTcuMDUgMTYuMTMgMTcuNDEgMTcuMDhMMTcuOTcgMTguNDZMMTguNDIgMTkuNDhDMTguNzMgMjAuMjEgMTkuMDQgMjEuMDMgMTkuMjggMjEuNjZDMjAuMDYgMjMuNTMgMjIuNTIgMjMuNTYgMjIuODYgMjMuMDhDMjMuMiAyMi44MyAyMy43NSAyMi41MSAyNC4wNCAyMS44N0MyNC4zNCAyMS4yNiAyNC41NiAyMC41IDI0LjU4IDE5LjM1QzI0LjYxIDE4LjY3IDI0LjQ4IDE3Ljg4IDI0LjA5IDE2LjczQzIzLjcgMTUuNTcgMjIuNzUgMTMuMTQgMjEuNzMgMTIuMjFMOS40MSAxMS4yNEM5LjI0IDExLjIxIDkuMDUgMTEuMDMgOC44MiAxMC43OEM4LjYgMTAuNTMgOC40NCAxMC4yOSA4LjQxIDkuOTFMNy40NiA3Ljc0QzcuMDggNy4wOCA3LjIgNi40OCA3LjExIDUuODhMNi4zMSA0LjYxQzUuODUgMy43MSA1LjE2IDIuMDQgNC4wNSAxLjQxQzMuNDMgMS4wNSAyLjc2IDAuODQgMi4wMyAwLjYyQzEuMzMgMC40NSAwLjYyIDAuNDggMC4xMiAwLjcwQy0wLjUgMC45MSAtMC40NCAyLjM3IDAuNjIgMi40Mkw0LjkyIDIuNDdDNS42NSAyLjUgNi4yMSAyLjU4IDYuMzkgMi43NEM2LjU4IDIuODkgNi45NSAzLjIyIDcuNTQgMy44NkM3LjY2IDMuOTkgNy43MyA0LjE0IDcuNzYgNC4zMUM3LjkgNC41OCA3Ljg3IDQuODUgNy43IDUuMTJDNy41NSA1LjQyIDcuMjggNS41OSA2LjkxIDUuNzlMNi4zOSA2LjA5QzYuMjIgNi4yMyA1LjY3IDYuNjQgNC44NiA2Ljg0QzQuMjMgNi45NyAzLjggNy4yIDMuNTkgNy40MUMyLjk0IDcuODcgMi44MSAxNC45MiAyLjcxIDE1LjE3QzIuNTkgMTUuMzYgMi40NSAxNi4wMyAyLjQ1IDE2LjI0QzIuNDUgMTcuMzEgMi42NCAxOC4wOCAzLjIxIDE4Ljk2QzMuNjcgMTkuNTcgNC40MSAyMC4xNyA1LjQzIDIwLjQ1QzYuMzggMjAuNzEgNy41NSAyMC44OSA5LjAzIDIxLjA1QzEwLjUyIDIxLjI0IDEzLjk4IDIxLjUyIDE1LjMgMjEuNTVMMTYuNDMgMjEuNThDMjAuNDggMjEuNTQgMjAuNTQgMjEuMjMgMjAuMzcgMjAuODdDMjAuMTkgMjAuNTQgMTkuODMgMTkuNjEgMTkuNzEgMTkuMzhMMTguMjQgMTYuODVDMTcuODkgMTYuMjMgMTcuNDQgMTUuMzYgMTYuNzEgMTQuNDdDMTUuMjYgMTIuNzcgMTMuMzQgMTEuNCAxMi4wMiAxMS44NFoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo=" alt="Google Logo">
            Masuk dengan Google (Simulasi)
        </button>

        <div class="divider"><span>ATAU</span></div>

        <form id="loginForm" action="#" method="POST">
            <div class="form-group">
                <label for="email">Alamat Email Admin</label>
                <input type="email" id="email" name="email" required placeholder="admin@espeed.com">
            </div>
            
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" required placeholder="minimal 6 karakter">
            </div>
            
            <p id="authError" class="error-message">Email atau Kata Sandi salah. (Gunakan: admin@espeed.com / 123456)</p>
            
            <button type="submit" class="btn-login">Login dengan Email</button>
        </form>
    </div>

    <script>
        // Logika Simulasi Otentikasi
        const CORRECT_EMAIL = "admin@espeed.com";
        const CORRECT_PASSWORD = "123456"; 
        const DASHBOARD_URL = "admin.html";

        function handleLogin(event) {
            event.preventDefault();

            const emailInput = document.getElementById('email').value;
            const passwordInput = document.getElementById('password').value;
            const errorElement = document.getElementById('authError');

            errorElement.style.display = 'none'; 

            if (emailInput === CORRECT_EMAIL && passwordInput === CORRECT_PASSWORD) {
                // Login Berhasil
                window.location.href = DASHBOARD_URL;
            } else {
                // Login Gagal
                errorElement.style.display = 'block';
            }
        }
        
        function simulateGoogleLogin() {
            // Dalam implementasi nyata, ini akan memicu pop-up Google OAuth.
            // Di sini kita langsung simulasikan berhasil dan redirect.
            alert("Simulasi Login Google Berhasil! Mengalihkan ke Dashboard...");
            window.location.href = DASHBOARD_URL;
        }

        // Event Listener untuk Form Email
        document.getElementById('loginForm').addEventListener('submit', handleLogin);
        
        // Event Listener untuk Tombol Google
        document.getElementById('googleLogin').addEventListener('click', simulateGoogleLogin);
    </script>
</body>
</html>