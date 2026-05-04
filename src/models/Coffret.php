<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Coffret extends Model
{
    protected $table = 'coffret';
    protected $primaryKey = 'id';
    public $timestamps = false;
}