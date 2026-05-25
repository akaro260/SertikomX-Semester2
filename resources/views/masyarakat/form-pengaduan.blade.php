@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">

    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6">

        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">
            Form Pengaduan
        </h1>

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    Upload Foto
                </label>

                <!-- Input Asli Disembunyiin -->
                <input
                    type="file"
                    name="photo"
                    id="photo"
                    accept="image/*"
                    onchange="previewImage(event)"
                    class="hidden">

                <!-- Button Custom -->
                <label for="photo"
                    class="cursor-pointer inline-block bg-green-600 hover:bg-green-700
        text-white px-5 py-3 rounded-xl transition font-semibold">
                    Upload Gambar
                </label>

                <!-- Nama File -->
                <p id="fileName"
                    class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Belum ada file
                </p>

                <!-- Preview -->
                <div class="mt-4">
                    <img
                        id="preview"
                        class="hidden  object-cover rounded-2xl
            border-2 border-gray-300 dark:border-gray-600 shadow-lg">
                </div>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    Judul Pengaduan
                </label>

                <input type="text" name="title"
                    class="w-full rounded-xl border border-gray-300 dark:border-gray-600
                    bg-white dark:bg-gray-700
                    text-black dark:text-white
                    p-3 focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    Deskripsi
                </label>

                <textarea name="description" rows="5"
                    class="w-full rounded-xl border border-gray-300 dark:border-gray-600
                    bg-white dark:bg-gray-700
                    text-black dark:text-white
                    p-3 focus:ring-2 focus:ring-green-500 outline-none"></textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    Lokasi
                </label>

                <input type="text" name="location"
                    class="w-full rounded-xl border border-gray-300 dark:border-gray-600
                    bg-white dark:bg-gray-700
                    text-black dark:text-white
                    p-3 focus:ring-2 focus:ring-green-500 outline-none">
            </div>



            <button type="submit"
                class="bg-green-600 hover:bg-green-700 transition text-white px-5 py-3 rounded-xl font-semibold">
                Kirim Pengaduan
            </button>
        </form>

    </div>
</div>
<script>
function previewImage(event) {
    const image = document.getElementById('preview');
    const fileName = document.getElementById('fileName');

    image.src = URL.createObjectURL(event.target.files[0]);

    fileName.textContent = event.target.files[0].name;

    image.classList.remove('hidden');
}
</script>
@endsection