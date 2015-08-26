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
    
    public function search(Request $request)
    {
        $input = $request['q'];
        $books = Books::where('name', 'like', '%'.$input.'%')->simplePaginate(20) ;
        $books ->appends(['q' => $input]);
    
        $data = ['books' => $books, 'q' => $input];
        return view('admin.books.list', $data);
    }

    public function booksadd(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|unique:books|max:255',
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
            if (!is_dir(base_path('public/' . $destinationPath))) {
                mkdir(base_path('public/' . $destinationPath));
            }
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
                //'cover' => 'required|image',
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
                if (!is_dir(base_path('public/' . $destinationPath))) {
                    mkdir(base_path('public/' . $destinationPath));
                }
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
            $books['discount_price'] = $books['price'] * $books['discount']/100.0;
            return view('admin.books.create_edit', ['books' => $books]);
        }
    }
    
    public function lists(Request $request)
    {       
        $books_1 = Books::where('level', 'zhongxue') ->get();    
        $books_2 = Books::where('level', 'xiaoxue') ->get() ;        
        $books_3 = Books::where('level', 'youer') ->get();        
        $data = ['books_1' => $books_1, 'books_2' => $books_2, 'books_3' => $books_3];
        return view('front.books_lists', $data);
    }
    
    public function detail(Request $request, $id)
    {
        $books = Books::where('id', $id)->first();
        return view('front.books_detail', ['v' => $books]);
    }
}