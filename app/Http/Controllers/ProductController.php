<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerMaster;
use App\Models\ProductMaster;
use DataTables;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = ProductMaster::select(['id', 'name','price'])->orderByDesc('id');

            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    return '<a class="btn btn-primary" href="' . route('products.edit', $product->id) . '">Edit</a> 
                            <form method="post" action="' . route('products.destroy', $product->id) . '" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field('delete') . '
                                <button type="submit" class=" btn btn-danger">Delete</button>
                            </form>';
                })
                ->make(true);
        }

        return view('products.index');
    }

    public function create()
    {
        // Show the form to create a new customer
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new customer
        ProductMaster::create([
            'name' => $request->input('name'),
            'price' => $request->input('price')
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        // Show the form to edit an existing customer
        $product = ProductMaster::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the existing customer
        $product = ProductMaster::findOrFail($id);
        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price')
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        // Delete an existing customer
        $product = ProductMaster::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
    public function getProducts()
    {
        $products = CustomerMaster::select(['id', 'name']);

        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '<a href="' . route('products.edit', $product->id) . '">Edit</a> |
                        <form method="post" action="' . route('products.destroy', $product->id) . '" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn-link">Delete</button>
                        </form>';
            })
            ->make(true);
    }
}
