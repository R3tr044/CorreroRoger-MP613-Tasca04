<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['usuari'])) {
    header('Location: cataleg.php');
} else {
    header('Location: login.php');
}
exit;