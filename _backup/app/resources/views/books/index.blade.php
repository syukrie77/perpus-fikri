@extends('layouts.app')

@section('content')
<h3>Daftar Buku</h3>

<a href="/books/create" class="btn btn-primary mb-3">Tambah Buku</a>

<table class="table table-bordered table-striped">
  <tr>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Kategori</th>
    <th>Stok</th>
  </tr>
  @foreach($books as $b)
  <tr>
    <td>{{ $b->title }}</td>
    <td>{{ $b->author }}</td>
    <td>{{ $b->category->name }}</td>
    <td>{{ $b->stock }}</td>
  </tr>
  @endforeach
</table>
@endsection
