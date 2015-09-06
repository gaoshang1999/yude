<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = ['orderno', 'totalprice', 'receiver', 'phone', 'postcode', 'address', 'paymode', 'paytime', 'payload', 'user_id'];

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * 是否成功完成支付
     */
    public function isSuccessfullyPayed()
    {
        return $this->paytime != null;
    }
    
   
    /**
     * 支付成功后，调用该方法，调能力天空接口，开通课程
     */
    public function openCourses()
    {  
        $course_ids = []; //课程id, 用于开通课程
        $item_ids = [];  //oderitem is, 用于开通成功后更新状态
        $items = $this->orderItems();        
        foreach ($items as $k => $v)
        {
            if($v->isCourse()){
                $course_ids []= $v->course()->id ;
                $item_id []= $v->id ;
            }
        }
        $user = $this->user();
        
        $ablesky= app('Ablesky');
        $retcode = $ablesky->openCategory($user->name, join(",", $course_ids));
        
        if($retcode)
        {
            OrderItem::whereIn('id', $item_ids) ->update(['is_opened' => true]);
        }
    }
}
