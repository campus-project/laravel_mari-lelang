<?php

namespace App\Http\Controllers;

use App\Entities\AuctionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * The method handler request for datatable
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $auctionProducts = AuctionProduct::with('city.province', 'createdBy', 'productType', 'auctionProductPhotos')
            ->where('end_date', '>', Carbon::now()->toDateTimeString())->where('start_date', '<=', now())->with('auctionProductPhotos')
                ->orderBy('created_at', 'desc');

        return DataTables::of($auctionProducts)
            ->addIndexColumn()
            ->addColumn('photo', function($row) {
                return '<img class="mr-3 rounded-circle bx-shadow-lg" src="' . $row->auctionProductPhotos[0]->photo_url .'" alt="'. $row->name .'" style="width: 50px; height: 50px;">';
            })
            ->addColumn('start_auction', function($row) {
                return Carbon::parse($row->start_date)->format('d-m-Y');
            })
            ->addColumn('end_auction', function($row) {
                return Carbon::parse($row->end_date)->format('d-m-Y');
            })
            ->addColumn('product_type', function($row) {
                return $row->productType->name;
            })
            ->addColumn('province', function($row) {
                return $row->city->province->name;
            })
            ->addColumn('city', function($row) {
                return $row->city->name;
            })
            ->addColumn('action', function($row) {
                $button = '';
                $button .= '<button type="button" class="btn btn-primary waves-effect waves-light" onclick="bid(' . $row->id . ')">BID</button> ';
                $button .= '<a href="' . route('product.show', ['id' => $row->id]) . '" class="btn btn-secondary waves-effect waves-light">Show</a>';

                return $button;
            })
            ->addColumn('created_by', function($row) {
                return $row->createdBy->name;
            })->rawColumns(['photo', 'action'])->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = AuctionProduct::findOrFail($id);
        $photos = array_chunk($product->auctionProductPhotos()->get()->toArray(), 3);

        return view('products.show', compact('product', 'photos'));
    }
}
