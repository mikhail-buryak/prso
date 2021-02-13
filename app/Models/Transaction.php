<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

abstract class Transaction extends Model
{
    const TYPE_SHIFT_OPEN = 100;
    const TYPE_RECEIPT = 0;
    const TYPE_Z_REPORT = 1;
    const TYPE_SHIFT_CLOSE = 101;

    public int $type;
    public int $sub_type = 0;

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setAttribute('type', $this->type);
        $this->setAttribute('sub_type', $this->sub_type);

        if (!$this->uuid) {
            $this->uuid = Str::uuid();
        }
    }

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

    public abstract function makeRequest(): string;
}
