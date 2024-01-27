<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntryMaster;
use DataTables;

class EntryMasterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $entries = EntryMaster::with('customer')
                ->orderByDesc('id')->get();
            return DataTables::of($entries)
                ->addColumn('action', function ($entry) {
                    return '<form method="post" action="' . route('entries.destroy', $entry->id) . '" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field('delete') . '
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>';
                })
                ->addColumn('customer_name', function ($model) {
                    // dd($model);
                    return $model->customer['name'];
                })
                ->make(true);
        }

        return view('entry.index');
    }

    public function destroy(EntryMaster $entry)
    {
        $entry->delete();
        return redirect()->route('entries.index')->with('success', 'Entry deleted successfully.');
    }
}
