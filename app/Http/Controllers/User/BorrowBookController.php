<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowBookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
         
        return view('user.borrow-book', [
                'books' => $books,
        ]);
    }

    public function borrowBook(Book $book)
    {  
        if($book->quantity > 0){
            $book->update([
                'quantity' => $book->quantity - 1
            ]);

            $book->users()->attach([Auth::id()]);

        }else{
            return redirect()->route('book-list')->with('error', ucfirst($book->title) . " Book is NOT Available");
        }
        
        return redirect()->route('borrow-list')->with('message', ucfirst($book->title) . " Book has been Borrowed!");
    }

    public function returnBook(Book $book)
    {  
        $book->update([
            'quantity' => $book->quantity + 1
        ]);
        $book = Book::find($book->id);
        $book->users()->detach();

        return redirect()->route('borrow-list')->with('message', ucfirst($book->title) . " Book has been Returned!");
    }

    public function borrowList()
    {
        $user = User::with('books')->find(Auth::id());
 
        return view('user.return-book', [
                'books' => $user->books,
        ]);
    }

    
}
