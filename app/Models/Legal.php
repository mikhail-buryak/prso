<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Legal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'legals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tin',
        'total_max',
        'passphrase',
    ];

    /**
     * The attributes excluded from the JSON model's.
     *
     * @var array
     */
    protected $hidden = [
        'passphrase',
        'key',
        'cert'
    ];

    public function store(Request $request)
    {
        $this->fill($request->all());

        if ($request->hasFile('key')) {
            $this->key = $request->file('key')->getContent();
        }

        if ($request->hasFile('cert')) {
            $this->cert = $request->file('cert')->getContent();
        }

        $this->save();

        return $this;
    }
}
