<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = ['user_id','match_id','odd_id','amount','potential_win','status'];
    public function user()  { return $this->belongsTo(User::class); }
    public function match() { return $this->belongsTo(GameMatch::class, 'match_id'); }
    public function odd()   { return $this->belongsTo(Odd::class); }
}
