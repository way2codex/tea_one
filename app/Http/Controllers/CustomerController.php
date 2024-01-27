<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerMaster;
use DataTables;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = CustomerMaster::select(['id', 'name'])->orderByDesc('id');

            return DataTables::of($customers)
                ->addColumn('action', function ($customer) {
                    return '<a class="btn btn-primary" href="' . route('customers.edit', $customer->id) . '">Edit</a> 
                            <form method="post" action="' . route('customers.destroy', $customer->id) . '" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field('delete') . '
                                <button type="submit" class=" btn btn-danger">Delete</button>
                            </form>';
                })
                ->make(true);
        }

        return view('customers.index');
    }

    public function create()
    {
        // Show the form to create a new customer
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new customer
        CustomerMaster::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    public function edit($id)
    {
        // Show the form to edit an existing customer
        $customer = CustomerMaster::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the existing customer
        $customer = CustomerMaster::findOrFail($id);
        $customer->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        // Delete an existing customer
        $customer = CustomerMaster::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
    public function getCustomers()
    {
        $customers = CustomerMaster::select(['id', 'name']);

        return DataTables::of($customers)
            ->addColumn('action', function ($customer) {
                return '<a href="' . route('customers.edit', $customer->id) . '">Edit</a> |
                        <form method="post" action="' . route('customers.destroy', $customer->id) . '" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field('delete') . '
                            <button type="submit" class="btn-link">Delete</button>
                        </form>';
            })
            ->make(true);
    }
}
