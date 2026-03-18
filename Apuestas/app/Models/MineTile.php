<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MineTile extends Model
{
    public $timestamps = false;
    protected $fillable = ['game_id','position','is_mine','revealed'];
    protected $casts    = ['is_mine' => 'boolean', 'revealed' => 'boolean'];
    public function game() { return $this->belongsTo(MineGame::class, 'game_id'); }
}
