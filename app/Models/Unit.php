<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'tax_id',
        'tin',
        'ipn',
        'name',
        'org_name',
        'address',
    ];

    protected $casts = [
        'default' => 'boolean'
    ];

    public function legal(): BelongsTo
    {
        return $this->belongsTo(Legal::class);
    }

    public function registrars(): HasMany
    {
        return $this->hasMany(Registrar::class);
    }
}
