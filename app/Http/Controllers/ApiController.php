<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerMaster;
use App\Models\EntryMaster;
use Carbon\Carbon;
use PDF;

class ApiController extends Controller
{
    public function customer_list()
    {
        $customers = CustomerMaster::get();
        return response()->json($customers);
    }
    public function store_entry(Request $request)
    {
        $date = Carbon::now();
        $entry_time = $date->format('Y-m-d H:i:s');
        $EntryMaster = new EntryMaster();
        $EntryMaster->customer_id = $request->customer_id;
        $EntryMaster->entry_time = $entry_time;
        $EntryMaster->product_id = 1;
        $EntryMaster->quantity = $request->quantity;
        $EntryMaster->save();

        return response()->json($EntryMaster);
    }
    public function entry_report(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'customer_id' => 'required|integer',
        ]);
        $data = EntryMaster::where('customer_id', $request->customer_id)
            ->whereBetween('entry_time', [$request->from_date, $request->to_date])
            ->with('customer')
            ->orderBy('entry_time','asc')
            ->get()
            ->transform(function ($item) {
                $item->entry_time = \Carbon\Carbon::parse($item->entry_time);
                return $item;
            });
        if (count($data) > 0) {
            $fromDate = Carbon::parse($request->from_date)->format('d-m-Y');
            $toDate = Carbon::parse($request->to_date)->format('d-m-Y');
            $customerName = $data->first()->customer->name; // Adjust 'name' to the actual attribute in your Customer model
            $pdf = PDF::loadView(
                'pdf.template',
                [
                    'data' => $data,
                    'customerName' => $customerName,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate
                ]
            );
            $pdfPath = 'pdf/' . uniqid() . '.pdf';
            $pdf->save(storage_path('app/public/' . $pdfPath));
            return response()->json(['pdf_url' => asset('storage/' . $pdfPath), 'status' => 'true']);
        } else {
            return response()->json(['status' => 'empty']);
        }
    }
}