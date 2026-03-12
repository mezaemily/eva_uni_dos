<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Odd extends Model
{
    protected $fillable = [
        'match_id',
        'bet_type_id',
        'option_name',
        'odd_value',
    ];
}