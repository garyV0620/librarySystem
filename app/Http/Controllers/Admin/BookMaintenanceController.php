<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->get();
         
        return view('admin.bookMaintenance.show', [
                'books' => $books,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
                        'title' => ['required', 'string', 'max:255'],
                        'author' => ['required', 'string', 'max:255'],
                        'quantity' => ['required', 'numeric', 'min:0'],
                    ]);

        $book = Book::create($validated);

        return redirect(route('books.index'))->with('message', ucfirst($book->title) . ' book has beed Added!' );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $books = Book::latest()->get();
         
        return view('admin.bookMaintenance.show', [
                'books' => $books,
                'editBook' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', 'min:0'],
        ]);

        $book->update($validated);

        return redirect(route('books.index'))->with('message', ucfirst($book->title) . ' book has beed Updated!' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if(!empty($book)){
            $book->delete();
            return redirect(route('books.index'))->with('message', ucfirst($book->title) . ' book has beed Deleted!' );
        }else{
            return redirect(route('books.index'))->with('error','Book not found!' );
        }
    }
}
