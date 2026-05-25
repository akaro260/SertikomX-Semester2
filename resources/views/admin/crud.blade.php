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
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @foreach($pengaduans as $pengaduan)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">

                    <!-- USER -->
                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">
                        {{ $pengaduan->user->name ?? 'User tidak ada' }}
                    </td>

                    <!-- PHOTO -->
                    <td class="px-4 py-3">
                        <img src="{{ Storage::url($pengaduan->photo) }}"
                            class="w-14 h-14 rounded-lg object-cover border">
                    </td>

                    <!-- TITLE -->
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                        {{ $pengaduan->title }}
                    </td>

                    <!-- DESCRIPTION -->
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 max-w-xs truncate">
                        {{ $pengaduan->description }}
                    </td>

                    <!-- LOCATION -->
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                        {{ $pengaduan->location }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3">
                        <span class="
                            inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full

                            {{ $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-300' : '' }}

                            {{ $pengaduan->status == 'diproses' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' : '' }}

                            {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300' : '' }}

                            {{ $pengaduan->status == 'ditolak' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300' : '' }}
                        ">

                            @if($pengaduan->status == 'pending')
                            ⏳ Pending
                            @elseif($pengaduan->status == 'diproses')
                            🔄 Diproses
                            @elseif($pengaduan->status == 'selesai')
                            ✅ Selesai
                            @elseif($pengaduan->status == 'ditolak')
                            ❌ Ditolak
                            @endif

                        </span>
                    </td>
                    <!-- ACTION -->
                    <td class="px-4 py-3 text-center">
                        <x-common.table-dropdown>
                            <x-slot name="button">
                                <button type="button"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500 dark:text-gray-400">
                                    ⋮
                                </button>
                            </x-slot>

                            <x-slot name="content">

                                <!-- Edit Button -->
                                <button type="button"
                                    onclick="window.location.href='{{ route('pengaduan.editp', $pengaduan->id) }}'"
                                    class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-white/5 transition font-medium text-gray-800 dark:text-white">
                                    ✏️ Edit
                                </button>
                                <button type="button"
                                    onclick="window.location.href='{{ route('pengaduan.preview', $pengaduan->id) }}'"
                                    class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-white/5 transition font-medium text-gray-800 dark:text-white">

                                    👁 Preview
                                </button>
                                <!-- Delete Form -->
                                <form id="delete-form-{{ $pengaduan->id }}"
                                    action="{{ route('pengaduan.destroy', $pengaduan->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        onclick="confirmDelete({{ $pengaduan->id }})"
                                        class="w-full text-left px-3 py-2 text-sm text-red-500 rounded-md hover:bg-gray-100 dark:hover:bg-white/5 transition font-medium">

                                        🗑 Delete
                                    </button>
                                </form>

                            </x-slot>
                            <!-- Preview Button -->

                        </x-common.table-dropdown>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        const isDark = document.documentElement.classList.contains('dark');

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',

            background: isDark ? '#111827' : '#ffffff',
            color: isDark ? '#f9fafb' : '#111827',

            showCancelButton: true,

            confirmButtonColor: '#dc2626',
            cancelButtonColor: isDark ? '#374151' : '#9ca3af',

            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',

            customClass: {
                popup: 'rounded-2xl shadow-xl',
                confirmButton: 'rounded-lg',
                cancelButton: 'rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection