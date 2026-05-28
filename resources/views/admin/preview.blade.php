@extends('layouts.app')

@section('content')

<div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

    <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-white">
        Preview Pengaduan
    </h2>

    <!-- FOTO -->
    <div class="mb-6">
        <img src="{{ Storage::url($pengaduans->photo) }}"
            class="w-full max-w-md rounded-xl border border-gray-200 object-cover dark:border-gray-700">
    </div>

    <!-- DETAIL -->
    <div class="space-y-4">

        <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Judul
            </h3>

            <p class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ $pengaduans->title }}
            </p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Lokasi
            </h3>

            <p class="text-gray-700 dark:text-gray-300">
                {{ $pengaduans->location }}
            </p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Deskripsi
            </h3>

            <p class="text-gray-700 dark:text-gray-300">
                {{ $pengaduans->description }}
            </p>
        </div>



        <!-- FORM RESPON ADMIN -->
        <form action="{{ route('pengaduan.respond', $pengaduans->id) }}" method="POST" class="mt-6">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Respon Admin
                </label>
                <textarea
                    name="admin_response"
                    rows="4"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    placeholder="Tulis respon admin...">{{ old('admin_response', $pengaduans->admin_response) }}</textarea>
            </div>
                <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
            Status Pengaduan
        </label>

            <select name="status"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

                <option value="pending"
                    {{ $pengaduans->status == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="diproses"
                    {{ $pengaduans->status == 'diproses' ? 'selected' : '' }}>
                    diproses
                </option>

                <option value="selesai"
                    {{ $pengaduans->status == 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>

                <option value="ditolak"
                    {{ $pengaduans->status == 'ditolak' ? 'selected' : '' }}>
                    Ditolak
                </option>

            </select>
        </div>
            <button type="submit"
                class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                Kirim Respon
            </button>
        </form>

    </div>




@endsection