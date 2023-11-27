<?php

namespace App\Actions;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\TrendMoment as ModelsTrendMoment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class TrendMoment
{
    public static function proses(Carbon $start, Carbon $end): void
    {
        if ($start->month >= $end->month && $start->year >= $end->year) abort(500);

        ModelsTrendMoment::truncate();
        $allProduk = Produk::all();

        $x = 0;
        $tm = [];

        while ($start->month <= $end->month && $start->year <= $end->year) {
            foreach ($allProduk as $produk) {
                $sum = Penjualan::whereMonth('tanggal', $start->month)
                    ->whereYear('tanggal', $start->year)
                    ->where('produk_id', $produk->id)->sum('qty');

                ModelsTrendMoment::create([
                    'produk_id' => $produk->id,
                    'bulan' => $start->month,
                    'tahun' => $start->year,
                    'y' => $sum,
                    'x' => $x,
                    'x_2' => $x * $x,
                    'x_y' => $x * $sum,
                ]);

                if (isset($tm[$produk->id])) {
                    $tm[$produk->id]['y'] += $sum;
                    $tm[$produk->id]['x'] += $x;
                    $tm[$produk->id]['x_2'] += $x * $x;
                    $tm[$produk->id]['x_y'] += $x * $sum;
                    $tm[$produk->id]['count'] += 1;
                } else {
                    $tm[$produk->id]['y'] = $sum;
                    $tm[$produk->id]['x'] = $x;
                    $tm[$produk->id]['x_2'] = $x * $x;
                    $tm[$produk->id]['x_y'] = $x * $sum;
                    $tm[$produk->id]['count'] = 1;
                }
            }

            $start->addMonth();
            $x++;
        }

        Cache::forget('trend_moment');

        foreach ($tm as $key => $item) {
            $an = $item['count'];
            $ax = $item['x'];
            $bx = $item['x'];
            $bx_2 = $item['x_2'];
            $y = $item['y'];
            $xy = $item['x_y'];

            $m_1 = 1;
            $m_2 = 1;

            $temp_an = $an * $m_1;
            $temp_ax = $ax * $m_2;
            while ($temp_an != $temp_ax) {
                if ($temp_an > $temp_ax) {
                    $m_1 = 1;
                    $m_2++;
                } else {
                    $m_1++;
                }

                $temp_an = $an * $m_1;
                $temp_ax = $ax * $m_2;
            }

            $an *= $m_1;
            $bx *= $m_1;
            $y *= $m_1;

            $ax *= $m_2;
            $bx_2 *= $m_2;
            $xy *= $m_2;

            $b = ($y - $xy) / ($bx - $bx_2);
            $tm[$key]['b'] = $b;

            $an = $item['count'];
            $bx = $item['x'] * $b;
            $y = $item['y'];

            $a = $y - $bx;
            $a = $a / $an;
            $tm[$key]['a'] = $a;
        }

        Cache::rememberForever('trend_moment', fn () => $tm);
    }

    public static function forcast(int $x, int $produkID): int
    {
        $tm = Cache::get('trend_moment');
        return $tm[$produkID]['a'] + $tm[$produkID]['b'] * $x;
    }
}
