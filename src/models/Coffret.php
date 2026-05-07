<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Coffret extends Model
{
    protected $table = 'coffret';
    protected $primaryKey = 'id';
    public $timestamps = false;

    function prestations(){
        return $this->belongsToMany(Prestation::class, 'coffret2presta', 'coffret_id', 'presta_id');
    }
}