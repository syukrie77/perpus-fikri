<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        $books = Book::with('category')->latest()->get();
        return view('books.index', compact('books'));
    }

    public function create() {
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            return redirect()->route('books.index')->with('error', 'Silakan tambahkan kategori buku terlebih dahulu melalui seeder atau database.');
        }

        return view('books.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'isbn' => 'required|string|unique:books,isbn',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            Book::create($request->all());
            return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    public function edit(Book $book) {
        $categories = Category::all();
        return view('books.edit', compact('book','categories'));
    }

    public function update(Request $request, Book $book) {
         $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'isbn' => 'required|string|unique:books,isbn,'.$book->id,
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($request->all());
        return redirect()->route('books.index')->with('success','Buku berhasil diperbarui');
    }

    public function destroy(Book $book) {
        $book->delete();
        return redirect()->route('books.index')->with('success','Buku berhasil dihapus');
    }
}
