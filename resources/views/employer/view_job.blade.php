<x-emp_dashboard_layout>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Job Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Job Name</th>
                            <td>{{ $job->job_name }}</td>
                        </tr>
                        <tr>
                            <th>Salary</th>
                            <td>{{ $job->job_salary }}</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{ $job->job_location }}</td>
                        </tr>
                        <tr>
                            <th>Job Type</th>
                            <td>{{ $job->job_type }}</td>
                        </tr>
                        <tr>
                            <th>Experience</th>
                            <td>{{ $job->job_expirience }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $job->job_description }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($job->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-primary">
                        Edit Job
                    </a>
                    <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary">
                        Back to Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-emp_dashboard_layout>
