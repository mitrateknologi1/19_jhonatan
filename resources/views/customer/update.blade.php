@extends('components.layouts.base')

@section('content')
    <div class="">
        <div class="card mx-auto w-full max-w-xl bg-base-100 shadow-md border">
            <form action="{{ route('customer.update', ['customer' => $customer->id]) }}" class="card-body"
                method="POST">
                @csrf
                @method('PUT')

                <h2 class="card-title">Form Tambah Customer</h2>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>

                    <input type="text" placeholder="nama customer" name="nama"
                        class="input input-bordered w-full"
                        value="{{ old('nama') ?? $customer->nama }}" />

                    @error('nama')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Alamat</span>
                    </label>

                    <input type="text" placeholder="alamat" name="alamat"
                        class="input input-bordered w-full"
                        value="{{ old('alamat') ?? $customer->alamat }}" />

                    @error('alamat')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Area</span>
                    </label>

                    <input type="text" placeholder="area" name="area"
                        class="input input-bordered w-full"
                        value="{{ old('area') ?? $customer->area }}" />

                    @error('area')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
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
