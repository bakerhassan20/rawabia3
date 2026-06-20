<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Installment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    
    {

        $totalCarPrice = Contract::sum('car_price');

        $totalInterest = Contract::sum('interest_value');

        $totalReceivable = Contract::sum('total_amount');

        $totalCollected = Payment::sum('amount');

        $totalRemaining = $totalReceivable - $totalCollected;



        $totalClients = Client::count();

        $totalContracts = Contract::count();

        $totalPaid = Payment::sum('amount');

        $totalContractsAmount = Contract::sum('total_amount');

        $totalRemaining =
            $totalContractsAmount - $totalPaid;

        $paidInstallments =
            Installment::where('status', 'paid')->count();

        $pendingInstallments =
            Installment::where('status', 'pending')->count();

        $overdueInstallments =
            Installment::where('status', 'overdue')->count();

        $latestClients = Client::latest()
            ->take(5)
            ->get();

        $latestPayments = Payment::with([
            'installment.contract.client'
        ])
        ->latest()
        ->take(5)
        ->get();

        $latestOverdues = Installment::with([
            'contract.client'
        ])
        ->where('status', 'overdue')
        ->latest()
        ->take(5)
        ->get();

        $monthlyRevenue = Payment::select(
            DB::raw('MONTH(payment_date) as month'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        return view('dashboard.index', compact(
            'totalClients',
            'totalContracts',
            'totalPaid',
            'totalRemaining',
            'paidInstallments',
            'pendingInstallments',
            'overdueInstallments',
            'latestClients',
            'latestPayments',
            'latestOverdues',
            'monthlyRevenue',
            
            'totalCarPrice',
            'totalInterest',
            'totalReceivable',
            'totalCollected',
            'totalRemaining',
        ));
    }
}