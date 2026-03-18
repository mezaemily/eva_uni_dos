<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChallengeBet extends Model
{
    protected $fillable = ['challenge_id','bet_id'];
    public function challenge() { return $this->belongsTo(Challenge::class); }
    public function bet()       { return $this->belongsTo(Bet::class); }
}
