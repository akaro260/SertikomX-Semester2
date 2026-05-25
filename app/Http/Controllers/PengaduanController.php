<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pengaduan;

use Illuminate\Support\Facades\Storage;
class PengaduanController extends Controller
{
    //
public function index()
{
    $pengaduans = Pengaduan::with('user')->get();

    return view('admin.crud', compact('pengaduans'));
}

   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload Foto
    $photoPath = $request->file('photo')->store('pengaduan', 'public');

    // Simpan Data
    Pengaduan::create([
        'user_id' => Auth::id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'location' => $validated['location'],
        'photo' => $photoPath,
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
}
public function edit(Pengaduan $pengaduan)
{
    return view('admin.editp', compact('pengaduan'));
}


public function update(Request $request, Pengaduan $pengaduan)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'status' => 'required|in:pending,diproses,selesai,ditolak',
        'location' => 'required',
        'admin_response' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'status' => $request->status,
        'admin_response' => $request->admin_response,
    ];

    // kalau upload foto baru
    if ($request->hasFile('photo')) {

        // hapus foto lama
        if ($pengaduan->photo) {
            Storage::disk('public')->delete($pengaduan->photo);
        }

        // upload baru
        $data['photo'] = $request->file('photo')->store('pengaduan', 'public');
    }

    $pengaduan->update($data);

    return redirect()->route('pengaduan.index')
        ->with('success', 'Pengaduan berhasil diupdate');
}
public function destroy(Pengaduan $pengaduan)
{
    // Hapus foto jika ada
    if ($pengaduan->photo) {
        Storage::disk('public')->delete($pengaduan->photo);
    }

    $pengaduan->delete();

    return redirect()->route('pengaduan.index')
        ->with('success', 'Pengaduan berhasil dihapus');
}

// masyarakat
public function pengaduanSaya()
{
    $pengaduans = Pengaduan::where('user_id', auth()->id())->latest()->get();

    return view('masyarakat.pengaduan-saya', compact('pengaduans'));
}
public function indexMasyarakat()
{
    $pengaduans = Pengaduan::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('masyarakat.pengaduan-saya', compact('pengaduans'));
}
public function preview($id)
{
    $pengaduans = Pengaduan::findOrFail($id);

    return view('admin.preview', compact('pengaduans'));
}
public function respond(Request $request, $id)
{
    $pengaduan = Pengaduan::findOrFail($id);
    $pengaduan->admin_response = $request->input('admin_response');
    $pengaduan->save();

    return redirect()->route('pengaduan.index')->with('success', 'Respon berhasil dikirim!');
}
public function selesai()
{
    $pengaduans = Pengaduan::with('user')
        ->whereIn('status', ['selesai', 'ditolak'])  // ✅ pakai whereIn
        ->latest()
        ->get();

    return view('admin.crud-done', compact('pengaduans'));
}

}