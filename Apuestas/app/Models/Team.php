<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['sport_id', 'name', 'strength'];
    public function sport()       { return $this->belongsTo(Sport::class); }
    public function homeMatches() { return $this->hasMany(GameMatch::class, 'team_home_id'); }
    public function awayMatches() { return $this->hasMany(GameMatch::class, 'team_away_id'); }
}
