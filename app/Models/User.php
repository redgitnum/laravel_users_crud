<?php

namespace App\Models;

use App\Traits\Observable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Observable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'password_confirmation',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'password_confirmation',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'user_type' => 'array'
    ];

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

    public function worker()
    {
        return $this->hasOne(Worker::class);
    }

    public static function logSubject(Model $model): string
    {
        return sprintf( "User [id:%d] %s/%s/%s",
            $model->id, $model->name, $model->surname, $model->email
        );
    }
}
