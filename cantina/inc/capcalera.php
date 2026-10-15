<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/funcions.php';
$dadesCapcalera = require __DIR__ . '/dades.php';
$cistellSessio = $_SESSION['cistell'] ?? [];
$numUnitats = unitatsCistell($cistellSessio);
$flashMsg = llegeixMissatge();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina de l'Institut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Cantina Lacetània</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCantina">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navCantina">
            <?php if (isset($_SESSION['usuari'])): ?>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cataleg.php">Catàleg</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cistell.php">
                            Cistell <span class="badge bg-primary rounded-pill"><?= $numUnitats ?></span>
                        </a>
                    </li>
                    <?php if (($_SESSION['usuari']['rol'] ?? '') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="navbar-text text-white">
                        Hola, <strong><?= htmlspecialchars($_SESSION['usuari']['nom']) ?></strong>
                    </span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">Tancar sessió</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container pb-5">
    <?php if ($flashMsg): ?>
        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
            <?= htmlspecialchars($flashMsg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>