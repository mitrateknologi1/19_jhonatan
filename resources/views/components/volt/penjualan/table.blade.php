<?php
// {{-- blade-formatter-disable --}}
use App\Models\Penjualan;
use function Livewire\Volt\{state, with, action, usesPagination};

usesPagination();

state([
    'perpage' => 5,
    'search' => '',
    'sortBy' => 'created_at',
    'sortDir' => 'desc',
]);

with(
    fn() => [
        'rows' => $this->tableData(),
    ],
);

$tableData = action(
    fn() => Penjualan::with(['customer', 'produk'])->when(
            $this->search != '', 
            fn($query) => $query->mesearch(['customer.nama', 'customer.alamat', 'customer.area', 'produk.nama'], $this->search)
        )->orderBy($this->sortBy, $this->sortDir)->paginate($this->perpage)
    )->renderless();

$sort = function(string $sortBy): void {
    if($this->sortBy != $sortBy) {
        $this->sortBy = $sortBy;
        $this->sortDir = 'desc';
        return;
    }

    $this->sortDir = $this->sortDir == 'asc' ? 'desc' : 'asc';
}

    // {{-- blade-formatter-enable --}}
?>


<div class="rounded-lg border py-4">
    <div class="px-4 mb-4 flex justify-between">
        <div class="flex gap-2">
            @include('components.table.perpage')
            @include('components.table.search')
        </div>

        <div class="flex gap-2">
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
                <x-icons.plus class="h-5 w-5" />
                Tambah
            </a>

            <button onclick="modal_import_penjualan.showModal()" class="btn">
                <x-icons.file-import class="h-5 w-5" />
                Import
            </button>

            <button class="btn btn-square">
                <x-icons.filter class="h-5 w-5" />
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra border-collapse">
            <!-- head -->
            <thead>
                <tr class="border">
                    <x-table.sortable-heading wire:click="sort('tanggal')" :sort="$sortBy == 'tanggal' ? $sortDir : ''">
                        Tanggal
                    </x-table.sortable-heading>

                    <th class="border">Customer</th>

                    <th class="border">Alamat</th>

                    <th class="border">Area</th>

                    <th class="border">Product</th>

                    <x-table.sortable-heading wire:click="sort('qty')" :sort="$sortBy == 'qty' ? $sortDir : ''">
                        Qty
                    </x-table.sortable-heading>

                    <x-table.sortable-heading wire:click="sort('harga_unit')" :sort="$sortBy == 'harga_unit' ? $sortDir : ''">
                        Harga Satuan
                    </x-table.sortable-heading>

                    <x-table.sortable-heading wire:click="sort('harga_total')" :sort="$sortBy == 'harga_total' ? $sortDir : ''">
                        Harga Total
                    </x-table.sortable-heading>

                    <th class="border w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td class="border whitespace-nowrap">
                            {{ Carbon\Carbon::create($row['tanggal'])->format('d M Y') }}
                        </td>

                        <td class="border uppercase">{{ $row->customer->nama }}</td>
                        <td class="border uppercase">{{ $row->customer->alamat }}</td>
                        <td class="border uppercase">{{ $row->customer->area }}</td>
                        <td class="border uppercase">{{ $row->produk->nama }}</td>
                        <td class="border">{{ $row['qty'] }}</td>
                        <td class="border">{{ $row['harga_unit'] }}</td>
                        <td class="border">{{ $row['harga_total'] }}</td>

                        <td class="border">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('penjualan.edit', ['penjualan' => $row->id]) }}"
                                    class="btn btn-square btn-ghost btn-xs">
                                    <x-icons.pencil-cog class="h-5 w-5" />
                                </a>

                                <form
                                    action="{{ route('penjualan.destroy', ['penjualan' => $row->id]) }}"
                                    x-data="confirm_delete_modal" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button x-on:click="showModal()" type="button"
                                        class="btn btn-square btn-ghost btn-xs">
                                        <x-icons.trash class="h-5 w-5" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-4 mt-4">
        {{ $rows->onEachSide(1)->links('vendor.livewire.tailwind') }}
    </div>
</div>
