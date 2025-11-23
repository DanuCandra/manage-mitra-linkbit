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
            'bandwidth_value' => 'required|numeric|min:0.01',
            'bandwidth_unit' => 'required|in:Mbps,Gbps',
        ], [
            'bandwidth_value.required' => 'Nilai bandwidth harus diisi',
            'bandwidth_value.numeric' => 'Nilai bandwidth harus berupa angka',
            'bandwidth_value.min' => 'Nilai bandwidth minimal 0.01',
            'bandwidth_unit.required' => 'Unit bandwidth harus dipilih',
        ]);

        $mitra = Mitra::findOrFail($id);

        // Get current bandwidth in Mbps
        $currentBandwidthMbps = $mitra->getBandwidthInMbps();

        // Get input bandwidth in Mbps
        $inputValue = floatval($request->bandwidth_value);
        $inputUnit = $request->bandwidth_unit;
        $inputBandwidthMbps = $inputUnit === 'Gbps' ? $inputValue * 1000 : $inputValue;

        // Calculate new total in Mbps
        $newTotalMbps = $currentBandwidthMbps + $inputBandwidthMbps;

        // Format output: jika >= 1000 Mbps, convert ke Gbps
        if ($newTotalMbps >= 1000) {
            $newTotalGbps = $newTotalMbps / 1000;
            // Bulatkan jika bulat, atau tampilkan desimal jika perlu
            $formattedValue = $newTotalGbps == floor($newTotalGbps) ? intval($newTotalGbps) : number_format($newTotalGbps, 2);
            $mitra->bandwidth = $formattedValue . ' Gbps';
        } else {
            $formattedValue = $newTotalMbps == floor($newTotalMbps) ? intval($newTotalMbps) : number_format($newTotalMbps, 2);
            $mitra->bandwidth = $formattedValue . ' Mbps';
        }

        $mitra->save();

        return redirect()->route('manage-bandwidth')
            ->with('success', 'Berhasil menambahkan ' . $inputValue . ' ' . $inputUnit . ' ke ' . $mitra->nama_mitra . '. Total bandwidth sekarang: ' . $mitra->bandwidth);
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

        $oldBandwidth = $mitra->bandwidth ?? '0 Mbps';

        $newValue = floatval($request->bandwidth_value);
        $newUnit = $request->bandwidth_unit;

        // Format: hapus .00 jika bulat
        $formattedValue = $newValue == floor($newValue) ? intval($newValue) : number_format($newValue, 2);
        $mitra->bandwidth = $formattedValue . ' ' . $newUnit;
        $mitra->save();

        return redirect()->route('manage-bandwidth')
            ->with('success', 'Berhasil mengubah bandwidth ' . $mitra->nama_mitra . ' dari ' . $oldBandwidth . ' menjadi ' . $mitra->bandwidth);
    }
}
