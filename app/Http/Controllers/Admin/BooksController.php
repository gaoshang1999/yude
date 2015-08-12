<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function books()
    {
        $data = ['books' => Books::simplePaginate(20) ];
        return view('admin.books.list', $data);
    }

    public function booksadd(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|unique:courses|max:255',
                'price' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                'discount_price' => 'required|numeric|min:0',
                'inventory' => 'required|numeric|min:0',
                'buytimes' => 'required|numeric|min:0', 
                'author' => 'required',
                'cover' => 'required|image',
                'summary' => 'required',
                'pagetitle' => 'required',
                'pagekeyword' => 'required',
                'pagedescription' => 'required',
            ]);

            $input = $request->all();
            $books = Books::create($input);

            $file = array_get($input,'cover');

            $destinationPath = 'appfiles/books';
            $extension = $file->getClientOriginalExtension();
            $fileName = $books->id . '.' . $extension;
            $upload_success = $file->move($destinationPath, $fileName);
            if ($upload_success) {
                $books->cover = '/appfiles/books/' . $fileName;
                $books->save();
            }

            return redirect('/admin/books');
        }
        else {
            $data = ['books' => NULL];
            return view('admin.books.create_edit', $data);
        }
    }

    public function booksedit(Request $request, $id)
    {
        $books = Books::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|max:255|unique:books,name,'.$books->id,
                'price' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                //'discount_price' => 'required|numeric|min:0',
                'inventory' => 'required|numeric|min:0',
                'buytimes' => 'required|numeric|min:0', 
                'author' => 'required',
                'cover' => 'required|image',
                'summary' => 'required',
                'pagetitle' => 'required',
                'pagekeyword' => 'required',
                'pagedescription' => 'required',
            ]);

            $input = $request->all();
            unset($input['_token']);
            foreach ($input as $key => $value) {
                $books[$key] = $value;
            }
            $file = array_get($input,'cover');
            if ($file) {
                $destinationPath = 'appfiles/books';
                $extension = $file->getClientOriginalExtension();
                $fileName = $books->id . '.' . $extension;
                $upload_success = $file->move($destinationPath, $fileName);
                if ($upload_success) {
                    $books->cover = '/appfiles/books/' . $fileName;
                }
            }

            $books->save();

            return redirect('/admin/books');
        }
        else {
            $books['discount_price'] = $books['price'] * $books['discount'];
            return view('admin.books.create_edit', ['books' => $books]);
        }
    }
}