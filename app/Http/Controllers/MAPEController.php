<?php

namespace App\Http\Controllers;

use App\Actions\MAPE as ActionsMAPE;
use App\Actions\TrendMoment as ActionsTrendMoment;
use App\Models\MAPE;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\TrendMoment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MAPEController extends Controller
{
    public function index(): View
    {
        return view('mape.index');
    }

    public function proses(Request $request): RedirectResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $start = Carbon::create($request->input('start'));
        $end = Carbon::create($request->input('end'));

        ActionsMAPE::proses($start, $end);

        return redirect()->back();
    }
}
