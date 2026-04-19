<x-employer_layout>
    @php
        $loginId = session('login_id');
        $role = session('role');

        $company_name = null;

        if ($loginId && $role === 'employer') {
            $company_name = DB::table('tbl_company')->where('login_id', $loginId)->value('company_title');
        }
    @endphp

    {{-- Welcome Section --}}
    <div class="position-relative mb-5 text-white overflow-hidden shadow-sm" style="margin:0; border-radius:0;">
        {{-- Background Image --}}
        <img src="{{ asset('images/banners/employer-home-banner1.jpg') }}" alt="Welcome Banner" class="w-100"
            style="height: 500px; object-fit: cover;">

        {{-- Overlay --}}
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center"
            style="background: rgba(0,0,0,0.55);">

            <h2 class="fw-bold">Welcome back, {{ auth()->user()->name ?? $company_name }} 👋</h2>
            <p class="text-light mb-3">Here’s a quick overview of your activity.</p>

            {{-- Post Job Button --}}
            <a href="{{route('employer.jobs.index')}}" class="btn btn-warning btn-lg px-4">
                Post a Job
            </a>
        </div>
    </div>

   {{-- Section Heading --}}
<div class="text-center my-5">
    <h2 class="fw-bold">About Recruiting</h2>
</div>

{{-- About Recruiting Section --}}
<div class="container my-5 py-1">
    <div class="row align-items-center">
        {{-- Left Image --}}
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('images/home1.jpg') }}" 
                 alt="Recruiting" 
                 class="img-fluid rounded shadow-sm"
                 style="object-fit: cover; width:100%; height:400px;">
        </div>

        {{-- Right Content --}}
        <div class="col-md-6">
            <h3 class="fw-bold mb-3">Streamline Your Hiring Process</h3>
            <p class="text-muted mb-4">
                Our platform helps you connect with top talent faster. 
                Post jobs, track applications, and manage interviews — 
                all in one place. Simplify recruitment and hire smarter.
            </p>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Post unlimited jobs</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Manage candidates efficiently</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Boost your employer branding</li>
            </ul>
            <a href="#" class="btn btn-blue-800 btn-lg">Learn More</a>
        </div>
    </div>
</div>

{{-- Section Heading --}}
<div class="container my-5">
    <h2 class="fw-bold text-center">Why Choose Us?</h2>
</div>

{{-- Why Choose Us Section --}}
<div class="container my-5 py-1">
    <div class="row align-items-center">
        {{-- Left Content --}}
        <div class="col-md-6 order-2 order-md-1">
            <h3 class="fw-bold mb-3">Hire Smarter, Faster</h3>
            <p class="text-muted mb-4">
                Gain access to a wide pool of qualified candidates, smart filters, and advanced analytics. 
                Our platform ensures you hire the right talent without wasting time.
            </p>
            <ul class="list-unstyled mb-4">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> AI-powered candidate matching</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> In-depth application tracking</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Real-time insights & reports</li>
            </ul>
            <a href="{{route('employer.dashboard')}}" class="btn btn-blue-800 btn-lg">Get Started</a>
        </div>

        {{-- Right Image --}}
        <div class="col-md-6 order-1 order-md-2 mb-4 mb-md-0 text-center">
            <img src="{{ asset('images/home2.jpg') }}" 
                 alt="Why Choose Us" 
                 class="img-fluid rounded shadow-sm"
                 style="object-fit: fit; width:100%; height:400px;">
        </div>
    </div>
</div>

</x-employer_layout>
