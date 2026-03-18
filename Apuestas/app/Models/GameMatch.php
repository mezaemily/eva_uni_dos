<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    protected $table    = 'matches';
    protected $fillable = ['sport_id','team_home_id','team_away_id','match_date','home_score','away_score','status'];
    protected $casts    = ['match_date' => 'datetime'];

    public function sport()    { return $this->belongsTo(Sport::class); }
    public function teamHome() { return $this->belongsTo(Team::class, 'team_home_id'); }
    public function teamAway() { return $this->belongsTo(Team::class, 'team_away_id'); }
    public function odds()     { return $this->hasMany(Odd::class, 'match_id'); }
    public function bets()     { return $this->hasMany(Bet::class, 'match_id'); }
    public function comments() { return $this->hasMany(Comment::class, 'match_id'); }
}
