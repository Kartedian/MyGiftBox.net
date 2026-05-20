<?php

declare(strict_types=1);

require_once __DIR__.'/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Dwm\MyGiftBox\Models\Categorie;
use Dwm\MyGiftBox\Models\Prestation;

$config = parse_ini_file(__DIR__.'/../../conf/confdb.ini');

if ($config === false) {
    fwrite(STDERR, "Impossible de lire le fichier de configuration de la base de donnees.\n");
    exit(1);
}

$db = new DB();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$categorie3 = Categorie::query()->where('id', 3)->get(['id', 'libelle', 'description']);

foreach ($categorie3 as $categorie) {
    $id = $categorie->id;
    fwrite(
        STDOUT,
        sprintf(
            "[%d] %s\n%s",
            $categorie->id,
            $categorie->libelle,
            $categorie->description ?? ''
        )
    );
}

$prestations_3 = Prestation::query()->where('cat_id', $id)->get(['id', 'libelle', 'description', 'url', 'unite', 'tarif', 'img']);

foreach ($prestations_3 as $prestation){
    fwrite(STDOUT, sprintf("\n\nid:%s\nlibelle: %s\ndescription : %s\nurl: %s\nunite: %s\ntarif: %.2f\nimg: %s",
        $prestation->id,
        $prestation->libelle,
        $prestation->description,
        $prestation->url,
        $prestation->unite,
        $prestation->tarif,
        $prestation->img));
}

echo "\n\n////////////////////////////////////////////////////////////////////\n\n";

$prestations = Prestation::query()->orderBy('id')->get();

foreach ($prestations as $prestation){
    $categorie = Categorie::query()->where('id', $prestation->cat_id)->get();
    fwrite(STDOUT, $prestation->libelle."\n");
    echo "Categorie: ";
    foreach ($categorie as $cat){
        fwrite(STDOUT, $cat->libelle.", ");
    }
    echo "\n\n";
}

echo "\n\n////////////////////////////////////////////////////////////////////\n\n";

$categories = Categorie::with('prestations')->get();

foreach ($categories as $categorie){
    fwrite(STDOUT, $categorie->libelle."\n");
    echo "Prestation: ";
    foreach ($categorie->prestations as $prestation){
        fwrite(STDOUT, $prestation->libelle.", ");
    }
    echo "\n\n";
}
