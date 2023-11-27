<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class PenjualanImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $customer = Customer::firstOrCreate([
                'nama' => Str::lower($row['nama_customer']),
                'alamat' => Str::lower($row['alamat']),
                'area' => Str::lower($row['area']),
            ]);

            $produk = Produk::firstOrCreate([
                'nama' => Str::lower($row['barang_yang_dipesan']),
            ]);

            Penjualan::create([
                'tanggal' => $this->dateToCarbon($row['tanggal_trax']),
                'customer_id' => $customer->id,
                'produk_id' => $produk->id,
                'qty' => $row['qty'],
                'harga_unit' => $row['harga_satuan'],
                'harga_total' => $row['total'],
            ]);
        }
    }

    private function dateToCarbon($excelDate)
    {
        // Assuming $excelDate is the Excel serial date
        $epochDate = Carbon::create(1900, 1, 1);
        $formattedDate = $epochDate->addDays($excelDate - 2);

        return $formattedDate;
    }
}
