<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->is_admin ? __('Admin Dashboard') : __('Dashboard Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @if(Auth::user()->is_admin)
                <!-- Total Books -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-xs font-semibold text-gray-500 uppercase">Total Buku</div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="text-3xl font-bold">{{ $totalBooks }}</div>
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-xs font-semibold text-gray-500 uppercase">Total Member</div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Active Borrowings -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-xs font-semibold text-gray-500 uppercase">Sedang Dipinjam</div>
                        <div class="flex items-center justify-between mt-2">
                             <div class="text-3xl font-bold">{{ $activeBorrowings }}</div>
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Returned -->
                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                         <div class="text-xs font-semibold text-gray-500 uppercase">Total Kembali</div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="text-3xl font-bold">{{ $totalReturned }}</div>
                             <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Management Shortcuts -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                    <div class="flex flex-col gap-3">
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('books.create') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:text-lg">
                                + Tambah Buku Baru
                            </a>
                        @endif
                        <a href="{{ route('borrowings.index') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:text-lg">
                            Kelola Peminjaman
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Aktivitas Terkini</h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentBorrowings as $borrow)
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ Auth::user()->is_admin ? ($borrow->user->name ?? 'User') : 'Anda' }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Meminjam: {{ $borrow->book->title }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-xs font-semibold text-gray-900 dark:text-white">
                                    {{ $borrow->borrow_date }}
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-sm text-gray-500 dark:text-gray-400">Belum ada aktivitas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
