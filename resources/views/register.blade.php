<x-layout>
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Register</h4>
            </div>

            <div class="card-body">
                {{-- Toggle Tabs --}}
                <ul class="nav nav-pills mb-3 justify-content-center" id="registerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="seeker-tab" data-bs-toggle="pill" data-bs-target="#seeker"
                            type="button" role="tab">Job Seeker</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="employer-tab" data-bs-toggle="pill" data-bs-target="#employer"
                            type="button" role="tab">Employer</button>
                    </li>
                </ul>

                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data"
                    id="registerForm">
                    @csrf

                    <input type="hidden" name="role" id="role" value="seeker">

                    <div class="tab-content" id="registerTabContent">

                        {{-- Seeker Fields --}}
                        <div class="tab-pane fade show active" id="seeker" role="tabpanel">
                            <div class="mb-3 text-center">
                                <img id="photoPreview" class="rounded-circle border border-2 mb-3"
                                    style="width:120px; height:120px; display:none; object-fit:cover;">
                                <div class="text-start">
                                    <input type="file" id="photo" name="seeker_photo" class="d-none seeker-field"
                                        accept="image/*" onchange="previewPhoto(event)">
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="document.getElementById('photo').click()">Upload Photo</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="seeker_name" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="seeker_email" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="seeker_password" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="seeker_phone" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="seeker_address" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Education</label>
                                <input type="text" name="seeker_education" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <select name="seeker_location" class="form-select seeker-field">
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $loc)
                                        <option value="{{ $loc->loc_name }}">{{ $loc->loc_name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            {{-- <div class="mb-3">
                                <label class="form-label">Skills</label>
                                <textarea type="text" name="seeker_skills" class="form-control seeker-field"
                                    placeholder="Comma separated"></textarea>
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label">Experience</label>
                                <input type="text" name="seeker_experience" class="form-control seeker-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Resume</label>
                                <input type="file" name="seeker_resume" class="form-control seeker-field"
                                    accept=".pdf,.doc,.docx">
                            </div>
                        </div>

                        {{-- Employer Fields --}}
                        <div class="tab-pane fade" id="employer" role="tabpanel">
                            <div class="mb-3 text-center">
                                <img id="logoPreview" class="rounded-circle border border-2 mb-3"
                                    style="width:120px; height:120px; display:none; object-fit:cover;">
                                <div class="text-start">
                                    <input type="file" id="logo" name="company_logo"
                                        class="d-none employer-field" accept="image/*" onchange="previewLogo(event)">
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="document.getElementById('logo').click()">Upload Logo</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_title" class="form-control employer-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="company_email" class="form-control employer-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="company_password" class="form-control employer-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="company_phone" class="form-control employer-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Company Location</label>
                                <select name="company_location" class="form-select employer-field">
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $loc)
                                        <option value="{{ $loc->loc_name }}">{{ $loc->loc_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Year Established</label>
                                <input type="text" name="company_year" class="form-control employer-field">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Company Details</label>
                                <textarea name="company_details" class="form-control employer-field" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            Register as Seeker
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const roleInput = document.getElementById('role');
        const submitBtn = document.getElementById('submitBtn');
        const seekerFields = document.querySelectorAll('.seeker-field');
        const employerFields = document.querySelectorAll('.employer-field');

        // Helper to enable/disable fields
        function setFields(fields, enabled) {
            fields.forEach(el => {
                if (enabled) {
                    el.removeAttribute('disabled');
                    el.setAttribute('required', true);
                } else {
                    el.setAttribute('disabled', true);
                    el.removeAttribute('required');
                }
            });
        }

        // Default: seeker enabled
        setFields(seekerFields, true);
        setFields(employerFields, false);

        // Switch to seeker
        document.getElementById('seeker-tab').addEventListener('click', () => {
            roleInput.value = 'seeker';
            submitBtn.textContent = 'Register as Seeker';
            setFields(seekerFields, true);
            setFields(employerFields, false);
        });

        // Switch to employer
        document.getElementById('employer-tab').addEventListener('click', () => {
            roleInput.value = 'employer';
            submitBtn.textContent = 'Register as Employer';
            setFields(seekerFields, false);
            setFields(employerFields, true);
        });

        // Previews
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photoPreview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }

        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logoPreview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</x-layout>
