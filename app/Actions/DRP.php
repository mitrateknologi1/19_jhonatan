<?php

namespace App\Actions;

use App\Models\Customer;
use App\Models\DRP as ModelsDRP;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;

class DRP
{
    public static function proses(Carbon $blnThn): void
    {
        $allProduk = Produk::all();
        $dewa = Customer::find(1);

        foreach ($allProduk as $produk) {
            $allCustomer = Customer::whereNotIn('id', [1])->get();
            foreach ($allCustomer as $customer) {
                self::drp($produk, $customer, $blnThn);
            }

            self::drp($produk, $dewa, $blnThn);
        }
    }

    private static function drp(Produk $produk, Customer $customer, Carbon $priode): void
    {
        $prevPriode = $priode->copy()->subMonth();
        $prevDrp = ModelsDRP::where('customer_id', $customer->id)
            ->where('produk_id', $produk->id)
            ->where('bulan', $prevPriode->month)
            ->where('tahun', $prevPriode->year)->first();

        if (empty($prevDrp)) {
            $initDrp = ModelsDRP::where('customer_id', $customer->id)
                ->where('produk_id', $produk->id)
                ->where('bulan', 0)
                ->where('tahun', 0)->first();

            if ($initDrp) {
                dd($initDrp);
                abort(400, 'Pastikan proses bulan: ' . $prevPriode->format('M') . ' thn: ' . $prevPriode->format('Y'));
            } else {
                $prevDrp = ModelsDRP::create([
                    'customer_id' => $customer->id,
                    'produk_id' => $produk->id,
                    'bulan' => 0,
                    'tahun' => 0,
                    'gross_requirement' => null,
                    'projected_on_hand' => 0,
                    'net_requirement' => null,
                    'plan_order_receipt' => null,
                    'plan_order_release' => null,
                ]);
            }
        }

        $grossRequirement = Penjualan::whereMonth('tanggal', $priode->month)
            ->whereYear('tanggal', $priode->year)
            ->when(
                $customer->id != 1,
                fn ($query) => $query->where('customer_id', $customer->id)
            )
            ->where('produk_id', $produk->id)->sum('qty');


        $prevDrp->plan_order_release = $grossRequirement;
        $prevDrp->save();

        $safetyStock = 0;
        $projectedOnHand = 0;
        $netRequirement = abs(($safetyStock - $projectedOnHand) - $grossRequirement);

        $drp = ModelsDRP::where('customer_id', $customer->id)
            ->where('produk_id', $produk->id)
            ->where('bulan', $priode->month)
            ->where('tahun', $priode->year)->first();

        if (empty($drp)) {
            ModelsDRP::create([
                'customer_id' => $customer->id,
                'produk_id' => $produk->id,
                'bulan' => $priode->month,
                'tahun' => $priode->year,
                'gross_requirement' => $grossRequirement,
                'projected_on_hand' => $projectedOnHand,
                'net_requirement' => $netRequirement,
                'plan_order_receipt' => $prevDrp->plan_order_release,
                'plan_order_release' => null,
            ]);
        } else {
            $drp->update([
                'gross_requirement' => $grossRequirement,
                'projected_on_hand' => $projectedOnHand,
                'net_requirement' => $netRequirement,
                'plan_order_receipt' => $prevDrp->plan_order_release,
            ]);
        }
    }
}
