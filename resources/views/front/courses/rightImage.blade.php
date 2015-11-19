<?php  $html = App\Models\Html::where('key', App\Http\Controllers\Admin\CoursesController::HTML_KEY) -> first();?>

{!! $html->html !!}