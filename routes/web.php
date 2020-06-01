<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//Get routes


Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home');


Route::get('/about', function () {
    return view('about');
});


Route::get('/contact', function () {
    return view('contact');
});


// Route::get('/adlogin', function () {
//     return view('adlogin');
// });


Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');


Route::get('/books', function () {
  $books = App\Books::latest()->take(12)->get();
  return view('allbooks', ['books' => $books]);
});


Route::get('/mybooks', 'HomeController@myBooks')->name('mybooks');


Route::get('/authors', 'HomeController@authors')->name('authors');


Route::get('/authors', 'HomeController@authors')->name('authors');


Route::get('/categories', 'HomeController@categories')->name('authors');

Route::get('/search','HomeController@search')->name('search');


// Route::get('/readers', function () {
//     $readers = App\Readers::latest()->orderBy('readcount', 'desc')->take(12)->get(); //top 12 readers
//     return view('readers', ['readers' => $readers]);
// });


// Route::get("/categories/{{categ}}", function () {
//     return view('categorybooks');
// });
//
//
//
// Route::get('/adhome', function () {
//   $authors= App\Authors::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 authors
//   $readers = App\Readers::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 readers
//   $categories= App\Categories::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 categories
//   $books = App\Books::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 books
//   return view('admindashboard', ['categories' => $categories, 'readers' => $readers, 'authors' => $authors, 'books' => $books]);
// });
//
// Route::get('/books/{{auth}}/{{name}}', function () {
//     return view('userbookopen');
// });
//
// Route::get('/books/adm/{{auth}}/{{name}}', function () {
//     return view('adminbookopen');
// });
//
// Route::get('/addbook', function () {
//     return view('addbook');
// });
//
//
//
//
//
// //Post routes



// Route::post('/adlogin', function () {
//   return redirect('/adhome');
// });
//
// Route::post('/profile', function () {
//     return redirect('/logout');
// });
//
// Route::post('/books', function () {
//   return view('allbooks');
// });
//
// Route::post('/mybooks', function () {
//     return view('mybooks');
// });
//
// Route::post('/authors', function () {
//     return view('authors');
// });
//
// Route::post('/readers', function () {
//     return view('readers');
// });
//
// Route::post('/categories', function () {
//     return view('categories');
// });
//
// Route::post('/books/{{auth}}/{{name}}', function () {
//     return view('userbookopen');
// });
//
// Route::post('/books/adm/{{auth}}/{{name}}', function () {
//     return view('adminbookopen');
// });
//
// Route::post('/addbook', function () {
//
//   $bookname = strtolower(request('bookname'));
//   $author_name = strtolower(request('author_name'));
//   $categories = strtolower(trim(request('categories')));
//
//   $author = DB::table('authors')->where('name', '=', $author_name )->first();
//   if ($author === null) {
//
//     //author does not exist - add author->add book->add or update category
//
//     $id = DB::table('authors')->insertGetId(
//     ['name' => $author_name, 'bookscount' => 1,
//      'categories' => request('categories')
//     ]
//     );
//
//     DB::table('books')->insert(
//     ['name' => $bookname, 'author_name' => $author_name,
//      'categories' => request('categories'), 'author_id' => $id
//     ]
//     );
//
//     $categories = explode(',' , request('categories'));
//     foreach ($categories as $categ) {
//
//       if ($categ!="") {
//
//         DB::table('categories')->updateOrInsert(
//         ['name' => trim($categ)],
//         ['authors' => DB::raw("CONCAT(authors,'" . $author_name . "')"),
//          'books' => DB::raw("CONCAT(books,'" . $bookname . "')"),
//          'bookscount' => DB::raw('bookscount + 1'),
//          'readcount' => DB::raw('readcount + 1')
//         ]
//         );
//
//       }
//     }
//
//
//   } else{
//
//     //author exists - add book
//     $book = DB::table('Books')->where('name', '=', $bookname )->first();
//     if ($book === null) {
//
//       DB::table('books')->insert(
//       ['name' => $bookname ,
//        'author_id' => $author->id,
//        'author_name' => $author_name,
//        'categories' => $categories
//       ]
//       );
//
//     } else{
//       return view('/addbook', ['message' => "Book with same name and author already exists"]);
//     }
//
//
//
//   }
//
//   return redirect('/books');
// });
