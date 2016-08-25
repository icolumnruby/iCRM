<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Contact;
use Session;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $logged_in = Auth::user();
        $products = Product::where([
//                    ['products.branch_id', $logged_in->company_id],
                ])
                ->paginate(20);

        return view('product.index', compact('products'));
    }

    /**
     * Creates a new product
     *
     * @return Response
     */
    public function create()
    {
        return view('product.create', compact('products'));
    }

    /**
     * Create a new product.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $logged_in = Auth::user();
        //validate required fields
        $v = $this->validate($request, [
            'name' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new product
            $product = new Product;
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->sku_no = $request->get('skuNo');
            $product->quantity = $request->get('quantity');
            $product->branch_id = $request->get('branchId');
            $product->created_by = $logged_in->id;

            // save new product
            $product->save();

            Session::flash('flash_message', 'Product successfully added!');

            return redirect()->route('product.index');
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
        $logged_in = Auth::user();
        $product = Product::find($id);
        $contact = Contact::leftJoin('products AS a1', 'contacts.created_by', '=', 'a1.id')
                ->leftJoin('products AS a2', 'contacts.last_updated_by', '=', 'a2.id')
                ->where([
                    ['contacts.id', $id],
                ])
                ->first(['contacts.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('product.show', compact('contact', 'product'));
    }

    public function edit($id) {
        $product = Product::find($id);

        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing user
        $product = Product::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->sku_no = $request->get('sku_no');
            $product->quantity = $request->get('quantity');
            $product->branch_id = $request->get('branch_id');
            $product->is_activated = $request->get('is_activated');
            $product->last_updated_by = $logged_in->id;

            // save new meta
            $product->save();

            Session::flash('flash_message', 'Product successfully updated!');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id) {
        $logged_in = Auth::user();
        $product = Product::findOrFail($id);

        //update last_updated_by before deleting
        $product->last_updated_by = $logged_in->id;
        $product->save();

        $product->delete();

        Session::flash('flash_message', 'Product successfully deleted!');

        return redirect()->route('product.index');
    }
}
