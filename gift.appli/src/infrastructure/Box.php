<?php

namespace Dwm\MyGiftBox\infrastructure;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'box';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'token',
        'libelle',
        'description',
        'montant',
        'kdo',
        'message_kdo',
        'statut',
        'created_at',
        'createur_id',
    ];

    const STATUT_BROUILLON    = 1;
    const STATUT_EN_ATTENTE   = 2;
    const STATUT_PAYE         = 3;
    const STATUT_VALIDE       = 4;
    const STATUT_ACTIF        = 5;

    public function user()
    {
        return $this->belongsTo(User::class, 'createur_id', 'id');
    }

    public function prestations()
    {
        return $this->belongsToMany(
            Prestation::class,
            'box2presta',
            'box_id',
            'presta_id'
        )->withPivot('quantite');
    }
}
