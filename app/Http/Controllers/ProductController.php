<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Products[]|\Illuminate\Database\Eloquent\Collection|Response
     */
    public function index()
    {
        return Products::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Products
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $product = new Products();

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response('Products Not Found', 404);
        }

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response('Products Not Found', 404);
        }

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response('Product Not Found', 404);
        }

        $product->delete();

        return "Product Removed successfully";
    }

    /**
     * Search for product by name
     *
     * @param str $name
     * @return Response
     */
    public function search($name)
    {
        $product = Products::where('name', 'like', '%' . $name . '%')->get();

        return $product;
    }
}
