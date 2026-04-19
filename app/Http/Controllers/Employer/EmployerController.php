<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployerController extends Controller
{
    public function edit()
    {
        $loginId = session('login_id');
        $company = DB::table('tbl_company')->where('login_id', $loginId)->first();

        return view('employer.profile', compact('company'));
    }

    public function update(Request $request)
    {
        $loginId = session('login_id');

        $request->validate([
            'company_title' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:15',
            'company_location' => 'required|string|max:255',
            'company_year' => 'required|integer|min:1900|max:' . date('Y'),
            'company_details' => 'nullable|string',
        ], [
            'company_title.required' => 'Please enter the company title.',
            'company_title.string' => 'Company title must be a valid string.',
            'company_title.max' => 'Company title cannot exceed 255 characters.',

            'company_logo.image' => 'Logo must be an image file.',
            'company_logo.mimes' => 'Logo must be a file of type: jpg, jpeg, png.',
            'company_logo.max' => 'Logo size cannot exceed 2MB.',

            'company_email.required' => 'Please enter the company email.',
            'company_email.email' => 'Please enter a valid email address.',
            'company_email.max' => 'Email cannot exceed 255 characters.',

            'company_phone.required' => 'Please enter the company phone number.',
            'company_phone.string' => 'Phone number must be a valid string.',
            'company_phone.max' => 'Phone number cannot exceed 15 characters.',

            'company_location.required' => 'Please enter the company location.',
            'company_location.string' => 'Location must be a valid string.',
            'company_location.max' => 'Location cannot exceed 255 characters.',

            'company_year.required' => 'Please enter the established year.',
            'company_year.integer' => 'Year must be a valid number.',
            'company_year.min' => 'Year cannot be before 1900.',
            'company_year.max' => 'Year cannot be in the future.',

            'company_details.string' => 'Company details must be text.',
        ]);


        $data = $request->except(['_token', 'company_logo']);

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = time() . '_' . strtolower(str_replace(' ', '_', $file->getClientOriginalName()));

            // Delete old logo
            $oldLogo = DB::table('tbl_company')->where('login_id', $loginId)->value('company_logo');
            if (!empty($oldLogo) && Storage::exists('public/' . $oldLogo)) {
                Storage::delete('public/' . $oldLogo);
            }

            // Store new logo
            $file->storeAs('public/company_logos', $filename);
            $data['company_logo'] = 'company_logos/' . $filename; // <-- NO 'storage/' prefix
        }

        DB::table('tbl_company')->where('login_id', $loginId)->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}
