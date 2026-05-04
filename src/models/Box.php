<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'box';
    protected $primaryKey = 'id';
    public $timestamps = false;

    function user(){
        return $this->belongsTo(User::class, 'createur_id', 'id');
    }
}