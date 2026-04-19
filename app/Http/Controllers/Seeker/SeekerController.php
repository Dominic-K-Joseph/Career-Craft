<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeekerController extends Controller
{
    public function profile()
    {
        $loginId = session('login_id');

        // Fetch seeker profile
        $seeker = DB::table('tbl_seeker_profile')->where('login_id', $loginId)->first();

        // Fetch active skills (include id + name)
        $skills = DB::table('tbl_skill')
            ->where('login_id', $loginId)
            ->where('status', 1)
            ->select('id', 'skill')
            ->get();

        return view('seeker.profile', compact('seeker', 'skills'));
    }

    public function updateProfile(Request $request)
    {
        $loginId = session('login_id');

        DB::beginTransaction();
        try {
            // --- 1️⃣ Handle Resume Upload ---
            $resumePath = null;
            if ($request->hasFile('seeker_resume')) {
                $file = $request->file('seeker_resume');

                // Validate PDF
                if ($file->getClientOriginalExtension() !== 'pdf') {
                    return back()->withErrors(['seeker_resume' => 'Only PDF files are allowed.']);
                }

                // Generate clean filename
                $namePart = strtolower(str_replace([' ', '-', '_'], '', $request->seeker_name));
                $timestamp = now()->format('Ymd_His');
                $filename = "{$namePart}_resume_{$timestamp}.pdf";

                // Store in storage/app/public/resumes/
                $resumePath = $file->storeAs('resumes', $filename, 'public');
            }

            // --- 1️⃣b Handle Profile Photo Upload ---
            $photoPath = null;
            if ($request->hasFile('seeker_photo')) {
                $photo = $request->file('seeker_photo');

                $validTypes = ['jpg', 'jpeg', 'png'];
                if (!in_array($photo->getClientOriginalExtension(), $validTypes)) {
                    return back()->withErrors(['seeker_photo' => 'Please upload a valid image (JPG, JPEG, or PNG).']);
                }

                $namePart = strtolower(str_replace([' ', '-', '_'], '', $request->seeker_name));
                $timestamp = now()->format('Ymd_His');
                $photoFilename = "{$namePart}_photo_{$timestamp}." . $photo->getClientOriginalExtension();

                // Store inside /public/photos/
                $photoPath = $photo->storeAs('photos', $photoFilename, 'public');
            }

            // --- 2️⃣ Update seeker profile ---
            $existing = DB::table('tbl_seeker_profile')->where('login_id', $loginId)->first();

            DB::table('tbl_seeker_profile')->updateOrInsert(
                ['login_id' => $loginId],
                [
                    'seeker_name' => $request->seeker_name,
                    'seeker_email' => $request->seeker_email,
                    'seeker_phone' => $request->seeker_phone,
                    'seeker_location' => $request->seeker_location,
                    'seeker_education' => $request->seeker_education,
                    'seeker_experience' => $request->seeker_experience,
                    'seeker_address' => $request->seeker_address,
                    'seeker_resume' => $resumePath ?? ($existing->seeker_resume ?? null),
                    'seeker_photo' => $photoPath ?? ($existing->seeker_photo ?? null), // ✅ add this line
                    'updated_at' => now(),
                ]
            );


            // --- 3️⃣ Handle Skills ---
            $skills = json_decode($request->skills, true) ?? [];
            foreach ($skills as $skill) {
                $exists = DB::table('tbl_skill')
                    ->where('login_id', $loginId)
                    ->whereRaw('LOWER(skill) = ?', [strtolower($skill)])
                    ->where('status', 1)
                    ->exists();

                if (!$exists) {
                    DB::table('tbl_skill')->insert([
                        'login_id' => $loginId,
                        'skill' => ucfirst(strtolower($skill)),
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    // deactivate skill
    public function removeSkill($id)
    {
        $updated = DB::table('tbl_skill')
            ->where('id', $id)
            ->update(['status' => 0, 'updated_at' => now()]);

        return response()->json(['success' => $updated ? true : false]);
    }
}
