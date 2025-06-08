<x-app-layout>
    <div class="container mx-auto max-w-lg px-4 py-12 bg-slate-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">فشل عملية الدفع</h1>
        <!-- عرض رسالة الخطأ -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-center">
                {{ session('error') }}
            </div>
            <!-- إشعار SweetAlert -->
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'فشل الدفع',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'حسنًا',
                    confirmButtonColor: '#ef4444'
                });
            </script>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-center">
                فشل عملية الدفع. يرجى المحاولة مرة أخرى أو التواصل مع الدعم.
            </div>
        @endif

        <!-- تفاصيل الدفع -->
        @if ($reference)
            <div class=" bg-slate-200 shadow-md rosunded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">تفاصيل المحاولة</h3>
                <p class="text-gray-600 mb-2"><strong>رقم المرجع:</strong> {{ $reference }}</p>
                @if ($payment)
                    <p class="text-gray-600 mb-2"><strong>المبلغ:</strong> {{ number_format($payment->amount ?? 0, 2) }} {{ $payment->paystackTrans->currency ?? 'NGN' }}</p>
                    <p class="text-gray-600"><strong>حالة الدفع:</strong> {{ $payment->status ?? 'غير متوفر' }}</p>
                @endif
            </div>
        @endif

        <!-- أزرار الإجراءات -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if ($payment)
                <a href="{{ route('payment.initiate', ['payment_id' => $payment->id]) }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                    إعادة محاولة الدفع
                </a>
            @endif
            <a href="{{ url('/contact') }}" 
               class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition text-center">
                التواصل مع الدعم
            </a>
            <a href="{{ route('tools.index') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                العودة إلى الأدوات
            </a>
        </div>
    </div>
</x-app-layout>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'فشل الدفع',
            text: '{{ session('error') }}',
            confirmButtonText: 'حسنًا',
            confirmButtonColor: '#ef4444'
        });
    </script>
@endif
@endsection