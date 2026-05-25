@extends('layouts.app')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-6 py-4">

        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Pengaduan Saya
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Semua laporan yang kamu kirim.
            </p>
        </div>

        <a href="{{ route('pengaduan.create') }}"
            class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">

            + Buat Pengaduan
        </a>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-gray-50 dark:bg-white/5">
                <tr class="text-left text-gray-500 dark:text-gray-400">
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Respon Admin</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @forelse($pengaduans as $pengaduan)

                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">

                    <!-- FOTO -->
                    <td class="px-4 py-3">
                        <img src="{{ Storage::url($pengaduan->photo) }}"
                            class="w-14 h-14 rounded-lg object-cover border">
                    </td>

                    <!-- JUDUL -->
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                        {{ $pengaduan->title }}
                    </td>

                    <!-- LOKASI -->
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                        {{ $pengaduan->location }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3">

                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold

                        {{ $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-300' : '' }}

                        {{ $pengaduan->status == 'diproses' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' : '' }}

                        {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300' : '' }}

                        {{ $pengaduan->status == 'ditolak' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300' : '' }}
                        ">

                            {{ ucfirst($pengaduan->status) }}

                        </span>

                    </td>

                    <!-- RESPON -->
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                        {{ $pengaduan->admin_response ?? 'Belum ada respon' }}
                    </td>

                    <!-- ACTION -->
                    <td class="px-4 py-3 text-center">

                        <div class="flex items-center justify-center gap-2">

                            <a href=""
                                class="px-3 py-1.5 rounded-lg bg-blue-500 text-white text-xs hover:bg-blue-600">

                                Edit
                            </a>

                            <form
                                id="delete-form-{{ $pengaduan->id }}"
                                action="{{ route('pengaduan.destroy', $pengaduan->id) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    onclick="confirmDelete"
                                    class="px-3 py-1.5 rounded-lg bg-red-500 text-white text-xs hover:bg-red-600">

                                    Hapus
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6"
                        class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">

                        Belum ada pengaduan.

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script>
function confirmDelete(id) {

    Swal.fire({
        title: 'Yakin mau hapus?',
        text: 'Data tidak bisa dikembalikan!',
        icon: 'warning',

        background: document.documentElement.classList.contains('dark')
            ? '#111827'
            : '#ffffff',

        color: document.documentElement.classList.contains('dark')
            ? '#f9fafb'
            : '#111827',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',

        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {

        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }

    });

}
</script>

@endsection