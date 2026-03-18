<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = ['creator_id','opponent_id','status'];
    public function creator()       { return $this->belongsTo(User::class, 'creator_id'); }
    public function opponent()      { return $this->belongsTo(User::class, 'opponent_id'); }
    public function challengeBets() { return $this->hasMany(ChallengeBet::class); }
}
