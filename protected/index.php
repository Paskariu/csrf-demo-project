<?php
session_name('PROTECTED_BANK_SESSION');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['balance'])) {
    $_SESSION['balance'] = 300.00;
    $_SESSION['transactions'] = [];
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}

$balance = $_SESSION['balance'];
$transactions = $_SESSION['transactions'];
$username = $_SESSION['username'];
$csrf_token = $_SESSION['csrf_token'];
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
        <header>
            <h1>Geschützte Bank</h1>
            <div class="user-info">
                <span>Willkommen, <?php echo htmlspecialchars($username); ?></span>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </header>

        <div class="balance-card">
            <h2>Aktueller Kontostand</h2>
            <div class="balance-amount">€<?php echo number_format($balance, 2); ?></div>
        </div>

        <div class="transfer-section">
            <h2>Geld überweisen</h2>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Überweisung erfolgreich</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="transfer.php" method="POST" class="transfer-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                
                <div class="form-group">
                    <label for="target">Zielaccount:</label>
                    <input type="text" id="target" name="target" required>
                </div>
                <div class="form-group">
                    <label for="amount">Menge (€):</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Überweisen (Protected)</button>
            </form>
        </div>

        <div class="transactions-section">
            <h2>Überweisungshistorie</h2>
            <?php if (empty($transactions)): ?>
                <p class="no-transactions">Keine Überweisungen.</p>
            <?php else: ?>
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Zielaccount</th>
                            <th>Menge</th>
                            <th>Neuer Kontostand</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($transactions) as $transaction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['date']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['target']); ?></td>
                                <td class="amount-negative">-€<?php echo number_format($transaction['amount'], 2); ?></td>
                                <td>€<?php echo number_format($transaction['balance_after'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
