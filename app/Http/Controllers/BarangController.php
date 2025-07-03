<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index');
    }

    public function getData()
    {
        $barang = Barang::all();
        return response()->json(['data' => $barang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'required|string|max:255',
        ]);

        $barang = Barang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil ditambahkan!',
            'data' => $barang
        ]);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json(['data' => $barang]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'required|string|max:255',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diupdate!',
            'data' => $barang
        ]);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil dihapus!'
        ]);
    }

    public function exportPDF()
    {
        $barang = Barang::all();
        $pdf = Pdf::loadView('barang.pdf', compact('barang'));
        return $pdf->download('laporan-inventaris-barang.pdf');
    }
}
