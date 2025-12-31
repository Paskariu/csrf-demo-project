<?php
session_name('PROTECTED_BANK_SESSION');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict' 
]);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'user' && $password === 'password') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['balance'] = 300.00;
        $_SESSION['transactions'] = [];
        
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-card">
            <h1>Geschützte Bank</h1>
            <h2>Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Passwort:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
            <div class="demo-credentials">
                <p><strong>Anmeldedaten:</strong></p>
                <p>Username: <code>user</code></p>
                <p>Passwort: <code>password</code></p>
            </div>
        </div>
    </div>
</body>
</html>
