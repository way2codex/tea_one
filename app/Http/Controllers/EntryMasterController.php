<?php

namespace App\Http\Controllers;

use App\Models\CustomerMaster;
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
                    if($model->customer != null){
                        return $model->customer['name'];
                    }else{
                        return CustomerMaster::where('id',$model->customer_id)->withTrashed()->first()['name'];
                    }
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
