<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $barangBaik = Barang::where('kondisi', 'Baik')->count();
        $barangRusak = Barang::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();

        return view('dashboard', compact('totalBarang', 'barangBaik', 'barangRusak'));
    }
}
