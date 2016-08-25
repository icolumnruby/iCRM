<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Session;
use Auth;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $brands = Brand::paginate(20);

        return view('brand.index', compact('brands'));
    }

    /**
     * Displays the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $logged_in = Auth::user();
        $brand = Brand::leftJoin('users AS a1', 'brand.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'brand.last_updated_by', '=', 'a2.id')
                ->where([
                    ['brand.id', $id],
                ])
                ->first(['brand.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('brand.show', compact('brand'));
    }

    /**
     * Creates a new brand
     *
     * @return Response
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Create a new brand.
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
            'categoryId' => 'required'
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new contact
            $product = new Brand;
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->category_id = $request->get('categoryId');
            $product->is_activated = $request->get('isActivated');
            $product->created_by = $logged_in->id;
            $product->last_updated_by = $logged_in->id;

            // save new brand
            $product->save();

            Session::flash('flash_message', 'Brand successfully added!');

            $brands = Brand::paginate(20);

            return view('brand.index', compact('brands'));
        }
    }

    public function edit($id) {
        $brand = Brand::leftJoin('users AS a1', 'brand.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'brand.last_updated_by', '=', 'a2.id')
                ->where([
                    ['brand.id', $id],
                    ['brand.deleted_at', NULL],
                    ['a1.is_active', 'Y']
                ])
                ->first(['brand.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing branch
        $brand = Brand::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $brand->name = $request->get('name');
            $brand->description = $request->get('description');
            $brand->category_id = $request->get('categoryId');
            $brand->is_activated = $request->get('isActivated') != 'Y' ? 'N' : 'Y';
            $brand->last_updated_by = $logged_in->id;

            // save new meta
            $brand->save();

            Session::flash('flash_message', "Brand with ID $id successfully updated!");

            return redirect()->route('brand.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $logged_in = Auth::user();
        $brand = Brand::findOrFail($id);

        //update last_updated_by before deleting
        $brand->last_updated_by = $logged_in->id;
        $brand->save();

        $brand->delete();

        Session::flash('flash_message', "Brand with ID $id successfully deleted!");

        return redirect()->route('brand.index');
    }
}
