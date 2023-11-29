<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DRP</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=roboto:100,400,500,900" rel="stylesheet" />

    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body class="antialiased min-h-screen min-w-full grid place-content-center">

    <div class="grid grid-cols-2 border rounded-lg shadow-md overflow-hidden">
        <div class="">
            <img src="{{ asset('399873063_18079099234405301_1439643975386923755_n.jpg') }}"
                class="h-full max-h-[35rem]" alt="">
        </div>

        <div class="grid place-content-center">
            <div class="card w-full bg-base-100">
                <form action="{{ route('login') }}" class="card-body" method="POST">
                    @csrf
                    @method('POST')

                    <h2 class="card-title">Welcome Back :)</h2>
                    <p class="h-auto">Silangkan login untuk menggunakan applikasi</p>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>

                        <input type="email" placeholder="email" name="email"
                            class="input input-bordered w-full" value="{{ old('email') }}" />

                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>

                        <input type="password" placeholder="password" name="password"
                            class="input input-bordered w-full" value="{{ old('password') }}" />

                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="card-actions mt-4 justify-end">
                        <button class="btn btn-primary">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    @vite(['resources/js/app.js'])
</body>

</html>
