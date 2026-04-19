<x-emp_dashboard_layout>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Active Jobs</h5>
                        <p class="card-text display-6 fw-bold text-primary">{{$totalJobs}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Applicants</h5>
                        <p class="card-text display-6 fw-bold text-success">56</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Company Views</h5>
                        <p class="card-text display-6 fw-bold text-warning">234</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-emp_dashboard_layout>
