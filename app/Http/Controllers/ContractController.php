<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('client')
            ->latest()
            ->paginate(10);

        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $clients = Client::all();

        return view('contracts.create', compact('clients'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'car_name' => 'required',
            'car_price' => 'required|numeric',
            'interest_value' => 'required|numeric',
            'installments_count' => 'required|integer|min:1',
            'start_date' => 'required|date',
        ]);

        $totalAmount =
            $request->car_price +
            $request->interest_value;

        $installmentAmount =
            $totalAmount /
            $request->installments_count;

        $contract = Contract::create([
            'client_id' => $request->client_id,
            'car_name' => $request->car_name,
            'car_price' => $request->car_price,
            'interest_value' => $request->interest_value,
            'total_amount' => $totalAmount,
            'installments_count' => $request->installments_count,
            'installment_amount' => $installmentAmount,
            'start_date' => $request->start_date,
            'status' => 'active',
        ]);

        for ($i = 1; $i <= $request->installments_count; $i++) {

            Installment::create([
                'contract_id' => $contract->id,
                'installment_number' => $i,
                'amount' => $installmentAmount,
                'due_date' => Carbon::parse(
                    $request->start_date
                )->addMonths($i - 1),
                'status' => 'pending'
            ]);
        }

        return redirect()
            ->route('contracts.index')
            ->with('success', 'تم إنشاء العقد بنجاح');
    }

    public function show(Contract $contract)
    {
        $contract->load([
            'client',
            'installments.payments'
        ]);

        $paid = $contract->installments->sum('payments.amount');

        $remaining =
            $contract->total_amount - $paid;

        return view('contracts.show', compact('contract', 'paid', 'remaining'));
    }

    public function edit(Contract $contract)
{
    $clients = Client::all();

    return view(
        'contracts.edit',
        compact('contract','clients')
    );
}

public function update(Request $request, Contract $contract)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'car_name' => 'required',
        'car_price' => 'required|numeric',
        'interest_value' => 'required|numeric',
        'installments_count' => 'required|integer|min:1',
        'start_date' => 'required|date',
    ]);

    $totalAmount =
        $request->car_price +
        $request->interest_value;

    $installmentAmount =
        $totalAmount /
        $request->installments_count;

    $contract->update([
        'client_id' => $request->client_id,
        'car_name' => $request->car_name,
        'car_price' => $request->car_price,
        'interest_value' => $request->interest_value,
        'total_amount' => $totalAmount,
        'installments_count' => $request->installments_count,
        'installment_amount' => $installmentAmount,
        'start_date' => $request->start_date,
    ]);

    return redirect()
        ->route('contracts.index')
        ->with('success', 'تم تعديل العقد بنجاح');
}

    public function updateInstallments(Request $request, Contract $contract)
    {
        foreach ($contract->installments as $installment) {

            $installment->status = 'pending'; 

            $totalPaid = $installment->payments()->sum('amount');

            if ($totalPaid >= $installment->amount) {

                $installment->status = 'paid';

            } elseif ($totalPaid > 0) {

                $installment->status = 'partial';

            } elseif (Carbon::parse($installment->due_date)->isPast()) {

                $installment->status = 'overdue';

            }

            $installment->save();
        }

        // تحديث حالة العقد
        if ($contract->installments->where('status', '!=', 'paid')->isEmpty()) {
            $contract->status = 'paid';
        } else {
            $contract->status = 'active';
        }
        $contract->save();

        return back()->with(
            'success',
            'تم تحديث حالة الأقساط بنجاح'
        );
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();

        return back()->with(
            'success',
            'تم حذف العقد'
        );
    }
}