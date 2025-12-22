<?php



namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('transaction_date', 'desc')->get();

        return view('admin.invoices.index', compact('transactions'));
    }

    public function invoice_generate($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.invoices.invoice-generate', compact('transaction',));
    }
}
