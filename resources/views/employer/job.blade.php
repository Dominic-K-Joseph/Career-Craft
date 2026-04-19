<x-emp_dashboard_layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Job List</h5>
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-sm btn-primary">Add Job</a>
        </div>

          {{-- 🔍 Search + Filter Section --}}
        <div class="p-3 border-bottom bg-light">
            <form method="GET" action="{{ route('employer.jobs.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by job name..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="job_filter" class="form-select">
                        <option value="">-- All Job Types --</option>
                        <option value="Full-Time" {{ request('job_filter') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                        <option value="Part-Time" {{ request('job_filter') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                        <option value="Internship" {{ request('job_filter') == 'Internship' ? 'selected' : '' }}>Internship</option>
                        <option value="Contract" {{ request('job_filter') == 'Contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                    <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary"><i class="bi bi-x"></i> Reset</a>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Job Name</th>
                            <th>Job Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $job)
                            <tr>
                                <td>{{ $job->job_name }}</td>
                                <td>{{ $job->job_type }}</td>
                                <td>
                                    <div class="d-inline-flex gap-1">
                                        {{-- View --}}
                                        <a href="{{ route('employer.jobs.show', $job->id) }}"
                                            class="btn btn-sm btn-outline-secondary" title="View">
                                            <span class="material-icons-outlined"
                                                style="vertical-align:middle;">visibility</span>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('employer.jobs.edit', $job->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <span class="material-icons-outlined"
                                                style="vertical-align:middle;">edit</span>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this job?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <span class="material-icons-outlined"
                                                    style="vertical-align:middle;">delete_forever</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Job found.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Small JS for delete confirmation — include once per page (can be moved to a separate JS file) --}}
    @push('scripts')
        <script>
            function confirmDelete(event, jobName) {
                event.preventDefault();
                const ok = confirm(`Are you sure you want to delete the job: "${jobName}"? This action cannot be undone.`);
                if (ok) {
                    // find the nearest form and submit it
                    const form = event.target.closest('form') || event.target;
                    form.submit();
                }
                return false;
            }
        </script>
    @endpush

</x-emp_dashboard_layout>
