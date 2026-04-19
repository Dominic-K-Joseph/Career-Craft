<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Job::query()->where('status', 1);

        // ✅ Apply search filter if present
        if ($request->filled('search')) {
            $query->where('job_name', 'like', '%' . $request->search . '%');
        }

        // ✅ Filter by job type if selected
        if ($request->filled('job_filter')) {
            $query->where('job_type', $request->job_filter);
        }
        $job_types = ['Full-Time', 'Part-Time', 'Internship', 'Contract'];

        $jobs = $query->latest()->paginate(10);

        return view('employer.job', compact('jobs', 'job_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = DB::table('tbl_location')->pluck('loc_name');
        return view('employer.add_job', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            'job_salary' => [
                'required',
                'regex:/^₹?\s*\d+\s*-\s*₹?\s*\d+$/'
            ],
            'job_location' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'job_expirience' => 'required|string|max:255',
            'job_description' => 'required|string|max:1000',
        ]);

        // ✅ Always get company ID from the logged-in employer
        $companyId = DB::table('tbl_company')
            ->where('login_id', session('login_id'))
            ->value('id');

        if (!$companyId) {
            return back()->with('error', 'Company profile not found. Please complete your company registration.');
        }

        Job::create([
            'company_id' => $companyId,
            'job_name' => $request->job_name,
            'job_salary' => $request->job_salary,
            'job_location' => $request->job_location,
            'job_type' => $request->job_type,
            'job_expirience' => $request->job_expirience,
            'job_description' => $request->job_description,
        ]);

        return redirect()->route('employer.jobs.create')->with('success', 'Job added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::findOrFail($id);
        return view('employer.view_job', compact('job')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);
        $locations = DB::table('tbl_location')->pluck('loc_name');
        return view('employer.edit_job', compact('job', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'job_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            'job_salary' => ['required', 'regex:/^₹?\s*\d+\s*-\s*₹?\s*\d+$/'],
            'job_location' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'job_expirience' => 'required|string|max:255',
            'job_description' => 'required|string|max:1000',
        ]);

        $job->update([
            'job_name' => $request->job_name,
            'job_salary' => $request->job_salary,
            'job_location' => $request->job_location,
            'job_type' => $request->job_type,
            'job_expirience' => $request->job_expirience,
            'job_description' => $request->job_description,
        ]);

        return redirect()->route('employer.jobs.edit', $job->id)
            ->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        $job->update([
            'status' => 0,
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully');
    }
}
