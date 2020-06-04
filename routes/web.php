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


Route::get('/adlogin', 'Auth\LoginController@showAdminLoginForm');

// Route::post('/adlogin', function () {
//   return redirect('/admin');
// });

Route::post('/adlogin', 'Auth\LoginController@adminLogin');

// Route::view('/adm', 'admindashboard');
// Route::get('/admin', 'HomeController@indexadmin')->name('admin');

Route::get('/adm', function () {
  $num_books = DB::table('books')->count(); //no. of books
  $num_authors = DB::table('authors')->count(); //no. of authors
  $num_readers = DB::table('users')->count(); //no. of readers
  $authors= App\Authors::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 authors
  $readers = App\User::latest()->orderBy('readcount', 'desc')->take(5)->get(); //top 5 readers
  $categories= App\Categories::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(5)->get(); //top 5 categories
  $books = App\Books::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books
  return view('admindashboard', ['categories' => $categories, 'authors' => $authors, 'readers' => $readers,
   'books' => $books, 'num_authors' => $num_authors, 'num_books' => $num_books, 'num_readers' => $num_readers]);
});

Route::get('/books', function () {
  $books = App\Books::latest()->take(12)->get();
  return view('adminallbooks', ['books' => $books]);
});


Route::get('/adm/books/{{auth}}/{{name}}', function () {
    return view('adminbookopen');
});

Route::post('/adm/books/{{auth}}/{{name}}', function () {   // for admin to make changes
    return view('adminbookopen');
});


Route::get('/readers', function () {
    $readers = App\User::latest()->orderBy('readcount', 'desc')->take(12)->get(); //top 12 readers
    return view('readers', ['readers' => $readers]);
});


Route::get('/addbook', 'BookController@index')->name('addbook');
Route::post('/addbook/save', 'BookController@addBook')->name('addbook.save');


Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');


Route::get('/books', function () {
  $books = App\Books::latest()->take(12)->get();
  $allcategories = App\Categories::select('name')->get();
  return view('allbooks', ['books' => $books, 'allcategories' => $allcategories]);
});


Route::get('/books/{auth}/{name}', function ($auth, $name) {
    $book = App\Books::where('name', urldecode($name))->where('author_name', urldecode($auth))->get();

    // return view("test", ['message' => $book[0]]);
    return view('userbookopen', ['book' => $book[0], 'message' => ""]);
});



Route::get('/mybooks', 'HomeController@myBooks')->name('mybooks');


Route::get('/authors', 'HomeController@authors')->name('authors');


// Route::get('/categories', 'HomeController@categories')->name('categories');


//AJAX request routes

Route::get('/markread','HomeController@markread')->name('markread');

Route::get('/searchreaders','HomeController@searchreaders')->name('searchreaders');

Route::get('/searchbooks','HomeController@searchbooks')->name('searchbooks');

Route::get('/searchmybooks','HomeController@searchmybooks')->name('searchmybooks');

Route::get('/searchauthors','HomeController@searchauthors')->name('searchauthors');

// Route::get('/searchcategories','HomeController@searchcategories')->name('searchcategories');
