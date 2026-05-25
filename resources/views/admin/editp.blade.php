@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-lg overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Edit Pengaduan
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Ubah data pengaduan dengan mudah.
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('pengaduan.update', $pengaduan->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 space-y-6">

            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Judul Pengaduan
                </label>

                <input type="text"
                       name="title"
                       value="{{ old('title', $pengaduan->title) }}"
                       placeholder="Masukkan judul..."
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Deskripsi
                </label>

                <textarea name="description"
                          rows="5"
                          placeholder="Masukkan deskripsi..."
                          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('description', $pengaduan->description) }}</textarea>
            </div>

            <!-- Location -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Lokasi
                </label>

                <input type="text"
                       name="location"
                       value="{{ old('location', $pengaduan->location) }}"
                       placeholder="Masukkan lokasi..."
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>

            <!-- Preview Image -->
            <div>
                <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Preview Foto
                </label>

                <div class="flex items-center justify-center">
                    <img id="preview"
                         src="{{ Storage::url($pengaduan->photo) }}"
                         class="w-52 h-52 object-cover rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700 shadow-md">
                </div>
            </div>

            <!-- Upload -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Upload Foto Baru
                </label>

                <input type="file"
                       name="photo"
                       accept="image/*"
                       onchange="previewImage(event)"
                       class="block w-full text-sm text-gray-700 dark:text-gray-300
                              file:mr-4 file:rounded-xl file:border-0
                              file:bg-blue-500 file:px-4 file:py-2
                              file:text-sm file:font-medium
                              file:text-white hover:file:bg-blue-600">
            </div>
            <!-- Status -->
<div>
    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
        Status Pengaduan
    </label>

        <select name="status"
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

            <option value="pending"
                {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>
                 Pending
            </option>

            <option value="diproses"
                {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>
                diproses
            </option>

            <option value="selesai"
                {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>
                Selesai
            </option>

            <option value="ditolak"
                {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>
                Ditolak
            </option>

        </select>
    </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">

                <a href="{{ url('/CRUD') }}"
                   class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">
                    Cancel
                </a>

                <button type="submit"
                        class="rounded-xl bg-blue-500 px-5 py-2.5 text-sm font-medium text-white shadow-lg transition hover:bg-blue-600">
                    💾 Update Pengaduan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');

    preview.src = URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection