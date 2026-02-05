<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Peminjaman Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Peminjaman -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                 <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Catat Peminjaman Baru</h3>
                <form method="POST" action="{{ route('borrowings.store') }}" class="flex gap-4 items-end">
                    @csrf
                     <div class="flex-1">
                        <label for="book_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Buku</label>
                        <select id="book_id" name="book_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                             @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} (Stok: {{ $book->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="borrow_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tgl Pinjam</label>
                        <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                     <div>
                        <label for="return_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tgl Kembali</label>
                        <input type="date" name="return_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pinjam</button>
                </form>
            </div>

            <!-- Tabel Riwayat -->
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ Auth::user()->is_admin ? 'Riwayat Peminjaman (Global)' : 'Riwayat Peminjaman Saya' }}</h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Peminjam</th>
                                <th scope="col" class="px-6 py-3">Buku</th>
                                <th scope="col" class="px-6 py-3">Tgl Pinjam</th>
                                <th scope="col" class="px-6 py-3">Tgl Kembali</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $borrow)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ Auth::user()->is_admin ? ($borrow->user->name ?? 'User') : 'Saya' }}
                                </th>
                                <td class="px-6 py-4">{{ $borrow->book->title }}</td>
                                <td class="px-6 py-4">{{ $borrow->borrow_date }}</td>
                                <td class="px-6 py-4">{{ $borrow->return_date }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-{{ $borrow->status == 'borrowed' ? 'yellow' : 'blue' }}-100 text-{{ $borrow->status == 'borrowed' ? 'yellow' : 'blue' }}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-{{ $borrow->status == 'borrowed' ? 'yellow' : 'blue' }}-400 border border-{{ $borrow->status == 'borrowed' ? 'yellow' : 'blue' }}-400">
                                        {{ ucfirst($borrow->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($borrow->status == 'borrowed')
                                    <form action="{{ route('borrowings.update', $borrow->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Kembalikan</button>
                                    </form>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
