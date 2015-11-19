<?php  $html = App\Models\Html::where('key', App\Http\Controllers\Front\HomeController::HTML_KEY_free) -> first();?>

{!! $html->html !!}