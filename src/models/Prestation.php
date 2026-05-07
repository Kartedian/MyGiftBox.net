<?php
namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    function categorie()
    {
        return $this->belongsTo(Categorie::class, 'cat_id', 'id');
    }
}