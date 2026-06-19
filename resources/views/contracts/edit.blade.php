@extends('layouts.app')

@section('title', 'تعديل عقد')

@section('content')
@can('edit contracts')
<form method="POST"
      action="{{ route('contracts.update',$contract->id) }}">

```
@csrf
@method('PUT')

<div class="form-group-modern mb-3">

    <label>العميل</label>

    <select name="client_id"
            class="form-control form-control-modern">

        @foreach($clients as $client)

            <option value="{{ $client->id }}"
                @selected($contract->client_id == $client->id)>

                {{ $client->name }}

            </option>

        @endforeach

    </select>

</div>

<div class="mb-3">

    <label>اسم السيارة</label>

    <input type="text"
           name="car_name"
           value="{{ old('car_name',$contract->car_name) }}"
           class="form-control form-control-modern">

</div>

<div class="row">

    <div class="col-md-4">

        <label>سعر السيارة</label>

        <input type="number"
               name="car_price"
               value="{{ old('car_price',$contract->car_price) }}"
               class="form-control form-control-modern">

    </div>

    <div class="col-md-4">

        <label>الفائدة</label>

        <input type="number"
               name="interest_value"
               value="{{ old('interest_value',$contract->interest_value) }}"
               class="form-control form-control-modern">

    </div>

    <div class="col-md-4">

        <label>عدد الأقساط</label>

        <input type="number"
               name="installments_count"
               value="{{ old('installments_count',$contract->installments_count) }}"
               class="form-control form-control-modern">

    </div>

</div>

<div class="mt-3">

    <label>تاريخ البداية</label>

    <input type="date"
           name="start_date"
           value="{{ old('start_date',$contract->start_date) }}"
           class="form-control form-control-modern">

</div>

<div class="mt-4">

    <button type="submit"
            class="btn-modern-primary">

        حفظ التعديلات

    </button>

</div>


</form>
@endcan
@endsection
