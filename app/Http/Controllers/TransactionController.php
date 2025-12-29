<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Apply filters
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        // Apply sorting
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('transaction_date', 'asc');
                break;
            case 'amount_high':
                $query->orderBy('amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('amount', 'asc');
                break;
            default:
                $query->orderBy('transaction_date', 'desc');
                break;
        }

        $transactions = $query->get();

        return view('admin.accountant.index', compact('transactions'));
    }



    public function create()
    {
        return view('admin.accountant.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required|in:patients,doctors,nurses,blood_bank,employee,services,lab,reception,accountant,pharmacy',
            'amount' => 'required|numeric|min:0',
            'transaction_type' => 'required|in:credit,debit',
            'payment_mode' => 'required|in:cash,upi,card,online,cheque',
            'status' => 'required|in:paid,pending,cancelled,refunded',
            'transaction_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        // Generate a unique random transaction ID
        $transactionId = 'TXN-' . strtoupper(uniqid());

        Transaction::create([
            'transaction_id' => $transactionId,
            'module' => $request->module,
            'amount' => $request->amount,
            'transaction_type' => $request->transaction_type,
            'payment_mode' => $request->payment_mode,
            'status' => $request->status,
            'transaction_date' => $request->transaction_date,
            'remarks' => $request->remarks,
            'created_by' => auth()->id(), // ✅ Logged-in accountant
        ]);

        return redirect()
            ->route('admin.transctions.index')
            ->with('success', 'Transaction added successfully with ID: ' . $transactionId);
    }
}
