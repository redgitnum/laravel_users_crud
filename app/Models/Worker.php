<?php

namespace App\Models;

use App\Traits\Observable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory, Observable;

    protected $fillable = [
        'user_id',
        'postal_state',
        'postal_city',
        'postal_code',
        'postal_street',
        'postal_number',
        'address_state',
        'address_city',
        'address_code',
        'address_street',
        'address_number',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function logSubject(Model $model): string
    {
        return sprintf( "Model [id:%d], User [id:%d]",
            $model->id, $model->user_id
        );
    }
}
