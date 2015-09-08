<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    protected $fillable = ['level', 'kind', 'name', 'enable', 'buytimes', 'hours', 
                            'totalprice', 'subname', 'subprice', 'zongheprice', 
                            'nengliprice', 'cover', 'video', 'trialvideo', 'summary', 
                            'pagetitle', 'pagekeyword', 'pagedescription', 
                            'ablesky_category' , 'discount_price' , 'image',
                            'description', 'hours_description', 'teacher',
                            'discount_subprice', 'discount_zongheprice', 'discount_nengliprice',
                            'sub_ablesky_category', 'zonghe_ablesky_category', 'nengli_ablesky_category'
    ];

    
    public function ablesky_category()
    {
        return $this->hasOne('App\Models\AbleskyCategory', 'id', 'ablesky_category');
    }
    
    public function sub_ablesky_category()
    {
        return $this->hasOne('App\Models\AbleskyCategory', 'id', 'sub_ablesky_category');
    }
    public function zonghe_ablesky_category()
    {
        return $this->hasOne('App\Models\AbleskyCategory', 'id', 'zonghe_ablesky_category');
    }
    
    public function nengli_ablesky_category()
    {
        return $this->hasOne('App\Models\AbleskyCategory', 'id', 'nengli_ablesky_category');
    }
        
    
    public function isZhongxue(){
        return $this->level == "zhongxue";
    }
    
    public function isXiaoxue(){
        return $this->level == "xiaoxue";
    }
    
    public function isYouer(){
        return $this->level == "youer";
    }
    
    /**
     * 
     * 子科名称：文本框，子科名称根据级别变化
                        中学：教育知识与能力 
                        小学：教育教学知识与能力 
                        幼儿：保教知识与能力
     * @var unknown
     */
    const SUB = 1;
    
    /**
     * 综合素质：文本框
     */
    
    const ZONGHE = 2;
    
    /**
     * 学科知识与能力：文本框，只有级别选择“中学”，才会出现该项
     */
    const NENGLI = 4;
    
    /**
     * 默认的子科目
     * 中学有三个子科目
     * 小学、幼儿有两个子科目
     * @return boolean
     */
    public function defaultSubitem(){
        if($this -> isZhongxue() ){
            return [self::SUB , self::ZONGHE , self::NENGLI];
        }else{
            return [self::SUB , self::ZONGHE ];
        }
    }
    
    /**
     * 通过逻辑与运算求值，把包含的子科目用一个integer表示。
     * @param Array $subitems
     */
    public function encodeSubitems($subitems)
    {
        if( count($subitems) == 0){
            return 0;
        }
    
        $combine = $subitems[0];
        for($i=1; $i < count($subitems); $i++ ){
            $combine |= $subitems[$i];
        }
        return $combine;
    }
    
    /**
     * 是否包含 子科一
     * @param integer $combine
     * @return boolean
     */
    public function hasSub($combine)
    {
        return $combine & self::SUB;
    }
    
    /**
     * 是否包含 综合素质
     * @param integer $combine
     * @return boolean
     */
    public function hasZonghe($combine)
    {
        return $combine & self::ZONGHE;
    }
    
    /**
     * 是否包含 学科知识与能力
     * @param integer $combine
     * @return boolean
     */
    public function hasNengli($combine)
    {
        return $combine & self::NENGLI;
    }
    
    /**
     * 根据包含的子科目， 计算价格
     * @param integer $combine
     */
    public function computePrice($combine)
    {
        $total = 0;
        
        if($this -> hasSub($combine)){
            $total += $this-> discount_subprice;
        }
        if($this -> hasZonghe($combine)){
            $total += $this-> discount_zongheprice;
        }
        if($this -> hasNengli($combine)){
            $total += $this-> discount_nengliprice;
        }
        return $total;
    }
    
    /**
     * 
     * @return string 子科目的名称
     */
    public function getSubName()
    {
        if($this -> isZhongxue() ){
            return "教育知识与能力";
        }else if($this -> isXiaoxue() ){
            return " 教育教学知识与能力";
        }else {
            return "保教知识与能力";
        }
    }

    
    /**
     * 
     * @param integer $combine
     * @return Array 
     */
    public function listSubitemsName($combine)
    {
        $subitemsName = [];
        if($this -> hasSub($combine)){
            $subitemsName []= $this->getSubName();
        }
        if($this -> hasZonghe($combine)){
            $subitemsName []=  "综合素质";
        }
        if($this -> hasNengli($combine)){
            $subitemsName []= "学科知识与能力";
        }
        return $subitemsName;
    }
    
    /**
     *
     * @param integer $combine
     * @return Array 
     */
    public function getAbleskyCategoryIds($combine)
    {
        $category_ids = [];
        if($this -> hasSub($combine)){
            $category_ids []= $this->sub_ablesky_category;
        }
        if($this -> hasZonghe($combine)){
            $category_ids []=  $this->zonghe_ablesky_category;
        }
        if($this -> hasNengli($combine)){
            $category_ids []= $this->nengli_ablesky_category;
        }
        return $category_ids;
    }

}
