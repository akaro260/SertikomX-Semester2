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
    $request->validate([
        'admin_response' => 'nullable|string',
        'status' => 'required|in:pending,diproses,selesai,ditolak',
    ]);

    $pengaduan = Pengaduan::findOrFail($id);

    $pengaduan->admin_response = $request->admin_response;
    $pengaduan->status = $request->status;

    $pengaduan->save();

    return redirect()
        ->route('pengaduan.index')
        ->with('success', 'Respon berhasil dikirim!');
}
public function selesai()
{
    $pengaduans = Pengaduan::with('user')
        ->whereIn('status', ['selesai', 'ditolak'])  // ✅ pakai whereIn
        ->latest()
        ->get();

    return view('admin.crud-done', compact('pengaduans'));
}
public function dashboarad()
{
    $total   = Pengaduan::count();
    $selesai = Pengaduan::where('status', 'selesai')->count();
    $pending = Pengaduan::where('status', 'pending')->count();
    $ditolak = Pengaduan::where('status', 'ditolak')->count();

    $pct_selesai = $total > 0 ? round(($selesai / $total) * 100) : 0;
    $pct_pending = $total > 0 ? round(($pending / $total) * 100) : 0;
    $pct_ditolak = $total > 0 ? round(($ditolak / $total) * 100) : 0;

    // Data per bulan untuk line chart
    $chartData = [
        'labels'  => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        'total'   => [],
        'selesai' => [],
        'pending' => [],
        'ditolak' => [],
    ];

    for ($i = 1; $i <= 12; $i++) {
        $chartData['total'][]   = Pengaduan::whereMonth('created_at', $i)->whereYear('created_at', now()->year)->count();
        $chartData['selesai'][] = Pengaduan::where('status', 'selesai')->whereMonth('created_at', $i)->whereYear('created_at', now()->year)->count();
        $chartData['pending'][] = Pengaduan::where('status', 'pending')->whereMonth('created_at', $i)->whereYear('created_at', now()->year)->count();
        $chartData['ditolak'][] = Pengaduan::where('status', 'ditolak')->whereMonth('created_at', $i)->whereYear('created_at', now()->year)->count();
    }

    return view('admin.dashboarad', compact(
        'total', 'selesai', 'pending', 'ditolak',
        'pct_selesai', 'pct_pending', 'pct_ditolak',
        'chartData'
    ));
}
public function dashboardMasyarakat()
{
    // cegah admin masuk dashboard masyarakat
    if (auth()->user()->role !== 'Masyarakat') {
        return redirect('/dashboarad');
    }

    $userId = auth()->id();

    $total    = Pengaduan::where('user_id', $userId)->count();
    $selesai  = Pengaduan::where('user_id', $userId)->where('status', 'selesai')->count();
    $pending  = Pengaduan::where('user_id', $userId)->where('status', 'pending')->count();
    $ditolak  = Pengaduan::where('user_id', $userId)->where('status', 'ditolak')->count();
    $direspon = Pengaduan::where('user_id', $userId)->whereNotNull('admin_response')->count();

    $pct_selesai  = $total > 0 ? round(($selesai  / $total) * 100) : 0;
    $pct_pending  = $total > 0 ? round(($pending  / $total) * 100) : 0;
    $pct_ditolak  = $total > 0 ? round(($ditolak  / $total) * 100) : 0;
    $pct_direspon = $total > 0 ? round(($direspon / $total) * 100) : 0;

    $laporanTerbaru = Pengaduan::where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    return view('pages.dashboard.ecommerce', compact(
        'total', 'selesai', 'pending', 'ditolak', 'direspon',
        'pct_selesai', 'pct_pending', 'pct_ditolak', 'pct_direspon',
        'laporanTerbaru'
    ));
}
}