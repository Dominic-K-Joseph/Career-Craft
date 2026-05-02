<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserActivityLog;

class SeekerController extends Controller
{
    public function profile()
    {
        $loginId = session('login_id');

        $seeker = DB::table('tbl_seeker_profile')->where('login_id', $loginId)->first();

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

                if ($file->getClientOriginalExtension() !== 'pdf') {
                    return back()->withErrors(['seeker_resume' => 'Only PDF files are allowed.']);
                }

                $namePart = strtolower(str_replace([' ', '-', '_'], '', $request->seeker_name));
                $timestamp = now()->format('Ymd_His');
                $filename = "{$namePart}_resume_{$timestamp}.pdf";
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
                $photoPath = $photo->storeAs('photos', $photoFilename, 'public');
            }

            // --- 2️⃣ Update seeker profile ---
            $existing = DB::table('tbl_seeker_profile')->where('login_id', $loginId)->first();

            DB::table('tbl_seeker_profile')->updateOrInsert(
                ['login_id' => $loginId],
                [
                    'seeker_name'       => $request->seeker_name,
                    'seeker_email'      => $request->seeker_email,
                    'seeker_phone'      => $request->seeker_phone,
                    'seeker_location'   => $request->seeker_location,
                    'seeker_education'  => $request->seeker_education,
                    'seeker_experience' => $request->seeker_experience,
                    'seeker_address'    => $request->seeker_address,
                    'seeker_resume'     => $resumePath ?? ($existing->seeker_resume ?? null),
                    'seeker_photo'      => $photoPath ?? ($existing->seeker_photo ?? null),
                    'updated_at'        => now(),
                ]
            );

            // --- 3️⃣ Handle Skills ---
            $skills = json_decode($request->skills, true) ?? [];
            $newSkillsAdded = [];

            foreach ($skills as $skill) {
                $exists = DB::table('tbl_skill')
                    ->where('login_id', $loginId)
                    ->whereRaw('LOWER(skill) = ?', [strtolower($skill)])
                    ->where('status', 1)
                    ->exists();

                if (!$exists) {
                    DB::table('tbl_skill')->insert([
                        'login_id'   => $loginId,
                        'skill'      => ucfirst(strtolower($skill)),
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $newSkillsAdded[] = ucfirst(strtolower($skill));
                }
            }

            DB::commit();

            // ✅ Build a meaningful description of what changed
            $changes = [];
            if ($resumePath) $changes[] = 'resume uploaded';
            if ($photoPath)  $changes[] = 'photo uploaded';
            if (!empty($newSkillsAdded)) $changes[] = 'skills added: ' . implode(', ', $newSkillsAdded);
            if (empty($changes)) $changes[] = 'profile details updated';

            $this->logActivity($loginId, 'profile_updated', implode(' | ', $changes));

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function removeSkill($id)
    {
        $loginId = session('login_id');

        // Fetch skill name before deactivating for the log
        $skill = DB::table('tbl_skill')->where('id', $id)->first();

        $updated = DB::table('tbl_skill')
            ->where('id', $id)
            ->update(['status' => 0, 'updated_at' => now()]);

        // ✅ Log skill removal
        if ($updated && $skill) {
            $this->logActivity($loginId, 'skill_removed', "Removed skill: {$skill->skill} (ID: {$id})");
        }

        return response()->json(['success' => $updated ? true : false]);
    }

    /**
     * Log seeker activity to UserActivityLog.
     */
    private function logActivity(int $loginId, string $action, string $description = '')
    {
        $user = DB::table('tbl_login')->where('id', $loginId)->first();

        if (!$user) return;

        UserActivityLog::create([
            'user_id'     => $loginId,
            'name'        => $user->username,
            'role'        => $user->role,
            'action'      => $action,
            'description' => $description,
        ]);
    }
}