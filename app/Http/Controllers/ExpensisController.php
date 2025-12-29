<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Department;

class ExpensisController extends Controller
{
    // ================= LIST =================
    public function index()
    {
        $expenses = Expenses::with('department')->latest()->paginate(10);
        return view('admin.expensis.index', compact('expenses'));
    }

    // ================= CREATE FORM =================
    public function create()
    {
        $departments = Department::where('status', 1)->get();
        return view('admin.expensis.create', compact('departments'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'amount' => 'required|numeric|min:0',
        ]);

        Expenses::create([
            'uid' => 'EXP-' . now()->format('YmdHis'),
            'date' => $request->date,
            'reason' => $request->reason,
            'department_id' => $request->department_id,
            'amount' => $request->amount,
            'added_by' => 'Admin',
        ]);

     return redirect()->route('admin.expensis.index')
    ->with('success', 'Expense added successfully');
    }

    // ================= EDIT FORM =================
    public function edit($id)
    {
        $expense = Expenses::findOrFail($id);
        $departments = Department::where('status', 1)->get();
        return view('admin.expensis.edit', compact('expense', 'departments'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense = Expenses::findOrFail($id);

        $expense->update([
            'date' => $request->date,
            'reason' => $request->reason,
            'department_id' => $request->department_id,
            'amount' => $request->amount,
        ]);

       return redirect()->route('admin.expensis.index')
    ->with('success', 'Expense updated successfully');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $expense = Expenses::findOrFail($id);
        $expense->delete();

     return redirect()->route('admin.expensis.index')
    ->with('success', 'Expense deleted successfully');

    }
}
