<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/protegeix.php';
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';
// Afegir al cistell per POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id_producte']) ? (int)$_POST['id_producte'] : 0;
    $quantitat = isset($_POST['quantitat']) ? (int)$_POST['quantitat'] : 0;
    // Validació rigorosa
    if (isset($dades['productes'][$id]) && $quantitat >= 1 && $quantitat <= 5) {
        if (!isset($_SESSION['cistell'])) {
            $_SESSION['cistell'] = [];
        }
        if (isset($_SESSION['cistell'][$id])) {
            $_SESSION['cistell'][$id] += $quantitat;
        } else {
            $_SESSION['cistell'][$id] = $quantitat;
        }
        $nomProducte = $dades['productes'][$id]['nom'];
        afegeixMissatge("S'han afegit {$quantitat} {$nomProducte}");
    }
    header('Location: cataleg.php');
    exit;
}
require_once __DIR__ . '/inc/capcalera.php';
?>
<h2 class="mb-4">Catàleg de Productes</h2>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Producte</th>
                        <th>Preu</th>
                        <th class="text-end" style="width: 220px;">Quantitat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dades['productes'] as $id => $producte): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($producte['nom']) ?></strong></td>
                            <td><?= number_format($producte['preu'], 2, ',', '.') ?> €</td>
                            <td class="text-end">
                                <form method="POST" action="" class="d-flex justify-content-end gap-2">
                                    <input type="hidden" name="id_producte" value="<?= $id ?>">
                                    <input type="number" name="quantitat" value="1" min="1" max="5" class="form-control form-control-sm text-center" style="width: 70px;" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Afegir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/inc/peu.php'; ?>