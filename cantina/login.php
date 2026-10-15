<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';
// Si ja hi ha sessió oberta, portar directament al catàleg
if (isset($_SESSION['usuari'])) {
    header('Location: cataleg.php');
    exit;
}
$error = '';
$emailGuardat = '';
if (isset($_GET['expirada']) && $_GET['expirada'] === '1') {
    $error = 'La sessió ha caducat per inactivitat.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailGuardat = trim($_POST['email'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';
    $usuariTrobat = buscaUsuari($dades['usuaris'], $emailGuardat);
    // Verificació de contrasenya (suporta hash i text pla)
    if ($usuariTrobat && (
        password_verify($contrasenya, $usuariTrobat['contrasenya']) ||
        $contrasenya === $usuariTrobat['contrasenya']
    )) {
        // Regenerar l'ID de sessió per seguretat
        session_regenerate_id(true);
        $_SESSION['usuari'] = [
            'nom' => $usuariTrobat['nom'],
            'email' => $usuariTrobat['email'],
            'rol' => $usuariTrobat['rol'],
            'login_time' => time()
        ];
        $_SESSION['last_activity'] = time();
        header('Location: cataleg.php');
        exit;
    } else {
        $error = 'Credencials incorrectes';
    }
}
require_once __DIR__ . '/inc/capcalera.php';
?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Iniciar Sessió - Cantina</h4>
            </div>
            <div class="card-body p-4">
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adreça electrònica:</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($emailGuardat) ?>" required placeholder="usuari@lacetania.cat">
                    </div>
                    <div class="mb-3">
                        <label for="contrasenya" class="form-label">Contrasenya:</label>
                        <input type="password" class="form-control" id="contrasenya" name="contrasenya" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/inc/peu.php'; ?>