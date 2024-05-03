<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
