@extends('layouts.app')

@section('title', 'إضافة عقد')

@section('content')

@if($errors->any())

<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@can('create contracts')
<form method="POST" action="{{ route('contracts.store') }}">
    @csrf


<div class="form-group-modern mb-3">

    <label>العميل</label>

    <select name="client_id"
            class="form-control form-control-modern">

        <option value="">
            اختر العميل
        </option>

        @foreach($clients as $client)

            <option value="{{ $client->id }}">
                {{ $client->name }}
            </option>

        @endforeach

    </select>

</div>

<div class="form-group-modern mb-3">

    <label>اسم السيارة</label>

    <input type="text"
           name="car_name"
           class="form-control form-control-modern">

</div>

<div class="row">

    <div class="col-md-4">

        <label>سعر السيارة</label>

        <input type="number"
               name="car_price"
               class="form-control form-control-modern">

    </div>

    <div class="col-md-4">

        <label>الفائدة</label>

        <input type="number"
               name="interest_value"
               class="form-control form-control-modern">

    </div>

    <div class="col-md-4">

        <label>عدد الأقساط</label>

        <input type="number"
               name="installments_count"
               class="form-control form-control-modern">

    </div>

</div>

<div class="mt-3">

    <label>تاريخ بداية التقسيط</label>

    <input type="date"
           name="start_date"
           class="form-control form-control-modern">

</div>

<div class="mt-4">

    <button class="btn-modern-primary">
        حفظ العقد
    </button>

</div>


</form>
@endcan
@endsection
