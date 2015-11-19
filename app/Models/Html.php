<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Html extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'htmls';

    protected $fillable = ['key', 'html'];
    
  
}
