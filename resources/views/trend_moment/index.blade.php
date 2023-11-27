@extends('components.layouts.base')

@section('content')
    @include('components.others.validation-alert')
    @livewire('trend_moment.table')
@endsection

@push('modals')
    <dialog id="modal_proses_trend_moment" class="modal">
        <form action="{{ route('trendmoment.proses') }}" class="modal-box rounded-lg" method="POST">
            @csrf
            @method('POST')

            <h3 class="font-bold text-lg">Proses Trend Moment</h3>

            <div class="py-4 space-y-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Start Bulan Tahun</span>
                    </label>

                    <input type="date" name="start" class="input input-bordered w-full" />
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Akhir Bulan Tahun</span>
                    </label>

                    <input type="date" name="end" class="input input-bordered w-full" />
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
