<?php
// Dades estatiques de l'aplicació
return [
    'usuaris' => [
        [
            'email' => 'alumne@lacetania.cat',
            'nom' => 'Alumne DAW',
            'contrasenya' => password_hash('daw2026', PASSWORD_DEFAULT),
            'rol' => 'alumne'
        ],
        [
            'email' => 'cantina@lacetania.cat',
            'nom' => 'Cantina',
            'contrasenya' => password_hash('cafe2026', PASSWORD_DEFAULT),
            'rol' => 'admin'
        ],
    ],
    'productes' => [
        1 => ['nom' => 'Entrepà de pernil', 'preu' => 3.50],
        2 => ['nom' => 'Entrepà vegetal', 'preu' => 3.20],
        3 => ['nom' => 'Croissant', 'preu' => 1.40],
        4 => ['nom' => 'Suc de taronja', 'preu' => 1.80],
        5 => ['nom' => 'Cafè amb llet', 'preu' => 1.30],
        6 => ['nom' => 'Aigua', 'preu' => 1.00],
    ],
];