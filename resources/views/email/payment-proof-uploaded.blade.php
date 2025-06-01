<!DOCTYPE html>
<html>
<head>
    <title>{{ __('New Payment Proof Uploaded') }}</title>
</head>
<body>
    <h1>{{ __('New Payment Proof Uploaded') }}</h1>
    <p>{{ __('A new payment proof has been uploaded for review.') }}</p>
    <p><strong>{{ __('Payment ID') }}:</strong> {{ $payment->id }}</p>
    <p><strong>{{ __('User') }}:</strong> {{ $payment->user->name }}</p>
    <p><strong>{{ __('Amount') }}:</strong> {{ number_format($payment->amount, 2) }} NGN</p>
    <p><strong>{{ __('Proof') }}:</strong> <a href="{{ Storage::url($payment->proof_of_payment) }}">{{ __('View Proof') }}</a></p>
</body>
</html>