<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Member;
use Auth;
use Session;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $logged_in = Auth::user();
        $categories = ProductCategory::where([
//                    ['products.branch_id', $logged_in->company_id],
                ])
                ->paginate(20);

        return view('product.category', compact('categories'));
    }

    /**
     * Creates a new product
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();

        return view('product.create-category', compact('user'));
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
            'companyId' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new product
            $productCat = new ProductCategory;
            $productCat->name = $request->get('name');
            $productCat->description = $request->get('description');
            $productCat->company_id = $request->get('companyId');
            $productCat->is_active = $request->get('isActivated') == 'Y' ? 'Y' : 'N';
            $productCat->created_by = $logged_in->id;

            // save new product
            $productCat->save();

            Session::flash('flash_message', "Product Category with ID ". $productCat->id ." was successfully added!");

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
        $logged_in = Auth::user();
        $productCat = ProductCategory::find($id);
        $member = Member::leftJoin('product_category AS a1', 'members.created_by', '=', 'a1.id')
                ->leftJoin('product_category AS a2', 'members.last_updated_by', '=', 'a2.id')
                ->where([
                    ['members.id', $logged_in->id],
                ])
                ->first(['members.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('product.view-category', compact('member', 'productCat'));
    }

    public function edit($id) {
        $productCat = ProductCategory::find($id);

        return view('product.edit-category', compact('productCat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing user
        $productCat = ProductCategory::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $productCat->name = $request->get('name');
            $productCat->description = $request->get('description');
            $productCat->is_active = $request->get('isActivated') == 'Y' ? 'Y' : 'N';
            $productCat->last_updated_by = $logged_in->id;

            // save new meta
            $productCat->save();

            Session::flash('flash_message', "Product Category with ID $id was successfully updated!");

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
        $productCat = ProductCategory::findOrFail($id);

        //update last_updated_by before deleting
        $productCat->last_updated_by = $logged_in->id;
        $productCat->save();

        $productCat->delete();

        Session::flash('flash_message', 'Product Category successfully deleted!');

        return $this->index();
    }
}
