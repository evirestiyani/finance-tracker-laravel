<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id; // *** Jangan lupa definisikan $userId ***

        $categories = Category::all();
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        $totalTransactions = Transaction::where('user_id', $userId)->count();

        // Ambil total income per bulan selama 12 bulan terakhir
        $incomePerMonth = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%b') as month"),
                DB::raw("SUM(amount) as total")
            )
            ->where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [Carbon::now()->subYear()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(date)"))
            ->get();

        // Ambil total expense per bulan selama 12 bulan terakhir
        $expensePerMonth = Transaction::select(
                DB::raw("DATE_FORMAT(date, '%b') as month"),
                DB::raw("SUM(amount) as total")
            )
            ->where('user_id', $userId) // *** harus sama: $userId ***
            ->where('type', 'expense')
            ->whereBetween('date', [Carbon::now()->subYear()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(date)"))
            ->get();

        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

        $incomeData = $months->map(function ($month) use ($incomePerMonth) {
            $record = $incomePerMonth->firstWhere('month', $month);
            return $record ? (float)$record->total : 0;
        });

        $expenseData = $months->map(function ($month) use ($expensePerMonth) {
            $record = $expensePerMonth->firstWhere('month', $month);
            return $record ? (float)$record->total : 0;
        });

        return view('dashboard', compact(
            'user', 'categories', 'transactions', 'balance', 
            'recentTransactions', 'totalIncome', 'totalExpense', 
            'totalTransactions', 'months', 'incomeData', 'expenseData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $categoryId = $request->category_id;

        if ($request->filled('new_category')) {
            $newCategory = Category::create([
                'name' => $request->new_category,
                'icon' => '', // optional
                'user_id' => auth()->id(),
            ]);
            $categoryId = $newCategory->id;
        }

        $transaction = new Transaction();
        $transaction->type = $request->type;
        $transaction->category_id = $categoryId;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->user_id = auth()->id();
        $transaction->date = $request->date;
        $transaction->save();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }
}
