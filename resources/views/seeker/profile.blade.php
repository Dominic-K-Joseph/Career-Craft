<x-seeker_layout>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header" style="background-color:#1e40af; color:white; text-align:center;">
                <h5 class="mb-0">Manage Your Profile</h5>
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

                {{-- Profile Photo --}}
                <div class="text-center mb-4">
                    <img id="photoPreview"
                        src="{{ !empty($seeker->seeker_photo) ? asset('storage/' . $seeker->seeker_photo) : asset('images/default-avatar.png') }}"
                        class="rounded-circle border mb-2" width="120" height="120" alt="Profile Photo">

                    <div class="mt-2">
                        <label class="btn btn-outline-primary btn-sm">
                            Change Photo
                            <input type="file" name="seeker_photo" id="seeker_photo" class="d-none" form="seekerForm"
                                accept="image/*">
                        </label>
                        <div id="photoError" class="text-danger small mt-1"></div>
                    </div>
                </div>

                {{-- Seeker Profile Form --}}
                <form id="seekerForm" action="{{ route('seeker.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="seeker_name" class="form-control"
                                value="{{ old('seeker_name', $seeker->seeker_name ?? '') }}" required>
                            @error('seeker_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="seeker_email" class="form-control"
                                value="{{ old('seeker_email', $seeker->seeker_email ?? '') }}" required>
                            @error('seeker_email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="seeker_phone" class="form-control"
                                value="{{ old('seeker_phone', $seeker->seeker_phone ?? '') }}" required>
                            @error('seeker_phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="seeker_location" class="form-control"
                                value="{{ old('seeker_location', $seeker->seeker_location ?? '') }}" required>
                            @error('seeker_location')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Education</label>
                        <input type="text" name="seeker_education" class="form-control"
                            value="{{ old('seeker_education', $seeker->seeker_education ?? '') }}" required>
                        @error('seeker_education')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills</label>
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" id="skillInput" class="form-control" placeholder="Enter a skill">
                            <button type="button" id="addSkillBtn" class="btn text-white"
                                style="background-color:#1e40af;">Add</button>
                        </div>

                        <div id="skillList" class="mt-2">
                            @foreach ($skills as $skill)
                                <span class="badge rounded-pill text-white me-1 mb-1" style="background-color:#1e40af;">
                                    {{ $skill->skill }}
                                    <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-skill-db"
                                        data-skill-id="{{ $skill->id }}" aria-label="Remove"></button>
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Experience</label>
                        <textarea name="seeker_experience" class="form-control" rows="3">{{ old('seeker_experience', $seeker->seeker_experience ?? '') }}</textarea>
                        @error('seeker_experience')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="seeker_address" class="form-control" rows="3">{{ old('seeker_address', $seeker->seeker_address ?? '') }}</textarea>
                        @error('seeker_address')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label d-block">Upload Resume (PDF)</label>

                        <!-- Hidden file input -->
                        <input type="file" name="seeker_resume" id="seeker_resume" accept=".pdf" hidden>

                        <!-- Button to trigger file input -->
                        <button type="button" id="uploadResumeBtn" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Upload Resume
                        </button>

                        <!-- Display selected file name -->
                        <span id="selectedResume" class="ms-2 text-primary"></span>

                        @if (!empty($seeker->seeker_resume))
                            @php
                                $resumeFile = basename($seeker->seeker_resume);
                            @endphp
                            <div class="mt-2">
                                <small class="text-success">
                                    Current Resume:
                                    <a href="{{ asset('storage/' . $seeker->seeker_resume) }}"
                                        target="_blank">{{ $resumeFile }}</a>
                                </small>
                            </div>
                        @endif

                        @error('seeker_resume')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Update Button --}}
                    <div class="text-center">
                        <button type="submit" class="btn text-white px-4 py-2" style="background-color:#1e40af;">
                            <i class="bi bi-save me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Live Image Preview + Validation Script --}}
    <script>
        const photoInput = document.getElementById('seeker_photo');
        const photoPreview = document.getElementById('photoPreview');
        const photoError = document.getElementById('photoError');

        // === Image Preview Validation ===
        photoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            photoError.textContent = '';

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024;

                if (!validTypes.includes(file.type)) {
                    photoError.textContent = 'Please select a valid image (JPG, JPEG, or PNG).';
                    photoInput.value = '';
                    return;
                }

                if (file.size > maxSize) {
                    photoError.textContent = 'File size must be less than 2MB.';
                    photoInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // === Skill Management Logic ===
        const addSkillBtn = document.getElementById('addSkillBtn');
        const skillInput = document.getElementById('skillInput');
        const skillList = document.getElementById('skillList');

        let skills = [];

        // Load existing skills from DB on page load
        document.querySelectorAll('.remove-skill-db').forEach(el => {
            const skillText = el.parentElement.childNodes[0].textContent.trim();
            if (!skills.map(s => s.toLowerCase()).includes(skillText.toLowerCase())) {
                skills.push(skillText);
            }
        });

        // ✅ Call renderSkills() on page load so hidden input is always present
        renderSkills();

        // Add new skill
        addSkillBtn.addEventListener('click', () => {
            const newSkill = skillInput.value.trim();
            if (newSkill && !skills.map(s => s.toLowerCase()).includes(newSkill.toLowerCase())) {
                skills.push(newSkill);
                renderSkills();
                skillInput.value = '';
            } else if (newSkill) {
                alert('This skill already exists!');
            }
        });

        // Press Enter to add
        skillInput.addEventListener('keypress', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkillBtn.click();
            }
        });

        // Remove newly added skill
        skillList.addEventListener('click', e => {
            if (e.target.classList.contains('remove-skill')) {
                const skillText = e.target.parentElement.firstChild.textContent.trim();
                skills = skills.filter(s => s.toLowerCase() !== skillText.toLowerCase());
                renderSkills();
            }
        });

        // Remove existing DB skill
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-skill-db')) {
                const skillId = e.target.dataset.skillId;
                if (confirm('Deactivate this skill?')) {
                    fetch(`/seeker/skill/remove/${skillId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const skillText = e.target.parentElement.childNodes[0].textContent.trim();
                                e.target.parentElement.remove();
                                skills = skills.filter(s => s.toLowerCase() !== skillText.toLowerCase());
                                renderSkills(); // ✅ update hidden input after DB skill removed
                            } else {
                                alert('Failed to deactivate skill.');
                            }
                        })
                        .catch(() => alert('Error occurred while deactivating skill.'));
                }
            }
        });

        function renderSkills() {
            // Remove only newly added badges
            document.querySelectorAll('.new-skill').forEach(el => el.remove());

            const existingDBSkills = Array.from(document.querySelectorAll('.remove-skill-db'))
                .map(el => el.parentElement.childNodes[0].textContent.trim().toLowerCase());

            skills.forEach(skill => {
                if (!existingDBSkills.includes(skill.toLowerCase())) {
                    const badge = document.createElement('span');
                    badge.className = 'badge rounded-pill text-white me-1 mb-1 new-skill';
                    badge.style.backgroundColor = '#1e40af';
                    badge.innerHTML = `
                    ${skill}
                    <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-skill" aria-label="Remove"></button>
                `;
                    skillList.appendChild(badge);
                }
            });

            // ✅ Always ensure hidden input exists and is up to date
            let hidden = document.getElementById('skillsHidden');
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'skills';
                hidden.id = 'skillsHidden';
                document.getElementById('seekerForm').appendChild(hidden);
            }
            hidden.value = JSON.stringify(skills);
        }

        // Resume file name display
        document.getElementById('seeker_resume').addEventListener('change', function() {
            if (this.files.length > 0) {
                let existing = document.getElementById('resumeSelected');
                if (!existing) {
                    existing = document.createElement('small');
                    existing.id = 'resumeSelected';
                    existing.className = 'text-primary d-block mt-1';
                    this.insertAdjacentElement('afterend', existing);
                }
                existing.textContent = `Selected: ${this.files[0].name}`;
            }
        });

        // ✅ Wire up the Upload Resume button
        document.getElementById('uploadResumeBtn').addEventListener('click', function() {
            document.getElementById('seeker_resume').click();
        });
    </script>


</x-seeker_layout>
