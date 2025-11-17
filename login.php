<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    header('Location: barang/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<style
e>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

:root {
  --primary: #5ca6efff;
  --bg: #f4faff;
  --text: #1a1a1a;
}

body {
  background: linear-gradient(135deg, var(--primary-light) 0%, var(--bg) 100%);
}


.login-container {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 20px;
}

.login-card {
  background: var(--white);
  border-radius: 20px;
  padding: 40px 50px;
  box-shadow: 0 10px 30px var(--shadow);
  max-width: 380px;
  width: 100%;
  text-align: center;
  transition: all 0.3s ease;
}



.login-card h2 {
  margin-bottom: 25px;
  color: var(--primary);
  font-weight: 600;
  font-size: 1.8rem;
}

.form-group {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  padding: 12px 15px;
  border: 2px solid transparent;
  border-radius: 10px;
  background: #f1f7ff;
  box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
  font-size: 15px;
  transition: all 0.3s ease;
}

.form-control:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(30, 144, 255, 0.2);
  background: var(--white);
}

.btn {
  display: inline-block;
  padding: 12px 20px;
  border: none;
  border-radius: 10px;
  background: var(--primary);
  color: var(--white);
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  width: 100%;
  box-shadow: 0 5px65 10px rgba(30, 144, 255, 0.3);
}

.btn:hover {
  background: #187bcd;

}
@media (max-width: 480px) {
  .login-card {
    padding: 30px 25px;
  }

  .login-card h2 {
    font-size: 1.5rem;
  }
}

</style>

<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Inventaris Login</h2>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 1) {
                    echo '<p style="color: red; margin-bottom: 15px;">Username atau password salah.</p>';
                } elseif ($_GET['error'] == 2) {
                    echo '<p style="color: red; margin-bottom: 15px;">Verifikasi reCAPTCHA gagal. Silakan coba lagi.</p>';
                }
            }
            ?>
            <form action="proses_login.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="g-recaptcha" data-sitekey="6LfjCwwsAAAAAKMTGKQScjRQ2lA3VAz7z6pUPT_r"></div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>