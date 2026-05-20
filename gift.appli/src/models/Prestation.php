<?php
namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $keyType = 'string';

    function categorie()
    {
        return $this->belongsTo(Categorie::class, 'cat_id', 'id');
    }

    function coffrets(){
        return $this->belongsToMany(Coffret::class, 'coffret2presta', 'presta_id', 'coffret_id');
    }

    function coffrets_type(){
        return $this->belongsToMany(Coffret_type::class, 'coffret2presta', 'presta_id', 'coffret_id');
    }
}