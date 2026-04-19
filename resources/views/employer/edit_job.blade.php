<x-emp_dashboard_layout>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Edit Job</h5>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('employer.jobs.update', $job->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Required for update --}}

                    {{-- Job Name --}}
                    <div class="mb-3">
                        <label for="job_name" class="form-label">Job Title</label>
                        <input type="text" name="job_name" id="job_name" class="form-control"
                            placeholder="Enter job title" value="{{ old('job_name', $job->job_name) }}">
                        @error('job_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Salary --}}
                    <div class="mb-3">
                        <label for="job_salary" class="form-label">Salary</label>
                        <input type="text" name="job_salary" id="job_salary" class="form-control"
                            placeholder="e.g., ₹30,000 - ₹50,000" value="{{ old('job_salary', $job->job_salary) }}">
                        @error('job_salary')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-3">
                        <label for="job_location" class="form-label">Location</label>
                        <select name="job_location" id="job_location" class="form-select">
                            <option value="">-- Select Location --</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location }}"
                                    {{ old('job_location', $job->job_location) == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_location')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="job_location" class="form-label">Location</label>
                        <input type="text" name="job_location" id="job_location" class="form-control"
                            placeholder="e.g., Kochi, Kerala" value="{{ old('job_location', $job->job_location) }}">
                        @error('job_location')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> --}}

                    {{-- Job Type --}}
                    <div class="mb-3">
                        <label for="job_type" class="form-label">Job Type</label>
                        <select name="job_type" id="job_type" class="form-select">
                            <option value="">-- Select Type --</option>
                            <option value="Full-Time"
                                {{ old('job_type', $job->job_type) == 'Full-Time' ? 'selected' : '' }}>Full-Time
                            </option>
                            <option value="Part-Time"
                                {{ old('job_type', $job->job_type) == 'Part-Time' ? 'selected' : '' }}>Part-Time
                            </option>
                            <option value="Internship"
                                {{ old('job_type', $job->job_type) == 'Internship' ? 'selected' : '' }}>Internship
                            </option>
                            <option value="Contract"
                                {{ old('job_type', $job->job_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                        @error('job_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Experience --}}
                    <div class="mb-3">
                        <label for="job_expirience" class="form-label">Experience Required</label>
                        <input type="text" name="job_expirience" id="job_expirience" class="form-control"
                            placeholder="e.g., 2+ years" value="{{ old('job_expirience', $job->job_expirience) }}">
                        @error('job_expirience')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="job_description" class="form-label">Job Description</label>
                        <textarea name="job_description" id="job_description" class="form-control" rows="5"
                            placeholder="Describe the role...">{{ old('job_description', $job->job_description) }}</textarea>
                        @error('job_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">Update Job</button>
                        <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary px-4">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-emp_dashboard_layout>
