<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Mitra;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DokumenController extends Controller
{

    public function manage_dokumen()
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Cari mitra berdasarkan user_id
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        // ambil semua dokumen milik mitra tersebut
        $dokumen = Dokumen::where('mitra_id', $mitra->id)
            ->with('mitra') // agar bisa ambil nama mitra
            ->get();

        return view('mitra.dokumen-mitra.manage-dokumen', compact('dokumen'));
    }


    public function create()
    {
        return view('mitra.dokumen-mitra.add-dokumen');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer',

            // PDF document
            'nib'            => 'nullable|file|mimes:pdf|max:10240',
            'sertif_standar' => 'nullable|file|mimes:pdf|max:10240',
            'kso'            => 'nullable|file|mimes:pdf|max:10240',

            // Images
            'foto_ktp'     => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'foto_usaha'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'foto_brosur'  => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $user = Auth::user();
        if (!$user || !$user->mitra) {
            return redirect()->back()->with('error', 'Mitra tidak ditemukan atau user belum login.');
        }
        $mitraId = $user->mitra->id;

        // Daftar folder untuk setiap jenis file
        $folderMap = [
            'nib'            => 'dokumen/nib',
            'sertif_standar' => 'dokumen/sertif_standar',
            'kso'            => 'dokumen/kso',

            'foto_ktp'       => 'dokumen/foto_ktp',
            'foto_usaha'     => 'dokumen/foto_usaha',
            'foto_brosur'    => 'dokumen/foto_brosur',
        ];

        $data = [
            'mitra_id' => $mitraId,
            'tahun'    => $request->tahun,
        ];

        // Loop upload semua file secara aman
        foreach ($folderMap as $field => $folder) {
            if ($request->hasFile($field)) {

                $file = $request->file($field);

                // Double check MIME
                if (!in_array($file->getMimeType(), ['application/pdf', 'image/jpeg', 'image/png'])) {
                    return back()->with('error', 'File tidak valid!');
                }

                // Generate nama aman
                $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

                // Simpan ke folder masing2
                $path = $file->storeAs($folder, $filename, 'public');

                $data[$field] = $path;
            }
        }

        Dokumen::create($data);

        return redirect()->route('dokumen.manage')->with('success', 'Dokumen berhasil diupload.');
    }

    public function view($id)
    {
        $dokumen = Dokumen::with('mitra')->findOrFail($id);
        return view('mitra.dokumen-mitra.view-dokumen', compact('dokumen'));
    }

    public function destroy($id)
    {
        // Ambil data dokumen berdasarkan ID
        $dokumen = Dokumen::findOrFail($id);

        // daftar kolom file yg perlu dihapus fisiknya
        $fileFields = [
            'nib',
            'sertif_standar',
            'kso',
            'foto_ktp',
            'foto_usaha',
            'foto_brosur',
        ];

        // Hapus file fisik jika ada
        foreach ($fileFields as $field) {
            if (!empty($dokumen->$field)) {
                // Pastikan file ada di storage/public
                if (Storage::disk('public')->exists($dokumen->$field)) {
                    Storage::disk('public')->delete($dokumen->$field);
                }
            }
        }

        // Hapus data dari database
        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus beserta file-file terkait.');
    }

    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $validated = $request->validate([
            'tahun' => 'required|integer',

            // PDF
            'nib'            => 'nullable|file|mimes:pdf|max:10240',
            'sertif_standar' => 'nullable|file|mimes:pdf|max:10240',
            'kso'            => 'nullable|file|mimes:pdf|max:10240',

            // Images
            'foto_ktp'       => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'foto_usaha'     => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'foto_brosur'    => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        // mapping folder penyimpanan
        $folderMap = [
            'nib'            => 'dokumen/nib',
            'sertif_standar' => 'dokumen/sertif_standar',
            'kso'            => 'dokumen/kso',

            'foto_ktp'       => 'dokumen/foto_ktp',
            'foto_usaha'     => 'dokumen/foto_usaha',
            'foto_brosur'    => 'dokumen/foto_brosur',
        ];

        $data = [
            'tahun' => $request->tahun,
        ];

        foreach ($folderMap as $field => $folder) {

            // jika user upload file baru
            if ($request->hasFile($field)) {

                $file = $request->file($field);

                // cek MIME
                if (!in_array($file->getMimeType(), ['application/pdf', 'image/jpeg', 'image/png'])) {
                    return back()->with('error', 'Format file tidak valid.');
                }

                // Hapus file lama
                if (!empty($dokumen->$field) && Storage::disk('public')->exists($dokumen->$field)) {
                    Storage::disk('public')->delete($dokumen->$field);
                }

                // nama file aman (SHA-256)
                $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

                // simpan file baru
                $path = $file->storeAs($folder, $filename, 'public');

                $data[$field] = $path;
            }
        }

        // update database
        $dokumen->update($data);

        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui.');
    }


    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('mitra.dokumen-mitra.edit-dokumen', compact('dokumen'));
    }

     public function downloadAll($id)
    {
        // Ambil data dokumen
        $dokumen = Dokumen::findOrFail($id);

        // Nama file ZIP berdasarkan tahun
        $zipFileName = 'Dokumen_' . $dokumen->tahun . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        // Buat instance ZipArchive
        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Array field dokumen PDF
            $pdfFields = [
                'nib' => 'NIB',
                'sertif_standar' => 'Sertifikat_Standar',
                'kso' => 'KSO',
            ];

            // Array field gambar
            $imageFields = [
                'foto_ktp' => 'Foto_KTP',
                'foto_usaha' => 'Foto_Usaha',
                'foto_brosur' => 'Foto_Brosur',
            ];

            // Tambahkan PDF ke ZIP
            foreach ($pdfFields as $field => $name) {
                if ($dokumen->$field && File::exists(storage_path('app/public/' . $dokumen->$field))) {
                    $filePath = storage_path('app/public/' . $dokumen->$field);
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                    $zip->addFile($filePath, $name . '.' . $extension);
                }
            }

            // Tambahkan Gambar ke ZIP
            foreach ($imageFields as $field => $name) {
                if ($dokumen->$field && File::exists(storage_path('app/public/' . $dokumen->$field))) {
                    $filePath = storage_path('app/public/' . $dokumen->$field);
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                    $zip->addFile($filePath, $name . '.' . $extension);
                }
            }

            $zip->close();
        }

        // Download file ZIP dan hapus setelah download
        if (File::exists($zipFilePath)) {
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Tidak ada file untuk didownload');
    }
}
