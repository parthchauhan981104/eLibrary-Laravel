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

        $mybooks = Auth::user()->readbooks;
        $authors= Authors::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 authors
        $categories= Categories::orderBy(DB::raw("'bookscount' + 'readcount'"), 'desc')->take(5)->get(); //top 5 categories
        $books = Books::latest()->orderBy('readerscount', 'desc')->take(5)->get(); //top 5 books
        return view('userdashboard', ['categories' => $categories, 'authors' => $authors, 'mybooks' => $mybooks, 'books' => $books]);

    }
}
