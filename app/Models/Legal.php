<?php

namespace App\Models;

use App\Services\Sign\Sign;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function registrars(): HasManyThrough
    {
        return $this->hasManyThrough(Registrar::class, Unit::class);
    }

    public function store(Request $request): static
    {
        $this->fill($request->all());

        if ($request->hasFile('key')) {
            $this->key = $request->file('key')->getContent();

            if (!$request->hasFile('cert')) {
                $this->cert = app(Sign::class)->cert($this);
                if (!$this->cert) {
                    throw new HttpException(
                        Response::HTTP_UNPROCESSABLE_ENTITY,
                        'Error while the certificate creating. Check the key file and password.'
                    );
                }
            }
        }

        if ($request->hasFile('cert')) {
            $this->cert = $request->file('cert')->getContent();
        }

        $this->save();

        return $this;
    }
}
