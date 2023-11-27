<?php
// {{-- blade-formatter-disable --}}
use App\Models\{DRP, Customer, Produk};
use function Livewire\Volt\{state, with, action, usesPagination, updating, updated};

usesPagination();

state(['customerID' => 1, 'produkID' => 1]);

with(
    fn() => [
        'rows' => $this->tableData(),
    ],
);

$tableData = action(
    fn() => DRP::where('customer_id', $this->customerID)
        ->where('produk_id', $this->produkID)
        ->orderBy('bulan', 'asc')->orderBy('tahun', 'asc')->get()
    )->renderless();

$allCustomer = action(fn() => Customer::all())->renderless();
$allProduk = action(fn() => Produk::all())->renderless();

    // {{-- blade-formatter-enable --}}
?>


<div class="rounded-lg border py-4">
    <div class="px-4 mb-4 flex items-center gap-4">
        <div class="flex-1 flex gap-2">
            <div wire:ignore class="w-full grid grid-cols-12 gap-2">
                <div x-data="select_customer" class="col-span-8">
                    <select x-ref="selectEl" class="w-full">
                        @forelse ($this->allCustomer() as $customer)
                            <option @selected($this->customerID == $customer->id) value="{{ $customer->id }}">
                                {{ Str::of($customer->nama)->upper() }}
                            </option>
                        @empty
                        @endforelse
                    </select>

                    <input type="hidden" x-ref="inputEl" wire:model.live="customerID"
                        value="{{ $customerID }}">
                </div>

                <select wire:model.change="produkID"
                    class="select select-bordered w-full col-span-4">
                    @forelse ($this->allProduk() as $produk)
                        <option @selected($this->produkID == $produk->id) value="{{ $produk->id }}">
                            {{ Str::of($produk->nama)->upper() }}
                        </option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <button onclick="modal_proses_drp.showModal()" class="btn btn-primary">
                <x-icons.plus class="h-5 w-5" />
                PROSES
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra border-collapse">
            <!-- head -->
            <thead>
                <tr class="border">
                    <th rowspan="2" class="border w-1"></th>
                    <th colspan="{{ count($rows) }}" class="border text-center">Priode</th>
                </tr>

                <tr>
                    @foreach ($rows as $row)
                        @if ($row->tahun == 0 && $row->bulan == 0)
                            <th class="border">PD</th>
                        @else
                            @php
                                $priode = Carbon\Carbon::create($row->tahun, $row->bulan);
                            @endphp
                            <th class="border">
                                {{ $priode->format('M') }} - {{ $priode->format('y') }}
                            </th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border whitespace-nowrap">Gross Requirement</td>
                    @foreach ($rows as $row)
                        <td class="border">{{ $row->gross_requirement }}</td>
                    @endforeach
                </tr>

                <tr>
                    <td class="border whitespace-nowrap">Projected On Hand</td>
                    @foreach ($rows as $row)
                        <td class="border">{{ $row->projected_on_hand }}</td>
                    @endforeach
                </tr>

                <tr>
                    <td class="border whitespace-nowrap">Net Requirement</td>
                    @foreach ($rows as $row)
                        <td class="border">{{ $row->net_requirement }}</td>
                    @endforeach
                </tr>

                <tr>
                    <td class="border whitespace-nowrap">Plan Order Receipt</td>
                    @foreach ($rows as $row)
                        <td class="border">{{ $row->plan_order_receipt }}</td>
                    @endforeach
                </tr>

                <tr>
                    <td class="border whitespace-nowrap">Plan Order Release</td>
                    @foreach ($rows as $row)
                        <td class="border">{{ $row->plan_order_release }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
