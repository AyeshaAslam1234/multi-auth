<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout Integration</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Stripe Payment</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
    <div id="successMessage" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($canceled)
    <div id="cancelMessage" class="alert alert-warning">
        Payment was canceled 
    </div>
@endif

        <form action="{{ route('payment.checkout') }}" method="POST">
            @csrf
            <p class="fw-bold mb-3">Amount: $10.00</p>
            <button type="submit" class="btn btn-primary w-100">
                Checkout with Stripe
            </button>
        </form>
    </div>

    <!-- Bootstrap 5 JS (optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Auto-hide messages after 3 seconds
    setTimeout(() => {
        let success = document.getElementById('successMessage');
        let cancel = document.getElementById('cancelMessage');
        if (success) success.style.display = 'none';
        if (cancel) cancel.style.display = 'none';
    }, 3000);
    </script>
    </body>
</html>
