<?php

namespace Dwm\MyGiftBox\infrastructure;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasUuids;

    protected $table = 'prestation';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'cat_id', 'id');
    }

    public function coffrets()
    {
        return $this->belongsToMany(Coffret::class, 'coffret2presta', 'presta_id', 'coffret_id');
    }

    public function coffrets_type()
    {
        return $this->belongsToMany(Coffret_type::class, 'coffret2presta', 'presta_id', 'coffret_id');
    }
}
