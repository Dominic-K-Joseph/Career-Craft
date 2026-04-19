<x-seeker_layout>
    {{-- Search Section --}}
    <div class="mb-4">
        <form action="#" method="GET" class="d-flex justify-content-center flex-wrap gap-3">
            <div class="input-group shadow-sm"
                style="max-width: 1000px; width:100%; border-radius: 8px; overflow: hidden;">

                {{-- Keyword Input --}}
                <span class="input-group-text bg-white border-0 px-3">
                    <i class="bi bi-search fs-5 text-muted"></i>
                </span>
                <input type="text" name="q" class="form-control border-0 fs-5"
                    placeholder="Search for jobs, companies, or skills..."
                    style="padding: 18px 20px; height:60px; min-width:350px; flex:2;">

                {{-- Location Input --}}
                <span class="input-group-text bg-white border-0 px-3">
                    <i class="bi bi-geo-alt-fill fs-5 text-muted"></i>
                </span>
                <input type="text" name="location" class="form-control border-0 fs-5" placeholder="City or Location"
                    style="padding: 18px 20px; height:60px; min-width:200px; flex:1;">

                {{-- Search Button --}}
                <button type="submit" class="btn btn-blue-800 px-5 fs-5" style="border-radius: 0; height:60px;">
                    Search
                </button>
            </div>
        </form>
    </div>

    {{-- Welcome Section --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">Welcome back, {{ auth()->user()->name ?? 'Job Seeker' }} 👋</h2>
        <p class="text-muted">Here’s a quick overview of your activity.</p>
    </div>

    {{-- Quick Stats --}}
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Applications</h6>
                    <p class="display-6 text-primary">12</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Saved Jobs</h6>
                    <p class="display-6 text-success">5</p>
                    <a href="#" class="btn btn-outline-success btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Profile Strength</h6>
                    <p class="display-6 text-warning">80%</p>
                    <a href="#" class="btn btn-outline-warning btn-sm">Complete</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest / Recommended Jobs --}}
    <div class="mt-5">
        <h4 class="fw-bold mb-3">Recommended Jobs for You</h4>
        <div class="row g-3">
              <div class="col-md-6">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 position-relative">
                        <div class="card-body">
                            {{-- Save Icon (Toggle) --}}
                            <a href="javascript:void(0)" class="save-job position-absolute top-0 end-0 m-3 text-muted"
                                data-saved="false">
                                <i class="bi bi-bookmark fs-5"></i>
                            </a>

                            <h6 class="fw-bold">Frontend Developer</h6>
                            <p class="text-muted mb-1">TechCorp Pvt Ltd</p>
                            <p class="text-muted">Bangalore • 2-4 yrs</p>

                            <a href="#" class="btn btn-sm btn-blue-800">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
              <div class="col-md-6">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 position-relative">
                        <div class="card-body">
                            {{-- Save Icon (Toggle) --}}
                            <a href="javascript:void(0)" class="save-job position-absolute top-0 end-0 m-3 text-muted"
                                data-saved="false">
                                <i class="bi bi-bookmark fs-5"></i>
                            </a>

                            <h6 class="fw-bold">Frontend Developer</h6>
                            <p class="text-muted mb-1">TechCorp Pvt Ltd</p>
                            <p class="text-muted">Bangalore • 2-4 yrs</p>

                            <a href="#" class="btn btn-sm btn-blue-800">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-seeker_layout>
