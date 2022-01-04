<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use SoftDeletes;
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

       public function sendPasswordResetNotification($token)
      {
          $this->notify(new ResetPassword($token));
      }

      public function membership()
      {
          return $this->belongsTo('App\Membership');
      }

    public function meetings()
    {
        return $this->hasMany('App\Meeting');
    }

    public function participant()
    {
        return $this->hasMany(Participant::class);
    }


}
