<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    protected $fillable = ['name', 'summary', 'rank'  , 'zx_course', 'xx_course', 'yr_course', 'enable'];
    
    public function zx()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'zx_course');
    }
    
    public function xx()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'xx_course');
    }
    
    public function yr()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'yr_course');
    }
}
