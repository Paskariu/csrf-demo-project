<?php
session_name('PROTECTED_BANK_SESSION');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?error=' . urlencode('Only POST requests are allowed for transfers'));
    exit;
}

$submitted_token = $_POST['csrf_token'] ?? '';
$session_token = $_SESSION['csrf_token'] ?? '';

if (empty($session_token) || empty($submitted_token)) {
    header('Location: index.php?error=' . urlencode('CSRF token missing'));
    exit;
}

if (!hash_equals($session_token, $submitted_token)) {
    header('Location: index.php?error=' . urlencode('Invalid CSRF token'));
    exit;
}

$target = $_POST['target'] ?? '';
$amount = floatval($_POST['amount'] ?? 0);

if (empty($target) || $amount <= 0) {
    header('Location: index.php?error=' . urlencode('Invalid input'));
    exit;
}

$_SESSION['balance'] -= $amount;
$_SESSION['transactions'][] = [
    'date' => date('Y-m-d H:i:s'),
    'target' => $target,
    'amount' => $amount,
    'balance_after' => $_SESSION['balance']
];

// regenerate token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

header('Location: index.php?success=1');
exit;
