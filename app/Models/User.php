<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = ['user_id', 'password', 'id_role'];

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'id_user', 'id_user');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id_user', 'id_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'id_user', 'id_user');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}
