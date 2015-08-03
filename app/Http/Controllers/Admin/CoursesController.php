<?php namespace App\Http\Controllers\Admin;

class CoursesController extends Controller
{
    public function list()
    {
        return view('admin.courses.list');
    }
}