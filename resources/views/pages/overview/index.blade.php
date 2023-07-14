@extends('layouts.app')
@section('content')

<div class="row justify-content-md-center">
    <div class="col col-lg-10">
        <h2>Overview Page</h2>
    </div>
</div>
<div class="row">
    <div class="col">
        <select class="form-select" aria-label="Default select example" id="stat-selector">
            <option value="" selected>Select Statistic</option>
            @foreach ($params as $key => $item)
            <option value=" {{$key}}">{{$item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <select class="form-select" aria-label="Default select example" id="year-selector">
            <option value="" selected>Select Year</option>
            @foreach ($matchDates as $key => $item)
            <option>{{$item}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col pt-4 container" id="table-viewer">
        @include('sections.table')
    </div>
</div>

@endsection