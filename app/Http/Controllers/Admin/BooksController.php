<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function books()
    {
        $data = ['books' => Books::orderBy('created_at', 'desc')->simplePaginate(20) ];
        return view('admin.books.list', $data);
    }
    
    public function search(Request $request)
    {
        $q = $request['q'];
        $field = $request['field'];
        
        if($field == 'level'){
            if($q == '中学') { $q = 'zhongxue';}
            else if($q == '小学') { $q = 'exiaoxue';}
            else if($q == '幼儿') { $q = 'youer';}
        }else if($field == 'kind'){
            if($q == '笔试') { $q = 'bishi';}
            else if($q == '面试') { $q = 'mianshi';}
        }
        
        $books = Books::where($field, 'like', '%'.$q.'%')->simplePaginate(20) ;
        $books ->appends(['q' => $request['q']]);
    
        $data = ['books' => $books, 'q' => $request['q'], 'field' => $field];
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
                'press' => 'required',
                'publish_date' => 'required',
                'description' => 'required',
                'cover2' => 'required|image',
                'cover3' => 'required|image',
                'cover4' => 'required|image',
                'image' => 'required|image',
            ]);

            $input = $request->all();
            $books = Books::create($input);

            $imgs = ['cover', 'cover2', 'cover3', 'cover4', 'image'];
            foreach ($imgs as $c) {
                $file = array_get($input, $c);
                if ($file) {
                    $destinationPath = 'appfiles/books';
                    if (!is_dir(base_path('public/' . $destinationPath))) {
                        mkdir(base_path('public/' . $destinationPath));
                    }
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $books->id.'-'.$c  . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName);
                    if ($upload_success) {
                        $books[$c] = '/appfiles/books/' . $fileName;
                    }
                }
            }
            $books->save();    
       
            return redirect('/admin/books');
        }
        else {
            $data = ['books' => NULL];
            return view('admin.books.create_edit', $data);
        }
    }

    public function booksedit(Request $request, $id)
    {
//         dump($request->header("referer"));
        $books = Books::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|max:255|unique:courses,name,'.$books->id,
                'price' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                'discount_price' => 'required|numeric|min:0',
                'inventory' => 'required|numeric|min:0',
                'buytimes' => 'required|numeric|min:0', 
                'author' => 'required',
//                 'cover' => 'required|image',
                'summary' => 'required',
                'press' => 'required',
                'publish_date' => 'required',
                'description' => 'required',
//                 'cover2' => 'required|image',
//                 'cover3' => 'required|image',
//                 'cover4' => 'required|image',
//                 'image' => 'required|image',
            ]);

            $input = $request->all();
            $books->fill($input);

            $imgs = ['cover', 'cover2', 'cover3', 'cover4', 'image'];
            foreach ($imgs as $c) {
                $file = array_get($input, $c);
                if ($file) {
                    $destinationPath = 'appfiles/books';
                    if (!is_dir(base_path('public/' . $destinationPath))) {
                        mkdir(base_path('public/' . $destinationPath));
                    }
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $books->id.'-'.$c  . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName);
                    if ($upload_success) {
                        $books[$c] = '/appfiles/books/' . $fileName;
                    }
                }
            }
            $books->save();
            
            $referer = $input['referer'];
            return redirect(empty($referer)?'/admin/books':$referer);
        }
        else {
            $books['discount_price'] = $books['price'] * $books['discount']/100.0;
            return view('admin.books.create_edit', ['books' => $books]);
        }
    }
    
    public function delete(Request $request, $id)
    {
        Books::where('id', $id)->delete();
        return redirect('/admin/books');
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