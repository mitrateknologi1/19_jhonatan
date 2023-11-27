@extends('components.layouts.base')

@section('content')
    @include('components.others.validation-alert')

    @livewire('drp.table')
@endsection

@push('modals')
    <dialog id="modal_proses_drp" class="modal">
        <form action="{{ route('drp.proses') }}" class="modal-box rounded-lg" method="POST">
            @csrf
            @method('POST')

            <h3 class="font-bold text-lg">Proses DRP</h3>

            <div class="py-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Pilih Bulan</span>
                    </label>

                    <input type="date" name="priode" class="input input-bordered w-full" />
                </div>
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
