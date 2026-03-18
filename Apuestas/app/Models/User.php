<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'balance', 'role'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['balance' => 'decimal:2'];

    public function bets()         { return $this->hasMany(Bet::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function isAdmin()      { return $this->role === 'admin'; }
}
