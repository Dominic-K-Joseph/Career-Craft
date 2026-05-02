<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Login;
use App\Models\Company;
use App\Models\SeekerProfile;
use App\Mail\SeekerRegistered;
use App\Mail\EmployerRegistered;
use App\Models\UserActivityLog;

class AuthController extends Controller
{
    public function checkLogin()
    {
        if (!Session::has('login_id') && Cookie::has('remember_login')) {
            $user = Login::find(Cookie::get('remember_login'));
            if ($user) {
                Session::put('login_id', $user->id);
                Session::put('role', $user->role);

                switch (strtolower($user->role)) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'employer':
                        return redirect()->route('employer.index');
                    case 'seeker':
                        return redirect()->route('seeker.index');
                }
            }
        }

        $hasUsers = Login::exists();
        if (!$hasUsers) {
            return redirect()->route('register.form');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Login::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid username or password');
        }

        if ($user->status == 0) {
            return back()->with('error', 'Your account is inactive. Please contact admin.');
        }

        Session::put('login_id', $user->id);
        Session::put('role', $user->role);

        if ($request->has('remember')) {
            Cookie::queue('remember_login', $user->id, 60 * 24 * 7);
        } else {
            Cookie::queue(Cookie::forget('remember_login'));
        }

        $this->logActivity($user, 'login');

        switch (strtolower($user->role)) {
            case 'admin':
                return redirect()->route('admin.index');
            case 'employer':
                return redirect()->route('employer.index');
            case 'seeker':
                return redirect()->route('seeker.index');
            default:
                return redirect()->route('login');
        }
    }

    public function showForgotForm()
    {
        return view('forgot_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Login::where('username', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found in system!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password updated successfully! Please login.');
    }

    public function logout(Request $request)
    {
        Session::forget('login_id');
        Session::forget('role');
        Cookie::queue(Cookie::forget('remember_login'));

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function register(Request $request)
    {
        $role = $request->input('role');

        $request->validate([
            'role' => 'required|in:seeker,employer',

            'seeker_name'       => 'required_if:role,seeker|string|max:255',
            'seeker_email'      => 'required_if:role,seeker|email|unique:tbl_login,username',
            'seeker_password'   => 'required_if:role,seeker|min:6',
            'seeker_phone'      => 'nullable|string|max:20',
            'seeker_address'    => 'nullable|string',
            'seeker_education'  => 'nullable|string',
            'seeker_location'   => 'nullable|string',
            'seeker_experience' => 'nullable|string',
            'seeker_photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'seeker_resume'     => 'nullable|mimes:pdf|max:5120',

            'company_title'    => 'required_if:role,employer|string|max:255',
            'company_email'    => 'required_if:role,employer|email|unique:tbl_login,username',
            'company_password' => 'required_if:role,employer|min:6',
            'company_phone'    => 'nullable|string|max:20',
            'company_location' => 'nullable|string|max:255',
            'company_year'     => 'nullable|string|max:10',
            'company_details'  => 'nullable|string',
            'company_logo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $login = null; // ✅ Initialize so it's always defined

            if ($role === 'seeker') {
                $login = Login::create([
                    'username' => $request->seeker_email,
                    'password' => Hash::make($request->seeker_password),
                    'role'     => 'seeker',
                    'status'   => 1,
                ]);

                $photoPath = $request->hasFile('seeker_photo')
                    ? $request->file('seeker_photo')->store('seeker_photos', 'public')
                    : null;

                $resumePath = $request->hasFile('seeker_resume')
                    ? $request->file('seeker_resume')->store('seeker_resumes', 'public')
                    : null;

                SeekerProfile::create([
                    'login_id'         => $login->id,
                    'seeker_name'      => $request->seeker_name,
                    'seeker_photo'     => $photoPath,
                    'seeker_email'     => $request->seeker_email,
                    'seeker_phone'     => $request->seeker_phone,
                    'seeker_address'   => $request->seeker_address,
                    'seeker_education' => $request->seeker_education,
                    'seeker_location'  => $request->seeker_location,
                    'seeker_experience'=> $request->seeker_experience,
                    'seeker_resume'    => $resumePath,
                    'status'           => 1,
                ]);

                Mail::to($request->seeker_email)->send(new SeekerRegistered($request->seeker_name));
            }

            if ($role === 'employer') {
                $login = Login::create([
                    'username' => $request->company_email,
                    'password' => Hash::make($request->company_password),
                    'role'     => 'employer',
                    'status'   => 1,
                ]);

                $logoPath = $request->hasFile('company_logo')
                    ? $request->file('company_logo')->store('company_logos', 'public')
                    : null;

                Company::create([
                    'login_id'         => $login->id,
                    'company_title'    => $request->company_title,
                    'company_logo'     => $logoPath,
                    'company_email'    => $request->company_email,
                    'company_phone'    => $request->company_phone,
                    'company_location' => $request->company_location,
                    'company_year'     => $request->company_year,
                    'company_details'  => $request->company_details,
                    'status'           => 1,
                ]);

                Mail::to($request->company_email)->send(new EmployerRegistered($request->company_title));
            }

            DB::commit();

            // ✅ Use $login (not $user), and pass username as name since Login has no name field
            if ($login) {
                $this->logActivity($login, 'register');
            }

            return redirect()->route('login')->with('success', 'Registration successful!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }

    private function logActivity($user, $action)
    {
        UserActivityLog::create([
            'user_id' => $user->id,
            // ✅ Login model has no 'name' — use 'username' instead
            'name'    => $user->username,
            'role'    => $user->role,
            'action'  => $action,
        ]);
    }
}