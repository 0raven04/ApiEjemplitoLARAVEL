<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    // Hacemos referencia a la tabla roles
    protected $table = 'roles';
    
    // Desactivar timestamps para que no busque created_at ni updated_at
    public $timestamps = false;

    // Hacer que los campos sean editables
    protected $fillable = [
        'id',
        'nombre',
    ];
    
    use HasFactory;

    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'usuario_rol',
            'rol_id',
            'usuario_id'
        );
    }
}
