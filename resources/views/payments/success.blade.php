<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم الدفع بنجاح</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- تأكد من وجود ملف CSS إذا لزم الأمر -->
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success-message {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .details {
            text-align: right;
            margin-top: 20px;
        }
        .details p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="success-message">تم الدفع بنجاح!</h1>
        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <div class="details">
            <h2>تفاصيل الدفع</h2>
            <p><strong>رقم المرجع:</strong> {{ $payment->paystackTransaction->reference ?? 'غير متوفر' }}</p>
            <p><strong>المبلغ:</strong> {{ number_format($payment->amount, 2) }} {{ $payment->paystackTransaction->currency ?? 'NGN' }}</p>
            <p><strong>تاريخ الدفع:</strong> {{ $payment->paystackTransaction->paid_at ?? 'غير متوفر' }}</p>
            <p><strong>حالة الدفع:</strong> {{ $payment->status }}</p>
        </div>

        <a href="{{ route('tools.index') }}" class="btn btn-primary mt-4">العودة إلى الأدوات</a>
    </div>
</body>
</html>