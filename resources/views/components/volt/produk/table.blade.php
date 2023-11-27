<?php
// {{-- blade-formatter-disable --}}
use App\Models\Produk;
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
    fn() => Produk::when(
            $this->search != '', 
            fn($query) => $query->mesearch(['nama'], $this->search)
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
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <x-icons.plus class="h-5 w-5" />
                Tambah
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra border-collapse">
            <!-- head -->
            <thead>
                <tr class="border">
                    <x-table.sortable-heading wire:click="sort('nama')" :sort="$sortBy == 'nama' ? $sortDir : ''">
                        Nama
                    </x-table.sortable-heading>

                    <th class="border w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td class="border uppercase">{{ $row->nama }}</td>
                        <td class="border">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('produk.edit', ['produk' => $row->id]) }}"
                                    class="btn btn-square btn-ghost btn-xs">
                                    <x-icons.pencil-cog class="h-5 w-5" />
                                </a>

                                <form action="{{ route('produk.destroy', ['produk' => $row->id]) }}"
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
