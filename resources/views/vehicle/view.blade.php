@extends('layouts.app')

@section('content')
    <vehicleview :park = "{{ $park }}"></vehicleview>
@endsection
