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
}