<x-seeker_layout>

    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold">Choose Your Plan</h2>

        <div class="row justify-content-center g-4">

            <!-- FREE PLAN -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="fw-bold">Free</h4>
                        <h2 class="text-success">₹0</h2>

                        <ul class="list-unstyled my-4">
                            <li>✔ Basic Job Access</li>
                            <li>✔ Limited Applications</li>
                            <li>✖ No Priority Support</li>
                        </ul>

                        <button class="btn btn-success w-100">Current Plan</button>
                    </div>
                </div>
            </div>

            <!-- GOLD PLAN -->
            <div class="col-md-4">
                <div class="card text-center shadow-lg border-warning h-100 position-relative">

                    <!-- Badge -->
                    <span class="badge bg-warning text-dark position-absolute top-0 start-50 translate-middle">
                        Most Popular
                    </span>

                    <div class="card-body">
                        <h4 class="fw-bold text-warning">
                            <i class="fas fa-crown"></i> Gold
                        </h4>

                        <h2 class="text-warning">₹50</h2>

                        <ul class="list-unstyled my-4">
                            <li>✔ Unlimited Applications</li>
                            <li>✔ Priority Listing</li>
                            <li>✔ Email Support</li>
                        </ul>

                        <form action="{{ route('seeker.payment.session') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="gold">
                            <input type="hidden" name="amount" value="5000">
                            <button class="btn btn-warning w-100">Upgrade to Gold</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PLATINUM PLAN -->
            <div class="col-md-4">
                <div class="card text-center shadow-lg border-dark h-100">
                    <div class="card-body">
                        <h4 class="fw-bold text-dark">
                            💎 Platinum
                        </h4>

                        <h2 class="text-dark">₹100</h2>

                        <ul class="list-unstyled my-4">
                            <li>✔ All Gold Features</li>
                            <li>✔ Featured Profile</li>
                            <li>✔ 24/7 Support</li>
                        </ul>

                        <form action="{{ route('seeker.payment.session') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="platinum">
                            <input type="hidden" name="amount" value="10000">
                            <button class="btn btn-dark w-100">Go Platinum</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @push('scripts')
        @if (request('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful',
                        text: 'Your plan has been upgraded successfully!'
                    }).then(() => {
                        // ✅ remove query params from URL
                        window.history.replaceState({}, document.title, window.location.pathname);
                    });
                });
            </script>
        @endif

        @if (request('cancel'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Cancelled'
                    }).then(() => {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    });
                });
            </script>
        @endif
    @endpush
</x-seeker_layout>
