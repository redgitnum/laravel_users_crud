<?php

namespace App\Models;

use App\Traits\Observable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory, Observable;

    protected $fillable = [
        'user_id',
        'phone_number',
        'education'
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
