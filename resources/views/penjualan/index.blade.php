@extends('components.layouts.base')

@section('content')
    @include('components.others.validation-alert')

    @livewire('penjualan.table')
@endsection

@push('modals')
    <dialog id="modal_import_penjualan" class="modal">
        <form action="{{ route('penjualan.import') }}" enctype="multipart/form-data"
            class="modal-box rounded-lg" method="POST">
            @csrf
            @method('POST')

            <h3 class="font-bold text-lg">Import Penjualan</h3>

            <p class="text-sm mt-2">
                *Tipe file harus mengkuti foramt excel
            </p>

            <div class="py-4">
                <input type="file" name="file" class="file-input file-input-bordered w-full" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Proses</button>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endpush
