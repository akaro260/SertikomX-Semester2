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

        <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Status
            </h3>

            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold

                {{ $pengaduans->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $pengaduans->status == 'diproses' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $pengaduans->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                {{ $pengaduans->status == 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
            ">

                {{ ucfirst($pengaduans->status) }}

            </span>
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

            <button type="submit"
                class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                Kirim Respon
            </button>
        </form>

    </div>




        @endsection