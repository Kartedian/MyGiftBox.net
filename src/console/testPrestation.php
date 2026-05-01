<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Categorie.php';
require_once __DIR__ . '/../models/Prestation.php';

use Illuminate\Database\Capsule\Manager as DB;
use MyGiftBox\Models\Prestation;

$config = parse_ini_file(__DIR__ . '/../../conf/confdb.ini');

if ($config === false) {
	fwrite(STDERR, "Impossible de lire le fichier de configuration de la base de donnees.\n");
	exit(1);
}

$db = new DB();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$prestations = Prestation::query()
    ->orderBy('id')
    ->get(['id', 'libelle', 'description','unite', 'tarif']);

if ($prestations->isEmpty()) {
	fwrite(STDOUT, "Aucune prestation trouvee.\n");
	exit(0);
}

foreach ($prestations as $prestation) {
    fwrite(
        STDOUT,
        sprintf(
            "[%d] %s\n%s\nUnite: %s\nTarif: %.2f\n\n",
            $prestation->id,
            $prestation->libelle,
            $prestation->description ?? '',
            $prestation->unite,
            $prestation->tarif
        )
    );
}


function findPrestationById(String $id): ?Prestation
{
    return Prestation::query()->find($id);

}

$test = findPrestationById("01d57b87-8c0f-4ef1-8ce5-b6b82d4a8ec5");

if ($test === null) {
    fwrite(STDERR, "Prestation ID 01d57b87-8c0f-4ef1-8ce5-b6b82d4a8ec5 introuvable\n");
} else {
    fwrite(STDOUT, "Test ID 01d57b87-8c0f-4ef1-8ce5-b6b82d4a8ec5 : " . $test->libelle . " / " . $test->description . " / " . $test->unite . " / " . $test->tarif . "\n\n");
}


