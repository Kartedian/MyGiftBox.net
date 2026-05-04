<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Box2presta extends Model
{
    protected $table = 'box2presta';
    protected $primaryKey = ['box_id', 'presta_id'];

    public $timestamps = false;
    public $incrementing = false;
    protected  $keyType = 'string';
}