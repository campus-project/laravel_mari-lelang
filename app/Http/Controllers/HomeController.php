<?php

namespace App\Http\Controllers;

use App\Entities\AuctionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auctionLimited30Minutes = AuctionProduct::whereBetween('end_date', [Carbon::now()->toDateTimeString(), Carbon::now()->addMinutes(30)->toDateTimeString()])->get();
        $auctionProducts = AuctionProduct::where('end_date', '>', Carbon::now()->toDateTimeString())->where('start_date', '<=', now())->get();

        return view('home', compact($auctionProducts, $auctionLimited30Minutes));
    }
}
