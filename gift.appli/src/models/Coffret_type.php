<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Coffret_type extends Model
{
    protected $table = 'coffret_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    function theme(){
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }

    function themes(){
        return $this->belongsToMany(theme::class, 'coffret_type', 'theme_id', 'id');
    }

    function prestations(){
        return $this->belongsToMany(Prestation::class, 'coffret2presta', 'coffret_id', 'presta_id');
    }


}