<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\Country;
use App\Models\Product;
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

        $txns = Transaction::select('transactions.*', 'contacts.firstname', 'contacts.lastname', 'products.name')
                ->leftJoin('contacts', 'contacts.id', '=', 'transactions.contact_id')
                ->leftJoin('products', 'products.id', '=', 'transactions.product_id')
                ->where([
                        ['contacts.company_id', $logged_in->company_id]
                    ])
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
     * @param int $contactId
     * @return Response
     */
    public function create($contactId)
    {
        $contact = Contact::find($contactId);
        $countries = Country::all();

        return view('transaction.create', compact('contact', 'countries'));
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
            $txn->contact_id = $request->get('contactId');
            $txn->product_id = $request->get('productId');
            $txn->amount = $request->get('amount');
            $txn->payment_mode = $request->get('paymentMode');
            $txn->payment_type = $request->get('paymentType');
            $txn->transaction_no = $txn_no;
            $txn->remarks = $request->get('remarks');
            $txn->status = $request->get('status');
            $txn->created_by = $logged_in->id;

            // save new contact
            $txn->save();

            Session::flash('flash_message', 'Transaction successfully added!');

            $txns = Transaction::all();

            return view('transaction.index', compact('txns'));
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
        $txns = Transaction::withTrashed()->with('contact')
                ->leftJoin('products', 'products.id', '=', 'transactions.product_id')
                ->find($id);
        $txn = Transaction::select('transactions.*', 'contacts.firstname', 'contacts.lastname', 'products.name')
                ->leftJoin('contacts', 'contacts.id', '=', 'transactions.contact_id')
                ->leftJoin('products', 'products.id', '=', 'transactions.product_id')
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
        $txn = Transaction::with('contact')->find($id);
        $countries = Country::all();

        return view('transaction.edit', compact('txn', 'countries'));
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

        $txn->contact_id = $request->get('contactId');
        $txn->product_id = $request->get('productId');
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

        Session::flash('flash_message', "Transaction with ID $id successfully updated!");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer $contact
     * @param  \App\Transaction $transaction
     * @return Response
     */
    public function destroy($id)
    {
        $txn = Transaction::findOrFail($id);

//        $contact->deletedByUserId = '';

        $txn->delete();

        Session::flash('flash_message', "Transaction with ID $id successfully deleted!");

        return redirect()->route('transaction.index');
    }

}
