<?php
declare(strict_types=1);
/* Busca un usuari per la seva adreça d'email */
function buscaUsuari(array $usuaris, string $email): ?array {
    foreach ($usuaris as $usuari) {
        if ($usuari['email'] === $email) {
            return $usuari;
        }
    }
    return null;
}
/* Retorna el número total d'unitats de productes al cistell */
function unitatsCistell(array $cistell): int {
    return array_sum($cistell);
}
/* Calcula l'import total del cistell de la compra */
function totalCistell(array $cistell, array $productes): float {
    $total = 0.0;
    foreach ($cistell as $idProducte => $quantitat) {
        if (isset($productes[$idProducte])) {
            $total += $productes[$idProducte]['preu'] * $quantitat;
        }
    }
    return $total;
}
/* Desa un missatge flash a la sessió */
function afegeixMissatge(string $text): void {
    $_SESSION['flash_msg'] = $text;
}
/* Retorna el missatge flash i el descarta de la sessió */
function llegeixMissatge(): ?string {
    if (isset($_SESSION['flash_msg'])) {
        $msg = $_SESSION['flash_msg'];
        unset($_SESSION['flash_msg']);
        return $msg;
    }
    return null;
}