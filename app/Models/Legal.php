<?php

namespace App\Models;

use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Legal extends Model
{
    use EncryptableDbAttribute;

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

    /**
     * The attributes that should be encrypted/decrypted
     *
     * @var array
     */
    protected $encryptable = [
        'passphrase',
        'key',
        'cert',
    ];

    public function store(Request $request): static
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
