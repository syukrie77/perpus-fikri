<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index() {
        $query = Borrowing::with(['user', 'book'])->latest();

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $borrowings = $query->get();
        $books = Book::where('stock', '>', 0)->get(); 
        return view('borrowings.index', compact('borrowings', 'books'));
    }

    public function store(Request $request) {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        $book = Book::find($request->book_id);
        if($book->stock < 1) {
             return back()->with('error','Stok buku habis!');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status' => 'borrowed'
        ]);

        $book->decrement('stock');

        return redirect()->route('borrowings.index')->with('success','Peminjaman berhasil dicatat');
    }

    public function update(Request $request, Borrowing $borrowing) {
        $this->authorize('update', $borrowing);
        
        // Return book logic
        if($borrowing->status == 'borrowed') {
            $borrowing->update(['status' => 'returned']);
            $borrowing->book->increment('stock');
        }
        return back()->with('success','Buku berhasil dikembalikan');
    }
}
