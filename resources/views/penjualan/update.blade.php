@extends('components.layouts.base')

@section('content')
    <div class="">
        <div class="card mx-auto w-full max-w-xl bg-base-100 shadow-md border">
            <form action="{{ route('penjualan.update', ['penjualan' => $penjualan->id]) }}"
                class="card-body" method="POST">
                @csrf
                @method('PUT')

                <h2 class="card-title">Form Tambah Customer</h2>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Tanggal</span>
                    </label>

                    <input type="date" name="tanggal" class="input input-bordered w-full"
                        value="{{ old('tanggal') ?? $penjualan->tanggal }}" />

                    @error('tanggal')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Customer</span>
                    </label>

                    <div x-data="select_customer" class="col-span-8">
                        <select x-ref="selectEl" class="w-full">
                            @forelse ($allCustomer as $customer)
                                <option @selected(old('customer_id') ?? $penjualan->customer_id == $customer->id) value="{{ $customer->id }}">
                                    {{ Str::of($customer->nama)->upper() }}
                                </option>
                            @empty
                            @endforelse
                        </select>

                        <input type="hidden" x-ref="inputEl" name="customer_id"
                            value="{{ old('customer_id') ?? $penjualan->customer_id }}">
                    </div>

                    @error('customer_id')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Produk</span>
                    </label>

                    <select name="produk_id" class="select select-bordered w-full col-span-4">
                        @forelse ($allProduk as $produk)
                            <option @selected(old('produk_id') ?? $penjualan->produk_id == $produk->id) value="{{ $produk->id }}">
                                {{ Str::of($produk->nama)->upper() }}
                            </option>
                        @empty
                        @endforelse
                    </select>

                    @error('produk_id')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Qty</span>
                        </label>

                        <input type="number" name="qty" class="input input-bordered w-full"
                            value="{{ old('qty') ?? $penjualan->qty }}" />

                        @error('qty')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Harga Per Unit</span>
                        </label>

                        <input type="number" name="harga_unit" class="input input-bordered w-full"
                            value="{{ old('harga_unit') ?? $penjualan->harga_unit }}" />

                        @error('harga_unit')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="card-actions justify-end mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('modals')
@endpush
