<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Authors;
use App\Books;
use App\categories;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $num_books = DB::table('books')->count(); //no. of books
        $num_authors = DB::table('authors')->count(); //no. of authors
        $num_readers = DB::table('users')->count(); //no. of readers
        $mybooks = Auth::user()->readbooks;
        $authors= Authors::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 authors
        $categories= Categories::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 categories
        $books = Books::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books
        return view('userdashboard', ['categories' => $categories, 'authors' => $authors, 'mybooks' => $mybooks,
         'books' => $books, 'num_authors' => $num_authors, 'num_books' => $num_books, 'num_readers' => $num_readers]);

    }


    public function myBooks() {

        $mybooks_names = explode(', ' , Auth::user()->readbooks);
        $mybooks = Books::whereIn('name', $mybooks_names)->get();

        return view('mybooks', ['mybooks' => $mybooks]);

    }

    public function authors() {

      $authors= Authors::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 authors
      return view('authors', ['authors' => $authors]);

    }

    public function categories() {

      $categories= Categories::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 categories
      return view('categories', ['categories' => $categories]);

    }

    public function profile() {

      $categories= Categories::orderBy(DB::raw("`bookscount` + `readcount`"), 'desc')->take(12)->get(); //top 12 categories
      return view('categories', ['categories' => $categories]);

    }



}
