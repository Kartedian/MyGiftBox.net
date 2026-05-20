<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Coffret2presta extends Model
{
    protected $table = 'coffret2presta';
    protected $primaryKey = ['coffret_id', 'presta_id'];
    public $timestamps = false;
    public $incrementing = false;
    protected  $keyType = 'string';

    function coffret()
    {
        return $this->belongsTo(Coffret::class, 'coffret_id', 'id');
    }

    function coffret_type(){
        return $this->belongsTo(Coffret_type::class, 'coffret_id', 'id');
    }
}