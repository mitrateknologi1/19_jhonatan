@extends('components.layouts.base')

@section('content')
    <div class="stats shadow-md w-full border">

        <div class="stat">
            <div class="stat-figure text-secondary">
                <x-icons.cash class="h-10 w-10" />
            </div>
            <div class="stat-title">Pendapatan</div>
            <div class="stat-value">{{ Formater::million($data['pendapatan']) }}</div>
            <div class="stat-desc">
                {{ $data['pendapatan_date']['from']->format('M Y') }} -
                {{ $data['pendapatan_date']['to']->format('M Y') }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <x-icons.list-details class="h-10 w-10" />
            </div>
            <div class="stat-title">Penjualan</div>
            <div class="stat-value">{{ $data['penjualan'] }}</div>
            <div class="stat-desc">Hari ini: {{ $data['penjualan_today'] }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <x-icons.users class="h-10 w-10" />
            </div>
            <div class="stat-title">Customer</div>
            <div class="stat-value">{{ $data['customer'] }}</div>
            {{-- <div class="stat-desc">↗︎ 400 (22%)</div> --}}
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <x-icons.box class="h-10 w-10" />
            </div>
            <div class="stat-title">Produk</div>
            <div class="stat-value">{{ $data['produk'] }}</div>
            {{-- <div class="stat-desc">↘︎ 90 (14%)</div> --}}
        </div>

    </div>

    <div class="card w-full mt-6 bg-base-100 shadow-md border">
        <div x-data="chart_penjualan_tahunan" class="card-body">
            <h2 class="card-title">Pendapatan Tahun Ini</h2>
            <canvas x-ref="canvas" class="max-h-96"></canvas>
        </div>
    </div>
@endsection

@push('modals')
@endpush
