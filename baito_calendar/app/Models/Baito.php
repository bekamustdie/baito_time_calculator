<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Baito extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.  
     *
     * @var list<string>
     */
    protected $guarded = [];

    protected $table = 'baito';

    // protected $casts = [
    //     'date'=>'date:m-d-Y'
    // ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

