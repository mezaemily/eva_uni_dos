<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject 
{
    use Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'balance', 'role'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['balance' => 'decimal:2'];

    public function bets()         { return $this->hasMany(Bet::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function isAdmin()      { return $this->role === 'admin'; }

     /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     /**
     * Get the identifier that will be stored in the JWT token.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return an array with custom claims to be added to the JWT token.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
