<!DOCTYPE html>
<html>
<head>
    <title>{{ __('payment.rejected_subject', 'Payment Rejected') }}</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #2c3e50; }
        p { line-height: 1.6; }
        .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ __('payment.rejected_subject', 'Payment Rejected') }}</h1>
        <p>{{ __('payment.rejected_message', 'Your payment has been rejected.') }}</p>
        <div class="details">
            <p><strong>{{ __('payment.id', 'Payment ID') }}:</strong> {{ $payment->id }}</p>
            <p><strong>{{ __('payment.amount', 'Amount') }}:</strong> {{ number_format($payment->amount, 2) }} NGN</p>
            <p><strong>{{ __('payment.tool', 'Tool') }}:</strong> {{ $payment->tool->name }}</p>
        </div>
        <p>{{ __('payment.rejected_action', 'Please try again or contact support.') }}</p>
    </div>
</body>
</html>