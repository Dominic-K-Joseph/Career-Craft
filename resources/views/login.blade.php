<x-layout>
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Login</h4>
            </div>

            <div class="card-body">
                {{-- Show error message if login fails --}}
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="username" class="form-control" placeholder="Enter your email" required>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            Login
                        </button>
                    </div>

                    {{-- Forgot Password --}}
                    <div class="text-center mt-3">
                        <a href="{{route('forgot.password')}}">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
