@extends('layouts.app')

@section('content')
<h3>Tambah Buku</h3>

<form method="POST" action="/books">
@csrf

<input class="form-control mb-2" name="title" placeholder="Judul Buku">
<input class="form-control mb-2" name="author" placeholder="Penulis">
<select class="form-control mb-2" name="category_id">
  @foreach($categories as $c)
    <option value="{{ $c->id }}">{{ $c->name }}</option>
  @endforeach
</select>
<input class="form-control mb-2" name="stock" type="number" placeholder="Stok">
<button class="btn btn-success">Simpan</button>
</form>
@endsection
