<x-employer_layout>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Manage Company Profile</h5>
            </div>

            <div class="card-body">
                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                {{-- Validation Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Company Logo at Top Center --}}
                <div class="text-center mb-4">
                    <img id="logoPreview"
                         src="{{ !empty($company->company_logo) ? asset('storage/' . $company->company_logo) : asset('images/default-logo.png') }}"
                         class="rounded-circle border mb-2"
                         width="120" height="120" alt="Company Logo">

                    <div class="mt-2">
                        <label class="btn btn-outline-primary btn-sm">
                            Change Logo
                            <input type="file" name="company_logo" id="company_logo" class="d-none" form="profileForm" accept="image/*">
                        </label>
                        <div id="logoError" class="text-danger small mt-1"></div>
                    </div>
                </div>

                {{-- Profile Update Form --}}
                <form id="profileForm" action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Company Title</label>
                            <input type="text" name="company_title" class="form-control"
                                   value="{{ old('company_title', $company->company_title ?? '') }}" required>
                            @error('company_title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="company_email" class="form-control"
                                   value="{{ old('company_email', $company->company_email ?? '') }}" required>
                            @error('company_email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="company_phone" class="form-control"
                                   value="{{ old('company_phone', $company->company_phone ?? '') }}" required>
                            @error('company_phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="company_location" class="form-control"
                                   value="{{ old('company_location', $company->company_location ?? '') }}" required>
                            @error('company_location')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Established Year</label>
                            <input type="number" name="company_year" class="form-control"
                                   value="{{ old('company_year', $company->company_year ?? '') }}" required>
                            @error('company_year')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Company Details</label>
                            <textarea name="company_details" class="form-control" rows="3">{{ old('company_details', $company->company_details ?? '') }}</textarea>
                            @error('company_details')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Update Button --}}
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-save me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Live Image Preview + Validation Script --}}
    <script>
        const logoInput = document.getElementById('company_logo');
        const logoPreview = document.getElementById('logoPreview');
        const logoError = document.getElementById('logoError');

        logoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            logoError.textContent = ''; // clear old error

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (!validTypes.includes(file.type)) {
                    logoError.textContent = 'Please select a valid image (JPG, JPEG, or PNG).';
                    logoInput.value = '';
                    return;
                }

                if (file.size > maxSize) {
                    logoError.textContent = 'File size must be less than 2MB.';
                    logoInput.value = '';
                    return;
                }

                // Show preview only if valid
                const reader = new FileReader();
                reader.onload = function (e) {
                    logoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-employer_layout>
