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
        $auctionLimited30Minutes = AuctionProduct::whereBetween('end_date', [Carbon::now()->toDateTimeString(), Carbon::now()->addMinutes(30)->toDateTimeString()])
            ->with('auctionProductPhotos')
            ->get()
            ->toArray();

        $auctionProducts = AuctionProduct::where('end_date', '>', Carbon::now()->toDateTimeString())->where('start_date', '<=', now())->with('auctionProductPhotos')
            ->orderBy('created_at', 'desc')
            ->limit(36)
            ->get()->toArray();

        $auctionLimited30Minutes = array_chunk($auctionLimited30Minutes, 4);
        $auctionProducts = array_chunk($auctionProducts, 4);

        return view('home', compact('auctionProducts', 'auctionLimited30Minutes'))->render();
    }
}
