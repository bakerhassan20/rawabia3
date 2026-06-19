<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Installment;
use App\Models\Payment;
use App\Models\Client;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'installment.contract.client'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'payments.index',
            compact('payments')
        );
    }

   public function create()
    {
        $contracts = Contract::with('client')
            ->latest()
            ->get();

        return view(
            'payments.create',
            compact('contracts')
        );
    }

        public function store(Request $request)
        {
            $request->validate([
                'installment_id' => 'required|exists:installments,id',
                'amount' => 'required|numeric|min:1',
                'payment_date' => 'required|date'
            ]);

            $payment = Payment::create([
                'installment_id' => $request->installment_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes,
            ]);

            $installment = $payment->installment;
            $this->updateInstallmentStatus($installment);

            return redirect()
                ->route('payments.index')
                ->with('success', 'تم تسجيل الدفعة');
        }

public function getInstallments($contractId)
{
    $installments = Installment::where('contract_id', $contractId)
        ->where('status', '!=', 'paid')
        ->get()
        ->map(function ($installment) {

            $paid = $installment->payments()->sum('amount');

            return [
                'id' => $installment->id,
                'installment_number' => $installment->installment_number,
                'amount' => $installment->amount,
                'remaining' => $installment->amount - $paid,
            ];
        });

    return response()->json($installments);
}

    public function edit(Payment $payment)
    {
        $installments = Installment::where(
        'status',
        '!=',
        'paid'
    )->get();
        return view('payments.edit', compact('payment','installments'));
    }

public function update(Request $request, Payment $payment)
{
    $request->validate([
        'installment_id' => 'required|exists:installments,id',
        'amount' => 'required|numeric|min:1',
        'payment_date' => 'required|date',
        'notes' => 'nullable'
    ]);

    $payment->update([
        'installment_id' => $request->installment_id,
        'amount' => $request->amount,
        'payment_date' => $request->payment_date,
        'notes' => $request->notes,
    ]);

    $this->updateInstallmentStatus($payment->installment);

    return redirect()
        ->route('payments.index')
        ->with('success', 'تم تعديل الدفعة بنجاح');
}
    public function destroy(Payment $payment)
    {
        $installment = $payment->installment;
        $payment->delete();
        $this->updateInstallmentStatus($installment);

        return back()->with('success', 'تم حذف الدفعة');
    }


    private function updateInstallmentStatus(Installment $installment)
    {
        $paid = $installment->payments()->sum('amount');

        if ($paid >= $installment->amount) {
            $status = 'paid';
        } elseif ($paid > 0) {
            $status = 'partial';
        } else {
            $status = 'pending';
        }

        $installment->update([
            'status' => $status
        ]);
    }
    public function print(Payment $payment)
    {
        
        return view('payments.print', compact('payment'));
    }
}