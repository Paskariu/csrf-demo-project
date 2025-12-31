<?php
session_name('VULNERABLE_BANK_SESSION');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'None'
]);
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$target = '';
$amount = 0;

if ($method === 'GET') {
    $target = $_GET['target'] ?? '';
    $amount = floatval($_GET['amount'] ?? 0);
} elseif ($method === 'POST') {
    $target = $_POST['target'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
}

if (empty($target) || $amount <= 0) {
    header('Location: index.php?error=' . urlencode('Invalid input'));
    exit;
}

$_SESSION['balance'] -= $amount;
$_SESSION['transactions'][] = [
    'date' => date('Y-m-d H:i:s'),
    'target' => $target,
    'amount' => $amount,
    'balance_after' => $_SESSION['balance'],
    'method' => $method
];

header('Location: index.php?success=1');
exit;
