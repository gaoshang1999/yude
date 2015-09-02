<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ablesky课程目录选择</title>
	<style>
	html { margin:0; padding:0; font-size:62.5%; }
	body { max-width:800px; min-width:300px; margin:0 auto; padding:20px 10px; font-size:14px; font-size:1.4em; }
	h1 { font-size:1.8em; }
	.demo { overflow:auto; border:1px solid silver; min-height:100px; }
	</style>
	<link rel="stylesheet" href="/jstree/themes/default/style.min.css" />
	    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@if($selected)
    <a class="btn btn-primary pull-right" href="javascript:window.close();" style="margin-right: 5px;">确定</a>
@endif
	<h2>Ablesky课程目录</h2>  
		<hr/>
	<div id="event_result" class="" style="color:red;">
        当前选中:
	</div>

	<div id="html" class="demo">
        {!! $jstree_html !!}
	</div>

    <input type="hidden" id="name" value="">
    <input type="hidden" id="id" value="">

	<script src="/assets/js/jquery-2.1.4.min.js"></script>
	<script src="/jstree/jstree.min.js"></script>
	
	<script>
	function mydump(arr,level) {
	    var dumped_text = "";
	    if(!level) level = 0;

	    var level_padding = "";
	    for(var j=0;j<level+1;j++) level_padding += "    ";

	    if(typeof(arr) == 'object') {  
	        for(var item in arr) {
	            var value = arr[item];

	            if(typeof(value) == 'object') { 
	                dumped_text += level_padding + "'" + item + "' ...\n";
	                dumped_text += mydump(value,level+1);
	            } else {
	                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
	            }
	        }
	    } else { 
	        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	    }
	    return dumped_text;
	}
	// html demo
	$('#html').jstree();


	$('#html')
	  // listen for event
	  .on('changed.jstree', function (e, datas) {
	    var i, j, r = [];
	    for(i = 0, j = datas.selected.length; i < j; i++) {
	      r.push(datas.instance.get_node(datas.selected[i]).text);
// 	      alert(mydump(datas.instance.get_node(datas.selected[i]) ));
// 	      alert((datas.instance.get_node(datas.selected[i])).data.id );
@if($selected)
          window.opener.document.getElementById("ablesky_category_name").value = datas.instance.get_node(datas.selected[i]).text; 
          window.opener.document.getElementById("ablesky_category").value = datas.instance.get_node(datas.selected[i]).data.id; 
@endif
	    }
	    $('#event_result').html('当前选中: ' + r.join(', '));
	    
	  })
	  // create the instance
	  .jstree();			
	
	</script>
</body>
</html>