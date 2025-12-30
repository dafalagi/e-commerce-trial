@extends('layouts.app')

@section('content')
<livewire:order.order-detail :order_uuid="$order_uuid" />
@endsection