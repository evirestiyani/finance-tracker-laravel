<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();
        $totalIncome = DB::table('transactions')->where('type', 'income')->sum('amount');
        $totalExpense = DB::table('transactions')->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $recentTransactions = Transaction::orderBy('date', 'desc')->limit(5)->get();

        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');

        $totalTransactions = Transaction::where('user_id', $user->id)->count();

        return view('dashboard', compact('user', 'categories', 'transactions', 'balance', 'recentTransactions', 'totalIncome', 'totalExpense', 'totalTransactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan.');
    }
}
