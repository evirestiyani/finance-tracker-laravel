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
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $query = Transaction::with('category')
            ->where('user_id', $userId);
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    })
                    ->orWhere('type', 'like', "%$search%");
            });
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(10);

        $categories = Category::all();

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

        $expensePerMonth = Transaction::select(
            DB::raw("DATE_FORMAT(date, '%b') as month"),
            DB::raw("SUM(amount) as total")
        )
            ->where('user_id', $userId)
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
            'user',
            'categories',
            'transactions',
            'balance',
            'recentTransactions',
            'totalIncome',
            'totalExpense',
            'totalTransactions',
            'months',
            'incomeData',
            'expenseData'
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
                'icon' => '',
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

    public function edit($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $categories = Category::where('user_id', auth()->id())->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $categoryId = $request->category_id;

        if ($request->filled('new_category')) {
            $newCategory = Category::create([
                'name' => $request->new_category,
                'icon' => '', // optional
                'user_id' => auth()->id(),
            ]);
            $categoryId = $newCategory->id;
        }

        $transaction->update([
            'type' => $request->type,
            'category_id' => $categoryId,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $transaction->delete();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus!');
    }
}
