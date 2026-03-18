<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Odd extends Model
{
    protected $fillable = ['match_id', 'bet_type_id', 'option_name', 'odd_value'];
    public function match()   { return $this->belongsTo(GameMatch::class, 'match_id'); }
    public function betType() { return $this->belongsTo(BetType::class); }
    public function bets()    { return $this->hasMany(Bet::class, 'odd_id'); }
}
