<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $fillable = ['name'];
    public function teams()   { return $this->hasMany(Team::class); }
    public function matches() { return $this->hasMany(GameMatch::class, 'sport_id'); }
}
