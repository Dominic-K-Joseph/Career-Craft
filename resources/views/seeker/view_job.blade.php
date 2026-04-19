<x-seeker_layout>

    <div class="container py-4">

        {{-- Search Bar --}}
        <div class="mb-4">
            <form action="{{ route('seeker.jobs') }}" method="GET" class="d-flex justify-content-center flex-wrap gap-3">
                <div class="input-group shadow-sm"
                    style="max-width: 1000px; width:100%; border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-0 px-3">
                        <i class="bi bi-search fs-5 text-muted"></i>
                    </span>
                    <input type="text" name="q" class="form-control border-0 fs-5"
                        placeholder="Search for jobs..." value="{{ request('q') }}"
                        style="padding: 18px 20px; height:60px; flex:2;">

                    <span class="input-group-text bg-white border-0 px-3">
                        <i class="bi bi-geo-alt-fill fs-5 text-muted"></i>
                    </span>
                    <input type="text" name="location" class="form-control border-0 fs-5"
                        placeholder="City or Location" value="{{ request('location') }}"
                        style="padding: 18px 20px; height:60px; flex:1;">

                    <button type="submit" class="btn btn-blue-800 px-5 fs-5" style="border-radius: 0; height:60px;">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <h4 class="text-center mb-4">Jobs for You</h4>

        {{-- Job List --}}
        <div class="row g-3">
            @forelse ($jobs as $job)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 position-relative h-100">
                        <div class="card-body">

                            {{-- Save Job --}}
                            <a href="javascript:void(0)"
                                class="save-job position-absolute top-0 end-0 m-3 text-muted {{ $job->is_saved ? 'text-primary' : '' }}"
                                data-job-id="{{ $job->job_id }}" data-company-id="{{ $job->company_id }}"
                                data-saved="{{ $job->is_saved ? 'true' : 'false' }}">
                                <i class="bi bi-bookmark{{ $job->is_saved ? '-fill' : '' }} fs-5"></i>
                            </a>

                            <h6 class="fw-bold">{{ $job->job_name }}</h6>
                            <p class="text-muted mb-1">{{ $job->company_title ?? 'Company not found' }}</p>
                            <p class="text-muted mb-1">{{ $job->job_location }}</p>
                            <p class="text-muted mb-1">{{ $job->job_salary }}</p>
                            <p class="text-muted">{{ $job->job_type }}</p>

                            <button class="btn btn-sm btn-blue-800 apply-btn" data-job-id="{{ $job->job_id }}"
                                data-job-name="{{ $job->job_name }}" data-company-id="{{ $job->company_id }}">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-briefcase fs-1"></i>
                    <p class="mt-2">No jobs found</p>
                </div>
            @endforelse
        </div>

    </div>


    {{-- Apply Modal --}}
    <div class="modal fade" id="applyModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-blue-800 text-white">
                    <h5 class="modal-title" id="applyModalLabel">Apply for Job</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="applyForm" enctype="multipart/form-data">
                    <div class="modal-body">

                        <input type="hidden" name="job_id" id="job_id">
                        <input type="hidden" name="company_id" id="company_id">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="seeker_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="seeker_email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number" name="seeker_phone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Salary</label>
                            <input type="number" name="seeker_current_salary" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Expected Salary</label>
                            <input type="number" name="seeker_expected_salary" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Experience</label>
                            <input type="number" name="seeker_experience" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cover Letter</label>
                            <textarea name="cover_letter" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Resume (PDF)</label>
                            <input type="file" name="seeker_resume" class="form-control"
                                accept="application/pdf">
                        </div>
                        <div id="resume_info" class="text-muted small mb-2"></div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-blue-800 w-100">Submit Application</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    {{-- Styles --}}
    <style>
        .btn-blue-800 {
            background-color: #1e40af;
            color: white;
        }

        .btn-blue-800:hover {
            background-color: #1c3aa9;
        }

        .bg-blue-800 {
            background-color: #1e40af !important;
        }
    </style>


    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    {{-- Save Job --}}
    <script>
        $(document).on('click', '.save-job', function(e) {
            e.preventDefault();

            const button = $(this);

            $.post("{{ route('seeker.job.save') }}", {
                job_id: button.data('job-id'),
                _token: "{{ csrf_token() }}"
            }, function(response) {

                const saved = response.status == 1;

                button.toggleClass('text-primary', saved);
                button.find('i')
                    .toggleClass('bi-bookmark-fill', saved)
                    .toggleClass('bi-bookmark', !saved);

                Swal.fire({
                    icon: 'success',
                    title: saved ? "Saved" : "Removed",
                    timer: 900,
                    showConfirmButton: false
                });

            }).fail(() => {
                Swal.fire("Error", "Unable to save job", "error");
            });
        });
    </script>

    <script>
        $(document).on('click', '.apply-btn', function() {

            let jobId = $(this).data('job-id');
            let companyId = $(this).data('company-id');

            $('#job_id').val(jobId);
            $('#company_id').val(companyId); // <-- FIXED

            $.get("{{ url('/seeker/profile/get') }}", function(res) {

                if (res.success) {
                    $('input[name="seeker_name"]').val(res.data.name);
                    $('input[name="seeker_email"]').val(res.data.email);
                    $('input[name="seeker_phone"]').val(res.data.phone);
                    $('input[name="seeker_experience"]').val(res.data.experience);

                    if (res.data.resume) {
                        $("#resume_info").html("Existing resume: <b>" + res.data.resume + "</b>");
                    }
                }

                $('#applyModal').modal('show');
            });

        });
    </script>

    <script>
        $("#applyForm").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('seeker.job.apply') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                success: function(res) {
                    $(".text-danger").remove(); // remove old error messages

                    Swal.fire("Success", "Application submitted!", "success");
                    $("#applyModal").modal("hide");
                    $("#applyForm")[0].reset();
                },

                error: function(xhr) {
                    $(".text-danger").remove();

                    // --- HANDLE VALIDATION ERRORS ONLY ---
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.after('<small class="text-danger">' + messages[0] +
                                '</small>');
                        });

                        return; // ⛔ DO NOT show sweetalert for validation
                    }

                    // --- HANDLE OTHER ERRORS ---
                    Swal.fire("Error", "Something went wrong", "error");
                }
            });
        });


        // Remove validation error when user types
        $(document).on('input change', 'input, textarea', function() {
            $(this).next('.text-danger').remove(); // remove error message
            $(this).removeClass('is-invalid'); // remove red border
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</x-seeker_layout>
