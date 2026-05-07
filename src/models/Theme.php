<?php

namespace Dwm\MyGiftBox\models;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'theme';
    protected $primaryKey = 'id';
    public $timestamps = false;

    function coffrets_type()
    {
        return $this->HasMany(Coffret_type::class, 'theme_id', 'id');
    }
}