<?php
session_name('VULNERABLE_BANK_SESSION');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'None'
]);
session_start();
session_destroy();
header('Location: login.php');
exit;
