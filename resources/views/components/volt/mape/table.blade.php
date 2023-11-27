<?php
// {{-- blade-formatter-disable --}}
use App\Models\{MAPE, Produk};
use function Livewire\Volt\{state, with, action, usesPagination};
use Illuminate\Support\Facades\Cache;


usesPagination();

state(['produkID' => 1]);

with(
    fn() => [
        'rows' => $this->tableData(),
        'tm' => Cache::get('trend_moment') ?? [],
    ],
);

$tableData = action(
    fn() => MAPE::with(['produk'])->where('produk_id', $this->produkID)->orderBy('id', 'asc')->get()
    )->renderless();

$allProduk = action(fn() => Produk::all())->renderless();

    // {{-- blade-formatter-enable --}}
?>


<div class="rounded-lg border py-4">
    <div class="px-4 mb-4 flex justify-between">
        <div class="flex gap-2">
            <select wire:model.change="produkID" class="select select-bordered w-full col-span-4">
                @forelse ($this->allProduk() as $produk)
                    <option @selected($this->produkID == $produk->id) value="{{ $produk->id }}">
                        {{ Str::of($produk->nama)->upper() }}
                    </option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="flex gap-2">
            <button onclick="modal_proses_mape.showModal()" class="btn btn-primary">
                <x-icons.plus class="h-5 w-5" />
                Proses
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra border-collapse">
            <!-- head -->
            <thead>
                <tr class="border">
                    <th class="border w-1">No.</th>
                    <th class="border">Nama Barang</th>
                    <th class="border">Priode</th>
                    <th class="border">Aktual (y)</th>
                    <th class="border">Forcast (y')</th>
                    <th class="border">|y - y'|</th>
                    <th class="border">MAPE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 0;
                    $mape_sum = 0;
                @endphp

                @foreach ($rows as $row)
                    @php
                        $priode = Carbon\Carbon::create($row->tahun, $row->bulan);
                        $no++;

                        $aktual = $row->aktual;
                        $forcast = $row->forcast;
                        $yy = abs($aktual - $forcast);
                        $mape = $aktual == 0 ? 100 : ($yy / $aktual) * 100;
                        $mape_sum += $mape;
                    @endphp

                    <tr>
                        <td class="border">{{ $no }}</td>
                        <td class="border uppercase whitespace-nowrap">{{ $row->produk->nama }}</td>

                        <td class="border">
                            {{ $priode->format('M') }} - {{ $priode->format('y') }}
                        </td>

                        <td class="border">{{ $aktual }}</td>
                        <td class="border">{{ $forcast }}</td>
                        <td class="border">{{ number_format($yy, 2) }}</td>
                        <td class="border">{{ number_format($mape, 2) }}</td>
                    </tr>
                @endforeach

                @if (count($rows) > 0)
                    <tr>
                        <td colspan="6" class="border text-center">Presentase MAPE</td>
                        <td class="border">{{ number_format($mape_sum / count($rows), 2) }}%</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
