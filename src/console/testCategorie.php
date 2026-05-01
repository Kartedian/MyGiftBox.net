<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Categorie.php';

use Illuminate\Database\Capsule\Manager as DB;
use MyGiftBox\Models\Categorie;

$config = parse_ini_file(__DIR__ . '/../../conf/confdb.ini');

if ($config === false) {
	fwrite(STDERR, "Impossible de lire le fichier de configuration de la base de donnees.\n");
	exit(1);
}

$db = new DB();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$categories = Categorie::query()
	->orderBy('id')
	->get(['id', 'libelle', 'description']);

if ($categories->isEmpty()) {
	fwrite(STDOUT, "Aucune categorie trouvee.\n");
	exit(0);
}

foreach ($categories as $categorie) {
	fwrite(
		STDOUT,
		sprintf(
			"[%d] %s\n%s\n\n",
			$categorie->id,
			$categorie->libelle,
			$categorie->description ?? ''
		)
	);
}
