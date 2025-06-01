<!DOCTYPE html>
<html>
<head>
    <title>{{ __('delivery.confirmed_subject', 'Delivery Confirmed') }}</title>
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
        <h1>{{ __('delivery.confirmed_subject', 'Delivery Confirmed') }}</h1>
        <p>{{ __('delivery.confirmed_message', 'The tool delivery has been confirmed.') }}</p>
        <div class="details">
            <p><strong>{{ __('payment.id', 'Payment ID') }}:</strong> {{ $payment->id }}</p>
            <p><strong>{{ __('payment.tool', 'Tool') }}:</strong> {{ $payment->tool->name }}</p>
            <p><strong>{{ __('payment.amount', 'Amount') }}:</strong> {{ number_format($payment->amount, 2) }} NGN</p>
        </div>
        <p>{{ __('delivery.next_step', 'Funds will be transferred to the tool owner soon.') }}</p>
    </div>
</body>
</html>