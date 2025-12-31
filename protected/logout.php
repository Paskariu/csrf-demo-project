<?php
session_name('PROTECTED_BANK_SESSION');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
session_destroy();
header('Location: login.php');
exit;
