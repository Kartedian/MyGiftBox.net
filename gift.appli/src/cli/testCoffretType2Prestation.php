<?php

declare(strict_types=1);

require_once __DIR__.'/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Dwm\MyGiftBox\models\Coffret_type;
use Dwm\MyGiftBox\models\Coffret2presta;
use Dwm\MyGiftBox\models\Coffret;
use Dwm\MyGiftBox\models\Prestation;

$config = parse_ini_file(__DIR__."/../../conf/confdb.ini");

if ($config === false) {
    fwrite(STDERR, "Impossible de lire le fichier de configuration de la base de donnees.\n");
    exit(1);
}

$db = new DB();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

print("Coffret sans type\n\n");

$coffrets = Coffret::with('prestations')->get();

foreach ($coffrets as $coffret){
    fwrite(STDOUT, 'libelle : '.$coffret->libelle."\n");
    print("Prestation : ");
    foreach ($coffret->prestations as $prestation){
        fwrite(STDOUT, $prestation->libelle.", ");
    }
    print("\n\n");
}

print("////////////////////////////////////////////////////////////////////////\n\n");

print("Coffret avec type\n\n");

$coffrets = Coffret_type::with('prestations', 'themes')->get();

foreach ($coffrets as $coffret){
    fwrite(STDOUT, 'libelle : '.$coffret->libelle."\n");
    print("Type : ");
    foreach ($coffret->themes as $theme) {
        fwrite(STDOUT, $theme->libelle);
    }
    print("\nPrestation : ");
    foreach ($coffret->prestations as $prestation){
        fwrite(STDOUT, $prestation->libelle.", ");
    }
    print("\n\n");
}