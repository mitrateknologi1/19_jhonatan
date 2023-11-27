<?php

namespace App\Actions;

use App\Actions\TrendMoment as ActionsTrendMoment;
use App\Models\MAPE as ModelsMAPE;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\TrendMoment;
use Carbon\Carbon;

class MAPE
{
    public static function proses(Carbon $start, Carbon $end)
    {
        ModelsMAPE::truncate();
        $allProduk = Produk::all();

        $trendMoment = TrendMoment::orderBy('id', 'desc')->first();
        $trendMomentDate = Carbon::create($trendMoment->tahun, $trendMoment->bulan);

        while ($start->month <= $end->month && $start->year <= $end->year) {
            foreach ($allProduk as $produk) {
                $sum = Penjualan::whereMonth('tanggal', $start->month)
                    ->whereYear('tanggal', $start->year)
                    ->where('produk_id', $produk->id)->sum('qty');

                if ($trendMomentDate->greaterThan($start)) {
                    $x = $trendMoment->x - $trendMomentDate->diff($start)->m;
                } else {
                    $x = $trendMoment->x + $trendMomentDate->diff($start)->m;
                }

                $y = ActionsTrendMoment::forcast($x, $produk->id);

                ModelsMAPE::create([
                    'produk_id' => $produk->id,
                    'bulan' => $start->month,
                    'tahun' => $start->year,
                    'aktual' => $sum ?? 0,
                    'forcast' => $y,
                ]);
            }

            $start->addMonth();
        }
    }
}
