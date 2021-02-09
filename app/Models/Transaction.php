<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number_local',
        'number_fiscal',
        'type',
        'sub_type',
        'status',
        'fiscal_at',
        'request',
        'response',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'request',
        'response',
        'updated_at',
    ];

    protected $casts = [
        'sent' => 'boolean'
    ];

    protected $dates = [
        'fiscal_at',
    ];

    public function legal(): BelongsTo
    {
        return $this->belongsTo(Legal::class);
    }

    public function registrar(): BelongsTo
    {
        return $this->belongsTo(Registrar::class);
    }

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }
}
