<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class AdminMitraController extends Controller
{
    public function manage_bandwidth()
    {
        $mitras = Mitra::with('user')->get();
        return view('admin.bandwidth.manage-bandwidth', compact('mitras'));
    }

    // Tambah bandwidth (menambahkan ke bandwidth saat ini)
    public function add_bandwidth(Request $request, $id)
    {
        $request->validate([
            'bandwidth_value' => 'required|numeric|min:1',
            'bandwidth_unit' => 'required|in:Mbps,Gbps',
        ], [
            'bandwidth_value.required' => 'Nilai bandwidth harus diisi',
            'bandwidth_value.numeric' => 'Nilai bandwidth harus berupa angka',
            'bandwidth_value.min' => 'Nilai bandwidth minimal 1',
            'bandwidth_unit.required' => 'Unit bandwidth harus dipilih',
        ]);

        $mitra = Mitra::findOrFail($id);

        // Convert ke Mbps jika unit adalah Gbps
        $bandwidthValue = $request->input('bandwidth_value');
        $bandwidthUnit = $request->input('bandwidth_unit');

        $bandwidthInMbps = $bandwidthUnit === 'Gbps'
            ? $bandwidthValue * 1000
            : $bandwidthValue;

        // Tambahkan bandwidth baru ke bandwidth yang sudah ada
        $currentBandwidth = $mitra->bandwidth ?? 0;
        $mitra->bandwidth = $currentBandwidth + $bandwidthInMbps;
        $mitra->save();

        $addedFormatted = $bandwidthValue . ' ' . $bandwidthUnit;

        return redirect()->route('manage-bandwidth')
            ->with('success', 'Berhasil menambahkan ' . $addedFormatted . ' ke ' . $mitra->nama_mitra . '. Total bandwidth sekarang: ' . $mitra->bandwidth_formatted);
    }

    // Update bandwidth (mengganti bandwidth saat ini)
    public function update_bandwidth(Request $request, $id)
    {
        $request->validate([
            'bandwidth_value' => 'required|numeric|min:0',
            'bandwidth_unit' => 'required|in:Mbps,Gbps',
        ], [
            'bandwidth_value.required' => 'Nilai bandwidth harus diisi',
            'bandwidth_value.numeric' => 'Nilai bandwidth harus berupa angka',
            'bandwidth_value.min' => 'Nilai bandwidth minimal 0',
            'bandwidth_unit.required' => 'Unit bandwidth harus dipilih',
        ]);

        $mitra = Mitra::findOrFail($id);

        $oldBandwidthFormatted = $mitra->bandwidth_formatted;

        // Convert ke Mbps jika unit adalah Gbps
        $bandwidthValue = $request->input('bandwidth_value');
        $bandwidthUnit = $request->input('bandwidth_unit');

        $bandwidthInMbps = $bandwidthUnit === 'Gbps'
            ? $bandwidthValue * 1000
            : $bandwidthValue;

        // Set bandwidth baru (replace)
        $mitra->bandwidth = $bandwidthInMbps;
        $mitra->save();

        $newFormatted = $bandwidthValue . ' ' . $bandwidthUnit;

        return redirect()->route('manage-bandwidth')
            ->with('success', 'Berhasil mengubah bandwidth ' . $mitra->nama_mitra . ' dari ' . $oldBandwidthFormatted . ' menjadi ' . $newFormatted);
    }
}
