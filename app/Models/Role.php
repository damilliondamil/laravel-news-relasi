<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = ['nama_role'];

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'id_role', 'id_role');
    }
}
