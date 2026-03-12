<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MineGame extends Model
{
    protected $fillable = [
        'user_id',
        'bet_amount',
        'mines',
        'multiplier',
        'winnings',
        'status',
    ];
}