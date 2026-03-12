<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'creator_id',
        'opponent_id',
        'status',
    ];
}