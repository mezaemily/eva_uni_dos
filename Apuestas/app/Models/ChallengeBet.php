<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChallengeBet extends Model
{
    protected $fillable = [
        'challenge_id',
        'bet_id',
    ];
}