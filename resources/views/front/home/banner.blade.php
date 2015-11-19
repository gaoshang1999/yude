<?php  $html = App\Models\Html::where('key', App\Http\Controllers\Front\HomeController::HTML_KEY_banner) -> first();?>

{!! $html->html !!}