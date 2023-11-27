@extends('components.layouts.base')

@section('content')
    <div class="">
        <div class="card mx-auto w-full max-w-xl bg-base-100 shadow-md border">
            <form action="{{ route('produk.store') }}" class="card-body" method="POST">
                @csrf
                @method('POST')

                <h2 class="card-title">Form Tambah Produk</h2>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Nama Produk</span>
                    </label>

                    <input type="text" placeholder="nama produk" name="nama"
                        class="input input-bordered w-full" value="{{ old('nama') }}" />

                    @error('nama')
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
