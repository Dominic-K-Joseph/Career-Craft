<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Job;
use App\Models\SavedJobs;
use App\Models\SeekerProfile;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $loginId = session('login_id');

        // Fetch seeker profile (auto-fill data)
        $seeker = null;
        $seekerId = null;

        if ($loginId) {
            $seeker = SeekerProfile::where('login_id', $loginId)->first();
            $seekerId = $seeker ? $seeker->id : null;
        }

        // Fetch jobs
        $query = Job::query()
            ->select(
                'tbl_job.id as job_id',
                'tbl_job.job_name',
                'tbl_job.job_salary',
                'tbl_job.job_location',
                'tbl_job.job_type',
                'tbl_job.job_expirience',
                'tbl_job.job_description',
                'tbl_job.status',
                'tbl_job.company_id',
                'tbl_company.company_title'
            )
            ->leftJoin('tbl_company', 'tbl_job.company_id', '=', 'tbl_company.id')
            ->where('tbl_job.status', 1)
            ->orderByDesc('tbl_job.id');

        // Search filters
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('tbl_job.job_name', 'like', '%' . $request->q . '%')
                    ->orWhere('tbl_job.job_description', 'like', '%' . $request->q . '%')
                    ->orWhere('tbl_company.company_title', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('tbl_job.job_location', 'like', '%' . $request->location . '%');
        }

        $jobs = $query->get();

        // Get saved jobs (status = 1)
        $savedJobIds = [];
        if ($seekerId) {
            $savedJobIds = SavedJobs::where('seeker_id', $seekerId)
                ->where('status', 1)
                ->pluck('job_id')
                ->toArray();
        }

        // Add is_saved flag
        $jobs = $jobs->map(function ($job) use ($savedJobIds) {
            $job->is_saved = in_array($job->job_id, $savedJobIds);
            return $job;
        });

        // Pass seeker profile → for auto-fill
        return view('seeker.view_job', compact('jobs', 'seeker'));
    }



    public function toggleSaveJob(Request $request)
    {
        try {
            $loginId = session('login_id');

            if (!$loginId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in first.'
                ], 401);
            }

            // Get seeker profile
            $seeker = SeekerProfile::where('login_id', $loginId)->first();

            if (!$seeker) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seeker profile not found.'
                ], 400);
            }

            $seekerId = $seeker->id;
            $jobId = $request->job_id;

            if (!$jobId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid job ID.'
                ], 400);
            }

            $saved = SavedJobs::where('seeker_id', $seekerId)
                ->where('job_id', $jobId)
                ->first();

            if ($saved) {
                $saved->status = $saved->status == 1 ? 0 : 1;
                $saved->save();
            } else {
                $saved = SavedJobs::create([
                    'seeker_id' => $seekerId,
                    'job_id' => $jobId,
                    'status' => 1
                ]);
            }

            return response()->json([
                'success' => true,
                'status' => $saved->status,
                'message' => $saved->status ? "Job saved" : "Job removed"
            ]);
        } catch (\Throwable $e) {
            Log::error('Save Job Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    public function applyJob(Request $request)
    {
        try {
            $request->validate([
                'job_id' => 'required|integer',
                'company_id' => 'required|integer',
                'seeker_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
                'seeker_email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'seeker_phone' => 'required|digits_between:10,15',
                'seeker_current_salary' => 'required|integer',
                'seeker_expected_salary' => 'required|integer',
                'seeker_experience' => 'required|integer',
                'cover_letter' => 'required|string',
                'seeker_resume' => 'nullable|file|mimes:pdf|max:2048',
            ], [
                'seeker_name.required' => 'Please enter your full name.',
                'seeker_name.regex' => 'Name can only contain letters, numbers, and spaces.',
                'seeker_email.required' => 'Please enter your email address.',
                'seeker_email.email' => 'Your email format is invalid.',
                'seeker_email.regex' => 'Email format is required.',

                'seeker_phone.required' => 'Please enter your phone number.',
                'seeker_phone.digits_between' => 'Invalid phone number.',

                'seeker_current_salary.required' => 'Please enter your current salary.',
                
                'seeker_expected_salary.required' => 'Please enter expected salary.',

                'seeker_experience.required' => 'Please enter your experience.',

                'cover_letter.required' => 'A cover letter is required.',

                'seeker_resume.mimes' => 'Resume must be a PDF file.',
                'seeker_resume.max' => 'Resume must be less than 2MB.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }


        $loginId = session('login_id');
        if (!$loginId) {
            return response()->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $seeker = SeekerProfile::where('login_id', $loginId)->first();

        if (!$seeker) {
            return response()->json(['success' => false, 'message' => 'Seeker profile not found'], 400);
        }

        // Default: old resume
        $resumePath = $seeker->seeker_resume ?? '';

        // Upload resume
        if ($request->hasFile('seeker_resume')) {
            $file = $request->file('seeker_resume');
            $resumeName = strtolower(str_replace([' ', '-'], '', $request->seeker_name)) . '_' . time() . '.pdf';
            $file->move('uploads/resume/', $resumeName);
            $resumePath = 'uploads/resume/' . $resumeName;
        }

        // Insert application
        DB::table('tbl_job_application')->insert([
            'seeker_id' => $seeker->id,
            'job_id' => $request->job_id,
            'company_id' => $request->company_id,  // IMPORTANT
            'seeker_name' => $request->seeker_name,
            'seeker_current_salary' => $request->seeker_current_salary,
            'seeker_expected_salary' => $request->seeker_expected_salary,
            'seeker_experience' => $request->seeker_experience,
            'cover_letter' => $request->cover_letter,
            'seeker_resume' => $resumePath,
            'created_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Application submitted successfully']);
    }



    public function getSeekerProfile()
    {
        try {
            $loginId = session('login_id');

            if (!$loginId) {
                return response()->json(['success' => false, 'message' => 'Login required']);
            }

            $seeker = SeekerProfile::where('login_id', $loginId)->first();

            if (!$seeker) {
                return response()->json(['success' => false, 'message' => 'Seeker profile not found']);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $seeker->seeker_name,
                    'email' => $seeker->seeker_email,
                    'phone' => $seeker->seeker_phone,
                    'experience' => $seeker->seeker_experience,
                    'resume' => $seeker->seeker_resume,
                ]
            ]);
        } catch (\Throwable $e) {
            Log::error('Profile Fetch Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
