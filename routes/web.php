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



Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);


Route::get('/auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('/auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');


Route::get('/home', 'HomeController@index')->name('home');


Route::get('/about', function () {
    return view('about');
});


Route::get('/contact', function () {
    return view('contact');
});


// Route::prefix('/admin')->name('admin')->namespace('Admin')->group(function(){
//   //All the admin routes will be defined here...
// });


// Route::get('/adlogin', 'Auth\LoginController@showAdminLoginForm');

// Route::post('/adlogin', function () {
//   return redirect('/admin');
// });

// Route::post('/adlogin', 'Auth\LoginController@adminLogin');

// Route::view('/adm', 'admindashboard');
// Route::get('/admin', 'HomeController@indexAdmin')->name('admin');

// Route::get('/adm', function () {
//   $num_books = DB::table('books')->count(); //no. of books
//   $num_authors = DB::table('authors')->count(); //no. of authors
//   $num_readers = DB::table('users')->count(); //no. of readers
//   $authors= App\Author::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 authors
//   $readers = App\User::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 readers
//   $categories= App\Category::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 categories
//   $books = App\Book::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books
//   return view('admindashboard', ['categories' => $categories, 'authors' => $authors, 'readers' => $readers,
//    'books' => $books, 'num_authors' => $num_authors, 'num_books' => $num_books, 'num_readers' => $num_readers]);
// });

// Route::get('/books', function () {
//   $books = App\Book::latest()->take(12)->get();
//   return view('adminallbooks', ['books' => $books]);
// });


Route::get('/adm/books/{auth}/{name}', function ($auth, $name) {
    $author = App\Author::where('name', urldecode($auth))->get();
    $book = App\Book::where('name', urldecode($name))->where('author_id', $author[0]['id'])->get();

    // return view("test", ['message' => $book[0]]);
    return view('adminbookopen', ['book' => $book[0], 'message' => ""]);
});

Route::post('/adm/books', function () {   // for admin to make changes
    return redirect('books')->with('status', 'Book updated!');
});

Route::post('/deletebook', 'BookController@deleteBook')->name('delete_book');


Route::get('/readers', function () {
    $readers = App\User::latest()->orderBy('readcount', 'desc')->take(12)->get(); //top 12 readers
    return view('readers', ['readers' => $readers]);
});


Route::get('/addbook', 'BookController@index')->name('add_book');
Route::post('/addbook/save', 'BookController@addBook')->name('add_book.save');


Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');


Route::get('/books', function () {
    $books = App\Book::latest()->take(12)->get();
    $allCategories = App\Category::select('name')->get();
    return view('allbooks', ['books' => $books, 'allCategories' => $allCategories]);
});


Route::get('/books/{auth}/{name}', function ($auth, $name) {
    $author = App\Author::where('name', urldecode($auth))->get();
    $book = App\Book::where('name', urldecode($name))->where('author_id', $author[0]['id'])->get();

    // return view("test", ['message' => $book[0]]);
    return view('userbookopen', ['book' => $book[0], 'message' => ""]);
});



Route::get('/mybooks', 'HomeController@myBooks')->name('my_books');


Route::get('/authors', 'HomeController@authors')->name('authors');


// Route::get('/categories', 'HomeController@categories')->name('categories');


//AJAX request routes

Route::get('/markread', 'HomeController@markread')->name('mark_read');

Route::get('/searchreaders', 'HomeController@searchreaders')->name('search_readers');

Route::get('/searchbooks', 'HomeController@searchbooks')->name('search_books');

Route::get('/searchmybooks', 'HomeController@searchmybooks')->name('search_my_books');

Route::get('/searchauthors', 'HomeController@searchauthors')->name('search_authors');

// Route::get('/searchcategories','HomeController@searchcategories')->name('searchcategories');
