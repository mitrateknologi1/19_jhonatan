<?php

namespace App\Http\Controllers;

use App\Actions\DRP as ActionsDRP;
use App\Models\Customer;
use App\Models\DRP;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DRPController extends Controller
{
    public function index(): View
    {
        return view('drp.index');
    }

    public function proses(Request $request): RedirectResponse
    {
        $request->validate([
            'priode' => 'required|date'
        ]);

        $blnThn = Carbon::create($request->input('priode'));

        DB::transaction(fn () => ActionsDRP::proses($blnThn));

        return redirect()->back();
    }
}
