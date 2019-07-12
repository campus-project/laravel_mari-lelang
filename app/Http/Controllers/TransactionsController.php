<?php

namespace App\Http\Controllers;

use App\Entities\Transaction;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TransactionRepository;
use App\Validators\TransactionValidator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class TransactionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TransactionsController extends Controller
{
    /**
     * @var TransactionRepository
     */
    protected $repository;

    /**
     * @var TransactionValidator
     */
    protected $validator;

    /**
     * TransactionsController constructor.
     *
     * @param TransactionRepository $repository
     * @param TransactionValidator $validator
     */
    public function __construct(TransactionRepository $repository, TransactionValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * The method handler request for datatable
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('date', function($row) {
                return Carbon::parse($row->start_date)->format('d-m-Y');
            })
            ->addColumn('amount', function($row) {
                return number_format($row->amount, 2);
            })
            ->addColumn('status', function($row) {
                $badge = '';
                switch ($row->status) {
                    case 'On Process':
                        $badge = '<span class="badge badge-pill badge-warning">' . $row->status . '</span>';
                        break;
                    case 'Success':
                        $badge = '<span class="badge badge-pill badge-success">' . $row->status . '</span>';
                        break;
                    case 'Bid':
                        $badge = '<span class="badge badge-pill badge-warning">' . $row->status . '</span>';
                        break;
                    default:
                        $badge = '<span class="badge badge-pill badge-danger">Failed</span>';
                        break;
                }

                return $badge;
            })
            ->rawColumns(['status'])->toJson();
    }

}
