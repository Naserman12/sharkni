@extends('layouts.app')
@section('contnet')
 <!-- Pament Success Message -->
             <div class="p-4 rounded-lg border border bg-green-100">
                <div class=" flex items-center">
                    <svg class="h-6 w-6 text-green-600" file="nono" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1314 4L19 7"></path>
                    </svg>
                    <h3 class=" ml-2 text-lg font-semibold text-green-700">
                        We have recived the order
                    </h3>
                </div>
                <p class=" mt-2 text-green-600">
                    @if ($paymentMethod === 'bank_transfer')
                        we'll return to u in 24H
                    @else
                        To see Your Order Check The dashboard
                    @endif
                </p>
                <a href="{{ route('dashboard') }}">
                    Go to dashboard
                </a>
             </div>
@endsection