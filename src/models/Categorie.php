<?php
namespace MyGiftBox\Models;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;


    function prestations()
    {
        return $this->hasMany(Prestation::class, 'categorie_id', 'id');
    }
}
