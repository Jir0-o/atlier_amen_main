<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Contract;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Can Access Contact')->only('index', 'store');
        $this->middleware('permission:Can Access Contact Messages')->only('Adminindex', 'Adminshow', 'Admindestroy');
    }
    public function index()
    {
        $contract = Contract::first();
        return view('backend.contract.contract', compact('contract'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'poem'             => 'nullable|string',
        ]);

        $contract = Contract::firstOrNew(['id' => 1]);

        // Handle Background Image
        if ($request->hasFile('background_image')) {
            $destination = public_path('uploads/contract');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($contract->background_image && file_exists(public_path($contract->background_image))) {
                unlink(public_path($contract->background_image));
            }

            $bgFilename = uniqid('bg_') . '.' . $request->file('background_image')->getClientOriginalExtension();
            $request->file('background_image')->move($destination, $bgFilename);
            $validated['background_image'] = 'uploads/contract/' . $bgFilename;
        }

        // Handle User Image
        if ($request->hasFile('user_image')) {
            $destination = public_path('uploads/contract');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($contract->user_image && file_exists(public_path($contract->user_image))) {
                unlink(public_path($contract->user_image));
            }

            $userFilename = uniqid('user_') . '.' . $request->file('user_image')->getClientOriginalExtension();
            $request->file('user_image')->move($destination, $userFilename);
            $validated['user_image'] = 'uploads/contract/' . $userFilename;
        }

        $contract->fill($validated)->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Contract saved successfully!',
        ]);
    }

    public function Adminindex(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactMessage::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('message', function ($row) {
                    // Shorten for table
                    return str($row->message)->limit(40)->toString();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('Y-m-d H:i');
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-info btn-sm viewBtn" data-id="'.$row->id.'">View</button>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.contact-messages.index');
    }

    /**
     * Return a single message as JSON for modal view.
     */
    public function Adminshow($id)
    {
        $msg = ContactMessage::findOrFail($id);

        return response()->json([
            'id'         => $msg->id,
            'name'       => $msg->name,
            'email'      => $msg->email,
            'number'     => $msg->number,
            'message'    => $msg->message,
            'ip_address' => $msg->ip_address,
            'user_agent' => $msg->user_agent,
            'created_at' => optional($msg->created_at)->format('Y-m-d H:i:s'),
        ]);
    }

    public function Admindestroy($id)
    {
        ContactMessage::findOrFail($id)->delete();

        return response()->json(['message' => 'Message deleted successfully.']);
    }
}
