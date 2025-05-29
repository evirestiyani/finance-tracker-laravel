<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportController extends Controller
{
    public function exportPdf()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
                                   ->orderBy('date', 'desc')
                                   ->get();

        $pdf = PDF::loadView('report.pdf', compact('user', 'transactions'));

        return $pdf->download('laporan_keuangan_'.$user->id.'.pdf');
    }
}
