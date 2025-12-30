@extends('layouts.app')

@section('content')
<div class="py-10" style="background-color: #f9fafb;">
    <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">Products</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <livewire:product.product-listing />
        </div>
    </main>
</div>
@endsection