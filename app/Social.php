<?php

namespace App;


//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Helper\UuidPrimaryKey;


class Social extends Authenticatable
{

    use  HasApiTokens, Notifiable, UuidPrimaryKey;

    /**
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'email', 'password', 'name', 'nick_name', 'provider', 'avatar'];


    /**
     * @var array
     */
    protected $hidden = [
        'password', 'uuid', 'mobile_sms'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }






}
