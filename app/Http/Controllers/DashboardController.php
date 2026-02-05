<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $is_admin = auth()->user()->is_admin;

        $totalBooks = Book::count();
        $totalUsers = User::count();
        
        $borrowQuery = Borrowing::query();
        $recentQuery = Borrowing::with(['user', 'book'])->latest();

        if (!$is_admin) {
            $borrowQuery->where('user_id', auth()->id());
            $recentQuery->where('user_id', auth()->id());
        }

        $activeBorrowings = (clone $borrowQuery)->where('status', 'borrowed')->count();
        $totalReturned = (clone $borrowQuery)->where('status', 'returned')->count();

        // Get recent activities (last 5 borrowings)
        $recentBorrowings = $recentQuery->take(5)->get();

        return view('dashboard', compact(
            'totalBooks', 
            'totalUsers', 
            'activeBorrowings', 
            'totalReturned', 
            'recentBorrowings'
        ));
    }
}
