use App\Http\Controllers\BookController;

Route::get('/books', [BookController::class,'index']);
Route::get('/books/create', [BookController::class,'create']);
Route::post('/books', [BookController::class,'store']);
