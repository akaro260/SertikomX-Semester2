@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <!-- HEADER -->
    <div class="flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Data Pengaduan
        </h3>

        <div class="relative">
            <input
                type="text"
                placeholder="Cari pengaduan..."
                class="h-10 w-full sm:w-72 rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-200 dark:border-gray-700 dark:text-white/90" />
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.41-1.41l4.38 4.38a1 1 0 01-1.41 1.41l-4.38-4.38zM8 14a6 6 0 100-12 6 6 0 000 12z" />
            </svg>
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="bg-gray-50 dark:bg-white/5">
                <tr class="text-left text-gray-500 dark:text-gray-400">
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Photo</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 ">Respon Admin</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @foreach($pengaduans as $pengaduan)
                @if($pengaduan->status == 'selesai' || $pengaduan->status == 'ditolak')

                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">
                        {{ $pengaduan->user->name ?? 'User tidak ada' }}
                    </td>
                    <td class="px-4 py-3">
                        <img src="{{ Storage::url($pengaduan->photo) }}"
                            class="w-14 h-14 rounded-lg object-cover border">
                    </td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                        {{ $pengaduan->title }}
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 max-w-xs truncate">
                        {{ $pengaduan->description }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                        {{ $pengaduan->location }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
            {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            @if($pengaduan->status == 'selesai') ✅ Selesai
                            @else ❌ Ditolak
                            @endif
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                        {{ $pengaduan->admin_response ?? 'Belum ada respon' }}
                    </td>
                </tr> {{-- ← ini yang hilang --}}

                @endif
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection