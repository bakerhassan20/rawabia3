<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سند قبض</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
            padding: 40px;
        }

        .receipt {
            max-width: 700px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .row {
            margin-bottom: 12px;
            font-size: 16px;
        }

        .label {
            font-weight: bold;
        }

        .box {
            border: 1px solid #000;
            padding: 15px;
            margin-top: 20px;
        }

        .print-btn {
            margin-bottom: 20px;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #000;
            background: #fff;
            cursor: pointer;
        }

        @media print {
            .print-btn {
                display: none;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>

<div class="receipt">

    <div class="print-btn">
        <button onclick="window.print()">طباعة</button>
    </div>

    <div class="header">
        <div class="title">سند قبض</div>
        <div>Receipt Voucher</div>
    </div>

    <div class="box">

        <div class="row">
            <span class="label">اسم العميل:</span>
            {{ $payment->installment->contract->client->name }}
        </div>

        <div class="row">
            <span class="label">السيارة:</span>
            {{ $payment->installment->contract->car_name }}
        </div>

        <div class="row">
            <span class="label">رقم القسط:</span>
            {{ $payment->installment->installment_number }}
        </div>

        <div class="row">
            <span class="label">المبلغ:</span>
            {{ number_format($payment->amount, 2) }} ر.س
        </div>

        @php
            $paid = $payment->installment->payments()->sum('amount');
        @endphp

        <div class="row">
            <span class="label">المبلغ المتبقي:</span>
            {{ number_format($payment->installment->amount - $paid, 2) }} ر.س
        </div>

        <div class="row">
            <span class="label">تاريخ الدفع:</span>
            {{ $payment->payment_date }}
        </div>

        <div class="row">
            <span class="label">رقم السند:</span>
            #{{ $payment->id }}
        </div>

    </div>

</div>

<script>
    window.print();
</script>

</body>
</html>