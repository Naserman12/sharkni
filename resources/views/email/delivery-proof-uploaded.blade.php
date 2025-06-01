<!DOCTYPE html>
<html>
<head>
    <title>{{ __('delivery.proof_uploaded_subject', 'New Delivery Proof Uploaded') }}</title>
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
        <h1>{{ __('delivery.proof_uploaded_subject', 'New Delivery Proof Uploaded') }}</h1>
        <p>{{ __('delivery.proof_uploaded_message', 'A new delivery proof has been uploaded for review.') }}</p>
        <div class="details">
            <p><strong>{{ __('payment.id', 'Payment ID') }}:</strong> {{ $payment->id }}</p>
            <p><strong>{{ __('payment.tool', 'Tool') }}:</strong> {{ $payment->tool->name }}</p>
            <p><strong>{{ __('payment.amount', 'Amount') }}:</strong> {{ number_format($payment->amount, 2) }} NGN</p>
            <p><strong>{{ __('delivery.proof', 'Proof') }}:</strong> <a href="{{ Storage::url($payment->proof_of_delivery) }}">{{ __('delivery.view_proof', 'View Proof') }}</a></p>
        </div>
        <p>{{ __('delivery.proof_action', 'Please review the proof if necessary.') }}</p>
    </div>
</body>
</html>