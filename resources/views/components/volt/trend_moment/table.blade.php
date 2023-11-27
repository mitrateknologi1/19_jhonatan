<?php
// {{-- blade-formatter-disable --}}
use App\Models\{TrendMoment, Produk};
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
    fn() => TrendMoment::with(['produk'])->where('produk_id', $this->produkID)->orderBy('id', 'asc')->get()
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
            <button onclick="modal_proses_trend_moment.showModal()" class="btn btn-primary">
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
                    <th class="border">Penjualan (y)</th>
                    <th class="border">Waktu (x)</th>
                    <th class="border">x ^ 2</th>
                    <th class="border">x * y</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 0;
                    $y = 0;
                    $x = 0;
                    $x_2 = 0;
                    $x_y = 0;
                @endphp

                @foreach ($rows as $row)
                    @php
                        $priode = Carbon\Carbon::create($row->tahun, $row->bulan);
                        $no++;
                        $y += $row->y;
                        $x += $row->x;
                        $x_2 += $row->x_2;
                        $x_y += $row->x_y;
                    @endphp

                    <tr>
                        <td class="border">{{ $no }}</td>
                        <td class="border uppercase whitespace-nowrap">{{ $row->produk->nama }}</td>

                        <td class="border">
                            {{ $priode->format('M') }} - {{ $priode->format('y') }}
                        </td>

                        <td class="border">{{ $row->y }}</td>
                        <td class="border">{{ $row->x }}</td>
                        <td class="border">{{ $row->x_2 }}</td>
                        <td class="border">{{ $row->x_y }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="3" class="border text-center">Total</td>

                    <td class="border">{{ $y }}</td>
                    <td class="border">{{ $x }}</td>
                    <td class="border">{{ $x_2 }}</td>
                    <td class="border">{{ $x_y }}</td>
                </tr>
            </tbody>

            <thead>
                <th colspan="7" class="border text-center">Proyeksi 3 Priode Kedepan</th>
            </thead>


            @if (isset($row))
                <tbody>
                    @php
                        $priode = Carbon\Carbon::create($row->tahun, $row->bulan);
                        $priode->addMonth();

                        $no++;
                        $x = $row->x + 1;
                        $y = App\Actions\TrendMoment::forcast($x, $produkID);
                    @endphp

                    <tr>
                        <td class="border">{{ $no }}</td>
                        <td class="border uppercase whitespace-nowrap">{{ $row->produk->nama }}
                        </td>

                        <td class="border">
                            {{ $priode->format('M') }} - {{ $priode->format('y') }}
                        </td>

                        <td class="border">{{ ceil($y) }}</td>
                        <td class="border">{{ $x }}</td>
                        <td class="border">-
                        <td class="border">-</td>
                    </tr>

                    @php
                        $priode->addMonth();

                        $no++;
                        $x = $row->x + 2;
                        $y = App\Actions\TrendMoment::forcast($x, $produkID);
                    @endphp

                    <tr>
                        <td class="border">{{ $no }}</td>
                        <td class="border uppercase whitespace-nowrap">{{ $row->produk->nama }}
                        </td>

                        <td class="border">
                            {{ $priode->format('M') }} - {{ $priode->format('y') }}
                        </td>

                        <td class="border">{{ ceil($y) }}</td>
                        <td class="border">{{ $x }}</td>
                        <td class="border">-
                        <td class="border">-</td>
                    </tr>

                    @php
                        $priode->addMonth();

                        $no++;
                        $x = $row->x + 3;
                        $y = App\Actions\TrendMoment::forcast($x, $produkID);
                    @endphp

                    <tr>
                        <td class="border">{{ $no }}</td>
                        <td class="border uppercase whitespace-nowrap">{{ $row->produk->nama }}
                        </td>

                        <td class="border">
                            {{ $priode->format('M') }} - {{ $priode->format('y') }}
                        </td>

                        <td class="border">{{ ceil($y) }}</td>
                        <td class="border">{{ $x }}</td>
                        <td class="border">-
                        <td class="border">-</td>
                    </tr>
                </tbody>
            @endif
        </table>
    </div>

    @if (!empty($tm))
        @php
            $a = number_format($tm[$produkID]['a'], 2);
            $b = number_format($tm[$produkID]['b'], 2);
        @endphp
        <div class=" px-4 mt-4">
            Rumus y = {{ $a }} + {{ $b }}x
        </div>
    @endif

</div>
