<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone', 'role', 'is_reged'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    
    public function isAdmin()
    {
        return $this-> role == 'admin';
    }
    
    //客服
    public function iskefu()
    {
        return $this-> role == 'kefu';
    }
    
    public function isUser()
    {
        return $this-> role == 'user';
    }
    
    public function isNotUser()
    {
        return $this-> role != 'user';
    }    
    
    public function roleDesc()
    {
        switch ($this->role)
        {
            case "user":
                return "学员";
            case "kefu":
                return "客服";
            case "admin":
                return "管理员";
            
        }
    }
}
