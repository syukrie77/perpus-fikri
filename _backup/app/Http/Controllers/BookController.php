namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        $books = Book::with('category')->get();
        return view('books.index', compact('books'));
    }

    public function create() {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request) {
        Book::create($request->all());
        return redirect('/books')->with('success','Buku berhasil ditambahkan');
    }
}
