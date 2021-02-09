<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Registrar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registrars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'number_local',
        'last_number_local',
        'number_fiscal',
        'last_number_local',
        'name',
        'on',
        'closed',
    ];

    protected $casts = [
        'default' => 'boolean',
        'closed' => 'boolean'
    ];

    protected $dates = [
        'opened_at',
        'closed_at',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function legal(): HasOneThrough
    {
        return $this->hasOneThrough(
            Legal::class,
            Unit::class,
            'id',
            'id',
            'unit_id',
            'legal_id'
        );
    }

    public function isClosed()
    {
        return $this->getAttribute('closed');
    }
}
