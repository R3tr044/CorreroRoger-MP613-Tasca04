<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/protegeix.php';
require_once __DIR__ . '/inc/funcions.php';
$dades = require __DIR__ . '/inc/dades.php';
$cistell = $_SESSION['cistell'] ?? [];
// Gestió d'accions del cistell
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accio'])) {
    $accio = $_POST['accio'];
    if ($accio === 'treure') {
        $idTreure = (int)($_POST['id_producte'] ?? 0);
        if (isset($_SESSION['cistell'][$idTreure])) {
            unset($_SESSION['cistell'][$idTreure]);
            afegeixMissatge("Producte eliminat del cistell.");
        }
    } elseif ($accio === 'buidar') {
        $_SESSION['cistell'] = [];
        afegeixMissatge("El cistell s'ha buidat.");
    } elseif ($accio === 'finalitzar' && !empty($cistell)) {
        $totalComanda = totalCistell($cistell, $dades['productes']);
        $liniesComanda = [];
        foreach ($cistell as $id => $qnt) {
            if (isset($dades['productes'][$id])) {
                $liniesComanda[] = [
                    'nom' => $dades['productes'][$id]['nom'],
                    'preu' => $dades['productes'][$id]['preu'],
                    'quantitat' => $qnt
                ];
            }
        }
        if (!isset($_SESSION['comandes'])) {
            $_SESSION['comandes'] = [];
        }
        $_SESSION['comandes'][] = [
            'hora' => date('H:i:s - d/m/Y'),
            'linies' => $liniesComanda,
            'total' => $totalComanda
        ];
        $_SESSION['cistell'] = [];
        afegeixMissatge("Comanda enviada: " . number_format($totalComanda, 2, ',', '.') . " €");
    }
    header('Location: cistell.php');
    exit;
}
$totalCalculat = totalCistell($cistell, $dades['productes']);
require_once __DIR__ . '/inc/capcalera.php';
?>
<h2 class="mb-4">El teu Cistell</h2>
<?php if (empty($cistell)): ?>
    <div class="alert alert-warning shadow-sm" role="alert">
        El cistell és buit. <a href="cataleg.php" class="alert-link">Vés al catàleg per afegir productes.</a>
    </div>
<?php else: ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Producte</th>
                            <th>Preu unitari</th>
                            <th>Quantitat</th>
                            <th>Subtotal</th>
                            <th class="text-end">Acció</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cistell as $id => $quantitat): ?>
                            <?php if (isset($dades['productes'][$id])): 
                                $prod = $dades['productes'][$id];
                                $subtotal = $prod['preu'] * $quantitat;
                            ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($prod['nom']) ?></strong></td>
                                    <td><?= number_format($prod['preu'], 2, ',', '.') ?> €</td>
                                    <td><?= $quantitat ?></td>
                                    <td><?= number_format($subtotal, 2, ',', '.') ?> €</td>
                                    <td class="text-end">
                                        <form method="POST" action="" class="d-inline">
                                            <input type="hidden" name="accio" value="treure">
                                            <input type="hidden" name="id_producte" value="<?= $id ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Treure</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-light fs-5 fw-bold">
                            <td colspan="3" class="text-end">Total:</td>
                            <td colspan="2"><?= number_format($totalCalculat, 2, ',', '.') ?> €</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <form method="POST" action="">
                    <input type="hidden" name="accio" value="buidar">
                    <button type="submit" class="btn btn-outline-secondary" onclick="return confirm('Segur que vols buidar el cistell?')">Buidar el cistell</button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="accio" value="finalitzar">
                    <button type="submit" class="btn btn-success btn-lg">Finalitzar comanda</button>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Historial de Comandes de la Sessió -->
<?php if (!empty($_SESSION['comandes'])): ?>
    <h3 class="mt-5 mb-3">Historial de Comandes de la Sessió</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="list-group">
                <?php foreach ($_SESSION['comandes'] as $num => $comanda): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1">Comanda #<?= $num + 1 ?></h5>
                            <small class="text-muted"><?= htmlspecialchars($comanda['hora']) ?></small>
                        </div>
                        <ul class="mb-2">
                            <?php foreach ($comanda['linies'] as $linia): ?>
                                <li><?= htmlspecialchars($linia['nom']) ?> x<?= $linia['quantitat'] ?> (<?= number_format($linia['preu'], 2, ',', '.') ?> €/u)</li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="mb-0 fw-bold text-end">Total: <?= number_format($comanda['total'], 2, ',', '.') ?> €</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/inc/peu.php'; ?>