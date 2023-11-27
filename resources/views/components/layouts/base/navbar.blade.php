<div class="border-b bg-base-100">
    <div class="w-full navbar max-w-6xl mx-auto">
        <div class="flex-none lg:hidden">
            <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </label>
        </div>
        <div class="flex-1 px-2 mx-2 lg:px-0 lg:mx-0 font-bold text-xl">WEWE <span
                class="font-normal">.co</span> </div>
        <div class="flex-none flex items-center">
            <ul class="menu menu-horizontal font-medium">
                <!-- Navbar menu content here -->
                <li>
                    <a href="{{ route('dashboard.index') }}">
                        <x-icons.gauge class="h-5 w-5" />
                        Dashboard
                    </a>
                </li>

                <li>
                    <details>
                        <summary>
                            <x-icons.cpu class="h-5 w-5" />
                            Algoritma
                        </summary>
                        <ul class="rounded-md border !mt-3 shadow-md z-20">
                            <li>
                                <a href="{{ route('drp.index') }}">
                                    <x-icons.file-analytics class="h-5 w-5" />
                                    DRP
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('trendmoment.index') }}">
                                    <x-icons.chart-line class="h-5 w-5" />
                                    Trend Moment
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

                <li>
                    <a href="{{ route('mape.index') }}">
                        <x-icons.file-percent class="h-5 w-5" />
                        MAPE
                    </a>
                </li>

                <li>
                    <details>
                        <summary>
                            <x-icons.category class="h-5 w-5" />
                            Master Data
                        </summary>
                        <ul class="rounded-md border !mt-3 shadow-md z-20">
                            <li>
                                <a href="{{ route('customer.index') }}">
                                    <x-icons.users class="h-5 w-5" />
                                    Customer
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('produk.index') }}">
                                    <x-icons.box class="h-5 w-5" />
                                    Produk
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('penjualan.index') }}">
                                    <x-icons.list-details class="h-5 w-5" />
                                    Penjualan
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>

            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component"
                            src="https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Felix" />
                    </div>
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-md border bg-base-100 rounded-md w-52">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button type="submit" class="w-full inline-block">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
