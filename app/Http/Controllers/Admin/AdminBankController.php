<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminBankAccount;

class AdminBankController extends Controller
{
    public function index()
    {
        $accounts = AdminBankAccount::latest()->get();
        return view('AdminDashboard.Bank.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'branch' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'is_default' => 'required|in:0,1',
        ]);

        // If default selected → remove previous defaults
        if ($request->is_default == 1) {
            AdminBankAccount::query()->update(['is_default' => 0]);
        }

        AdminBankAccount::create([
            'bank_name' => $request->bank_name,
            'branch' => $request->branch,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'is_default' => $request->is_default,
        ]);

        return back()->with('success', 'Bank account created successfully');
    }

    public function update(Request $request, $id)
    {
        $account = AdminBankAccount::findOrFail($id);

        $request->validate([
            'bank_name' => 'required',
            'branch' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'is_default' => 'required|in:0,1',
        ]);

        if ($request->is_default == 1) {
            AdminBankAccount::query()->update(['is_default' => 0]);
        }

        $account->update([
            'bank_name' => $request->bank_name,
            'branch' => $request->branch,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'is_default' => $request->is_default,
        ]);

        return back()->with('success', 'Bank account updated successfully');
    }

    public function destroy($id)
    {
        AdminBankAccount::findOrFail($id)->delete();

        return back()->with('success', 'Bank account deleted successfully');
    }
}