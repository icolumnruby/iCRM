<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\ProductCategory;
use App\Models\Country;
use App\Models\PaymentType;
use App\Models\MemberPoints;
use App\Models\MemberPointsTxn;
use App\Models\LoyaltyConfig;
use Response;
use Session;
use Auth;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $logged_in = Auth::user();

        $txns = Transaction::select('transactions.*', 'members.firstname',
                    'members.lastname', 'product_category.name AS name', 'payment_type.name as payment_type')
                ->leftJoin('members', 'members.id', '=', 'transactions.member_id')
                ->leftJoin('product_category', 'product_category.id', '=', 'transactions.product_category_id')
                ->leftJoin('payment_type', 'payment_type.id', '=', 'transactions.payment_type')
                ->where([
                        ['members.company_id', $logged_in->company_id]
                    ])
                ->orderBy('transactions.created_at', 'desc')
                ->paginate(20);

        return view('transaction.index', compact('txns'));
    }

    /**
     * Search for product
     *
     * @param Response
     */
    public function searchProduct(Request $request)
    {
        $logged_in = Auth::user();
        $keyword = $request->get('search');

        $products = Product::whereRaw(
                    "products.name like '%$keyword%'"
                )
                ->get(['products.name', 'products.id']);

        if($request->ajax()){
            return Response::json($products);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $memberId
     * @return Response
     */
    public function create($memberId)
    {
        $member = Member::find($memberId);
        $countries = Country::all();
        $categories = ProductCategory::where([
                ['is_active', 'Y']
                ])->get();
        $paymentType = PaymentType::where([
                ['is_active', 'Y']
                ])->get();

        //get the member's loyalty points
        $totalPoints = MemberPoints::_getPoints($member->id);

        return view('transaction.create', compact('member', 'countries', 'categories', 'paymentType', 'totalPoints'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $request
     * @return Response
     */
    public function store(Request $request)
    {
        $logged_in = Auth::user();
        //validate required fields
        $v = $this->validate($request, [
            'amount' => 'required'
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $txn_no = sprintf("%06d", mt_rand(1, 999999)) . date('YmdHis');
            // create the data for new transaction
            $txn = new Transaction;
            $txn->member_id = $request->get('memberId');
            $txn->product_category_id = $request->get('productCategoryId');
            $txn->amount = $request->get('amount');
            $txn->payment_type = $request->get('paymentType');
            $txn->transaction_no = $txn_no;
            $txn->remarks = $request->get('remarks');
            $txn->status = $request->get('status');
            $txn->created_by = $logged_in->id;
            $txn->last_updated_by = $logged_in->id;

            // save new member
            $txn->save();

            //check if there are equivalent points conversion for member with type = purchase
            $member = Member::find($request->get('memberId'));
            $loyaltyConfig = LoyaltyConfig::where([
                    ['company_id', $member->company_id],
                    ['start_date', '<=', date('Y-m-d H:i:s')],
                    ['end_date', '>=', date('Y-m-d H:i:s')],
                    ['is_active', 'Y'],
                    ['member_type_id', $member->member_type_id],
                    ['action_id', 1]  //purchase
                ])->get();

            $totalAmount = $request->get('amount');
            $totalPoints = 0;
            // (total amount / value) * points, by member_type
            foreach ($loyaltyConfig as $config) {
                $value = $config->value;
                $points = $config->points;
                $pointsEarned = ($totalAmount / $value) * $points;
                $totalPoints += ceil($pointsEarned);

                //save member points
                $memberTotalPoints = MemberPoints::_getPoints($member->id);  //get the member's loyalty points
                $memberPoints = new MemberPoints;
                $memberPoints->member_id = $request->get('memberId');
                $memberPoints->points = ceil($pointsEarned);
                $memberPoints->points_balance = ceil($pointsEarned) + $memberTotalPoints;
                $memberPoints->created_by = $logged_in->id;
                $memberPoints->last_updated_by = $logged_in->id;

                $memberPoints->save();

                //save member points transaction
                $memberPointsTxn = new MemberPointsTxn;
                $memberPointsTxn->member_id = $request->get('memberId');
                $memberPointsTxn->loyalty_config_id = $config->id;
                $memberPointsTxn->member_points_id = $memberPoints->id;
                $memberPointsTxn->points = ceil($pointsEarned);
                $memberPointsTxn->expiry = $config->expiry;
                $memberPointsTxn->created_by = $logged_in->id;
                $memberPointsTxn->last_updated_by = $logged_in->id;

                $memberPointsTxn->save();
            }

            Session::flash('flash_message', "Transaction successfully added! Member points earned: $totalPoints.");

            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $txn = Transaction::select('transactions.*', 'payment_type.name AS paymentType', 'members.firstname', 'members.lastname')
                ->leftJoin('members', 'members.id', '=', 'transactions.member_id')
                ->leftJoin('payment_type', 'payment_type.id', '=', 'transactions.payment_type')
                ->find($id);

        return view('transaction.show', compact('txn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $txn = Transaction::with('member')->find($id);
        $countries = Country::all();
        $categories = ProductCategory::where([
                ['is_active', 'Y']
                ])->get();
        $paymentType = PaymentType::where([
                ['is_active', 'Y']
                ])->get();

        return view('transaction.edit', compact('txn', 'countries', 'categories', 'paymentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // update existing user
        $txn  = Transaction::find($id);

        $txn->member_id = $request->get('memberId');
        $txn->product_category_id = $request->get('productCategoryId');
        $txn->sku_no = $request->get('skuNo');
        $txn->brand = $request->get('brand');
        $txn->amount = $request->get('amount');
        $txn->currency = $request->get('currency');
        $txn->payment_mode = $request->get('paymentMode');
        $txn->payment_type = $request->get('paymentType');
        $txn->transaction_no = $request->get('txnNo');
        $txn->remarks = $request->get('remarks');
        $txn->status = $request->get('status');

        // save new transaction
        $txn->save();

        Session::flash('flash_message', "Transaction with ID $id was successfully updated!");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer $member
     * @param  \App\Transaction $transaction
     * @return Response
     */
    public function destroy($id)
    {
        $txn = Transaction::findOrFail($id);

//        $member->deletedByUserId = '';

        $txn->delete();

        Session::flash('flash_message', "Transaction with ID $id successfully deleted!");

        return redirect()->route('transaction.index');
    }

}
