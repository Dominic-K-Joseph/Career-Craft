<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Job;

class EmployerDashboardController extends Controller
{
    public function dashboard()
    {
        // Get logged-in employer ID from session
        $loginId = session('login_id');

        // Fetch company ID linked to this employer
        $companyId = DB::table('tbl_company')
            ->where('login_id', $loginId)
            ->value('id');

        // Count how many jobs this company has posted
        $totalJobs = 0;
        if ($companyId) {
            $totalJobs = Job::where('company_id', $companyId)->count();
        }

        // Pass both to the view
        return view('employer.dashboard', compact('companyId', 'totalJobs'));
    }
}
