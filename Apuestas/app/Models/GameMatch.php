<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    protected $table = 'matches';
    protected $fillable = [
        'sport_id',
        'team_home_id',
        'team_away_id',
        'match_date',
        'home_score',
        'away_score',
        'status',
    ];
}