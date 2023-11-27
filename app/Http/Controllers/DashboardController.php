<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $start = Penjualan::orderBy('id', 'asc')->first();
        $end = Penjualan::orderBy('id', 'desc')->first();

        $data = [
            'customer' => Customer::count(),
            'penjualan' => Penjualan::count(),
            'penjualan_today' => Penjualan::whereDate('tanggal', now())->count(),
            'produk' => Produk::count(),
            'pendapatan' => Penjualan::sum('harga_total'),
            'pendapatan_date' => [
                'from' => Carbon::create($start->tanggal),
                'to' => Carbon::create($end->tanggal),
            ]
        ];

        return view('dashboard.index', compact('data'));
    }

    public function penjualan_tahunan(): JsonResponse
    {
        $currentYear = now()->year;
        $data = Penjualan::whereYear('tanggal', $currentYear)
            ->select(DB::raw('MONTH(tanggal) as month'), DB::raw('SUM(harga_total) as total'))
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->get();

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }
}
