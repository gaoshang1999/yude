<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbleskyCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ablesky_category';

    protected $fillable = ['id', 'categoryName'  , 'parentId', 'categoryLevel', 'rank' ];
    
    private $tree_str = '';
    
    /**
     * 递归查询数据库，构造树形 html 串，html 结构参考 https://www.jstree.com/， 本方法用于产生div 内部的html 片段。
     * 	<div id="html" class="demo">
		<ul>
			<li data-jstree='{ "opened" : true }'>Root node
				<ul>
					<li data-jstree='{ "selected" : true }'>Child node 1</li>
					<li>Child node 2</li>
				</ul>
			</li>
		</ul>
	  </div>
     * 前台使用了 jstree 组件按树形展示
     * @param unknown $list
     */
    private function build_tree($parent){        
        $root = AbleskyCategory :: where('parentId', $parent)->get();
        
        foreach ($root as $index => $item){
            if($index == 0) {$this->tree_str .= '<ul>';}
            $this->tree_str .= '<li data-jstree=\'{ "opened" : true }\' data-id=\''.$item->id.'\' >'.$item->categoryName;
            $list = $this->build_tree($item->id);
            $item['children'] = $list;
            if($index == count($root)-1){$this->tree_str .= '</ul>'; }
        }
        if($parent != 0) {
            $this->tree_str .= '</li>';
        }
        return $root;
    }
    
    private function get_tree()
    {
        return $this->build_tree(0);
    }
    
    public function jstree_html()
    {
        $this->get_tree();
        return $this->tree_str;
    }
}
