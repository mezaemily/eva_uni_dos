<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MineGame extends Model
{
    protected $fillable = ['user_id','bet_amount','mines','multiplier','winnings','status'];
    public function user()  { return $this->belongsTo(User::class); }
    public function tiles() { return $this->hasMany(MineTile::class, 'game_id'); }
}
