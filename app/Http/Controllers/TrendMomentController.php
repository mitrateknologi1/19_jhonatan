<?php

namespace App\Http\Controllers;

use App\Actions\TrendMoment as ActionsTrendMoment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrendMomentController extends Controller
{
    public function index(): View
    {
        return view('trend_moment.index');
    }

    public function proses(Request $request): RedirectResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $start = Carbon::create($request->input('start'));
        $end = Carbon::create($request->input('end'));

        ActionsTrendMoment::proses($start, $end);

        return redirect()->back();
    }
}
