<?php

namespace Dwm\MyGiftBox\infrastructure;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'theme';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function coffrets_type()
    {
        return $this->hasMany(Coffret_type::class, 'theme_id', 'id');
    }
}
