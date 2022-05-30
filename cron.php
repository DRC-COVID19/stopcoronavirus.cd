<?php
// On simule l'appel à `artisan schedule:run`
$_SERVER['argv'] = [
    'artisan',
    'schedule:run',
];

// On lance artisan
require __DIR__.'/artisan';
