<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Redirigir a login si no s'ha iniciat la sessió
if (!isset($_SESSION['usuari'])) {
    header('Location: login.php');
    exit;
}
// Timeout per inactivitat de 10 minuts (600 segons)
$tempsInactivitat = 600;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $tempsInactivitat)) {
    // Netejar la sessió i redirigir amb avís de caducitat
    session_unset();
    session_destroy();
    header('Location: login.php?expirada=1');
    exit;
}
// Actualitzar l'últim temps d'activitat
$_SESSION['last_activity'] = time();