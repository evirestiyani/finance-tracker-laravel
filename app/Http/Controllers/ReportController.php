<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportController extends Controller
{
   public function exportPDF()
{
    $data = Transaction::all(); 
    $pdf = Pdf::loadView('pdf.laporan', compact('data'));
    return $pdf->download('laporan-keuangan.pdf');
}
}
