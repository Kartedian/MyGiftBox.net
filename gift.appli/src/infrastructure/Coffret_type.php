<?php

namespace Dwm\MyGiftBox\infrastructure;

use Illuminate\Database\Eloquent\Model;

class Coffret_type extends Model
{
    protected $table = 'coffret_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }

    public function prestations()
    {
        return $this->belongsToMany(Prestation::class, 'coffret2presta', 'coffret_id', 'presta_id');
    }
}
