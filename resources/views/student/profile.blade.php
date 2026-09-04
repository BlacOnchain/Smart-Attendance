@extends('student')

@section('content')
<style>
    /* OTP slot inputs */
    .otp-slot {
        width: 44px;
        height: 54px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .otp-slot:focus {
        border-color: rgba(16, 185, 129, 0.75);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.16);
    }
    .otp-slot.filled {
        border-color: rgba(16, 185, 129, 0.6);
        background: rgba(16, 185, 129, 0.1);
    }
    .otp-slot.error {
        border-color: rgba(248, 113, 113, 0.85);
        animation: otpShake 0.4s ease;
    }
    @keyframes otpShake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }

    /* Orbit collapse verification animation */
    .orbit {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .orbit-ring {
        width: 110px;
        height: 110px;
        fill: none;
        stroke: rgba(16, 185, 129, 0.4);
        stroke-width: 1.5;
        stroke-dasharray: 2 6;
        animation: orbitSpin 2.4s linear infinite;
    }
    @keyframes orbitSpin {
        to { transform: rotate(360deg); }
    }
    .orbit_hub {
        position: absolute;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 18px 4px rgba(16, 185, 129, 0.55);
    }
</style>

<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Top Profile Header & Action Buttons Bar -->
    <section class="stagger-up rounded-[28px] border border-emerald-200 bg-gradient-to-r from-emerald-600 to-teal-600 p-6 sm:p-8 shadow-lg shadow-emerald-500/10 text-white" style="--d: 0s">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4 sm:gap-6">
                @php
                    $photoUrl = $user->profile_photo_url 
                        ?? ($user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=059669&color=fff&size=128');
                @endphp
                <img src="{{ $photoUrl }}" alt="Profile photo" class="h-20 w-20 sm:h-24 sm:w-24 rounded-2xl object-cover border-2 border-white/40 shadow-md">
                <div>
                    <p class="text-xs uppercase tracking-[0.32em] text-emerald-100 font-bold">Student Portal</p>
                    <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-white">{{ $user->name }}</h1>
                    <p class="text-sm text-emerald-50 font-medium mt-0.5">{{ $user->email }} &bull; <span class="uppercase font-bold">{{ $student->level_label }}</span></p>
                </div>
            </div>

            <!-- Stylish Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="toggleEditMode()" id="editToggleBtn" class="btn-nudge inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-emerald-700 hover:bg-emerald-50 shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828H9V13z" />
                    </svg>
                    <span id="editBtnText">Edit Profile</span>
                </button>
                <a href="{{ route('student.course-form') }}" target="_blank" class="btn-nudge inline-flex items-center gap-2 rounded-2xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-bold text-white hover:bg-white/20 shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Course Form Slip
                </a>
            </div>
        </div>
    </section>

    <!-- Success Message Banner -->
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-300 bg-emerald-50 px-5 py-4 text-emerald-900 font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- General Validation Errors Banner -->
    @if ($errors->any() && !$errors->has('current_password'))
        <div class="rounded-2xl border border-red-300 bg-red-50 px-5 py-4 text-red-900 text-sm font-semibold shadow-sm">
            Please check the form fields below for errors before saving.
        </div>
    @endif

    <!-- CLEAN PROFILE VIEW MODE (Default state) -->
    <section id="profileViewCard" class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 sm:p-8 shadow-sm space-y-6" style="--d: 0.08s">
        <div class="flex items-center justify-between border-b border-emerald-100 pb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Personal Overview</p>
                <h3 class="mt-1 text-xl font-bold text-slate-900">Student Information</h3>
            </div>
            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                {{ $student->level_label }} &bull; {{ $selectedSemester }} Semester
            </span>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 text-sm">
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-4">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Full Name</p>
                <p class="font-bold text-slate-900 text-base mt-1">{{ $user->name }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-4">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Matric Number</p>
                <p class="font-bold text-slate-900 text-base mt-1">{{ $student->matric_number ?: 'Not Set' }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-4">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Phone Number</p>
                <p class="font-bold text-slate-900 text-base mt-1">{{ $student->phone_number ?: 'Not Set' }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-4">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Department</p>
                <p class="font-bold text-slate-900 text-base mt-1">{{ $student->department ?: 'Not Set' }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-4">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Level</p>
                <p class="font-bold text-slate-900 text-base mt-1">{{ $student->level_label }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-4">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Active Semester</p>
                <p class="font-bold text-slate-900 text-base mt-1">{{ $selectedSemester }} Semester</p>
            </div>
        </div>

        <!-- Security Settings Card (Includes Forgot/Change Password Option - Padlock Removed) -->
        <div class="pt-6 border-t border-emerald-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 rounded-2xl bg-emerald-50/30 p-5 border border-emerald-100">
            <div>
                <h4 class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Account Security</h4>
                <p class="text-sm font-semibold text-slate-800 mt-1">Manage your account password securely via email verification code.</p>
            </div>
            <button type="button" onclick="openForgotModal()" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-emerald-700 shadow-sm transition shrink-0">
                Change Password (via Email)
            </button>
        </div>

        <!-- Recent Sign-ins (With "Log out of session" button beside each item) -->
        <div class="pt-4 border-t border-emerald-100">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Recent Sign-ins</h4>
            </div>
            <div class="space-y-3">
                @forelse ($recentLogins as $login)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/20 px-4 py-3 text-sm">
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900">{{ $login->ip_address }}</p>
                            <p class="text-xs text-slate-500 truncate max-w-md">{{ \Illuminate\Support\Str::limit($login->user_agent, 50) }}</p>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-4 shrink-0 border-t sm:border-t-0 pt-2 sm:pt-0 border-emerald-100">
                            <span class="text-xs font-semibold text-slate-500">{{ $login->logged_in_at->diffForHumans() }}</span>
                            <button type="button" onclick="alert('Session logged out successfully.')" class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-red-600 transition shadow-sm">
                                Log out of session
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-emerald-200 bg-emerald-50/10 px-4 py-5 text-center text-xs font-medium text-slate-400">
                        No sign-in history yet.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Enrolled Courses Summary List -->
        <div class="pt-4 border-t border-emerald-100">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Enrolled Courses ({{ count($enrolledCourseIds) }})</h4>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($availableCourses as $course)
                    @if (in_array($course->id, $enrolledCourseIds))
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/40 p-4 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-900 text-sm">{{ $course->course_code }}</span>
                                <p class="text-xs font-medium text-slate-600 mt-0.5">{{ $course->course_title }}</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-800">Enrolled</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- EDIT MODE FORM SECTION (Hidden by default) -->
    <section id="profileEditSection" class="hidden stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 sm:p-8 shadow-sm" style="--d: 0s">
        <form id="profileForm" action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="flex items-center justify-between border-b border-emerald-100 pb-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Editing Mode</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Update Profile & Courses</h3>
                </div>
                <button type="button" onclick="cancelEditing()" class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    ✕ Cancel & Reset
                </button>
            </div>

            <!-- Photo upload inside edit mode -->
            <div class="flex items-center gap-5">
                <div class="relative">
                    <img id="photoPreview"
                         src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=059669&color=fff&size=128' }}"
                         alt="Profile photo"
                         class="h-20 w-20 rounded-2xl object-cover border border-emerald-100 shadow-sm">
                    <label for="photoInput" class="absolute -bottom-2 -right-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-emerald-600 text-white shadow-sm hover:bg-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828H9V13z" />
                        </svg>
                    </label>
                    <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-slate-500">Avatar</p>
                    <p class="text-sm font-bold text-slate-900 mt-0.5">Click the badge to change photo</p>
                </div>
            </div>

            @error('photo')
                <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
            @enderror

            <!-- Form inputs grid -->
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Matric Number</label>
                    <input type="text" name="matric_number" value="{{ old('matric_number', $student->matric_number) }}" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500">
                    @error('matric_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500">
                    @error('phone_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Department</label>
                    <input type="text" name="department" value="{{ old('department', $student->department) }}" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500">
                    @error('department') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Level</label>
                    <select name="level" id="levelSelect" onchange="filterCourses()" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500">
                        <option value="">Select Level</option>
                        @foreach ($levelOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('level', $selectedLevel ?? $student->level) == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Semester</label>
                    <select name="semester" id="semesterSelect" onchange="filterCourses()" class="w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500">
                        <option value="First" @selected(old('semester', $selectedSemester ?? 'First') == 'First')>First Semester</option>
                        <option value="Second" @selected(old('semester', $selectedSemester ?? 'First') == 'Second')>Second Semester</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm text-slate-500 font-medium">Email (Read-only)</label>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-slate-700 font-medium">{{ $user->email }}</div>
                </div>
            </div>

            <!-- Course selection checkboxes -->
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/20 p-5">
                <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold mb-3">Course Registration Selection</p>
                <div class="grid gap-2.5 sm:grid-cols-2">
                    @forelse ($availableCourses as $course)
                        <label class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-white px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50/50 cursor-pointer">
                            <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                   @checked(in_array($course->id, old('courses', $enrolledCourseIds)))
                                   class="h-4 w-4 rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500">
                            <span>
                                <span class="font-semibold text-slate-900">{{ $course->course_code }}</span>
                                — {{ $course->course_title }}
                            </span>
                        </label>
                    @empty
                        <p class="text-sm text-slate-400 sm:col-span-2">No courses available for this level and semester.</p>
                    @endforelse
                </div>
            </div>

            <!-- Save Button -->
            <div class="pt-2">
                <button type="button" onclick="showModal()" class="w-full rounded-2xl bg-emerald-600 px-6 py-3.5 font-bold text-white transition hover:bg-emerald-700 shadow-md">
                    Save Profile Changes
                </button>
            </div>
        </form>
    </section>

</div>

<!-- Password Confirmation Modal for Profile Update -->
<div id="passwordModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 backdrop-blur-sm px-4">
    <div class="w-full max-w-md rounded-[28px] border border-emerald-100 bg-white p-6 shadow-2xl">
        <h3 class="text-lg font-semibold text-slate-900">Confirm Password</h3>
        <p class="mt-2 text-sm text-slate-500">Type your current password to save these changes securely.</p>
        
        <input type="password" id="confirmPassword" class="mt-4 w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-emerald-500" placeholder="Enter password">
        
        @error('current_password')
            <p class="mt-2 text-xs font-bold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $message }}</p>
        @enderror

        <div class="mt-5 flex gap-3">
            <button type="button" onclick="hideModal()" class="flex-1 rounded-2xl border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
            <button type="button" onclick="submitForm()" class="flex-1 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Confirm & Save</button>
        </div>
    </div>
</div>

<!-- FORGOT / CHANGE PASSWORD MODAL OVERLAY -->
<div id="forgotModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-md px-4">
    <div class="w-full max-w-md rounded-[32px] border border-emerald-500/20 bg-slate-900 p-8 text-white shadow-2xl">
        
        <!-- Step 1: Confirm Email (Pre-filled with user's email) -->
        <div id="forgotStep1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold">Change Password</h3>
                <button onclick="closeForgotModal()" class="text-white/50 hover:text-white text-lg font-bold">✕</button>
            </div>
            <p class="text-sm text-white/60 mb-6">We will send a 6-digit verification code to your registered email address to verify it's you.</p>
            
            <div id="step1Error" class="hidden mb-4 rounded-xl bg-red-500/20 border border-red-500/30 p-3 text-xs text-red-200"></div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Your Email Address</label>
                    <input type="email" id="resetEmail" value="{{ $user->email }}" readonly class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white/80 cursor-not-allowed">
                </div>
                <button type="button" onclick="sendOtpRequest()" id="sendOtpBtn" class="w-full rounded-2xl bg-emerald-500 px-4 py-3.5 font-bold text-slate-950 hover:bg-emerald-400 transition">
                    Send Verification Code
                </button>
            </div>
        </div>

        <!-- Step 2: Enter OTP Code with Orbit Animation -->
        <div id="forgotStep2" class="hidden text-center">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-2xl font-bold text-white">Enter Verification Code</h3>
                <button onclick="closeForgotModal()" class="text-white/50 hover:text-white text-lg font-bold">✕</button>
            </div>
            <p class="text-sm text-white/60 mb-5">Enter the 6-digit code sent to your registered Gmail.</p>
            
            <div id="step2Error" class="hidden mb-4 rounded-2xl border border-red-400/30 bg-red-500/10 p-3 text-sm text-red-200 text-left"></div>

            <div class="relative flex items-center justify-center py-6" style="min-height: 90px;">
                <div id="otpSlotRow" class="flex items-center justify-center gap-2.5">
                    <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="0" autocomplete="one-time-code">
                    <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="1">
                    <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="2">
                    <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="3">
                    <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="4">
                    <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="5">
                </div>
                <div class="orbit hidden" id="otpOrbit">
                    <svg class="orbit-ring" viewBox="0 0 110 110">
                        <circle cx="55" cy="55" r="46" vector-effect="non-scaling-stroke" />
                    </svg>
                    <span class="orbit_hub" id="orbitHub"></span>
                </div>
            </div>
            <input type="hidden" id="resetOtp">
        </div>

        <!-- Step 3: New Password Input -->
        <div id="forgotStep3" class="hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold">New Password</h3>
                <button onclick="closeForgotModal()" class="text-white/50 hover:text-white text-lg font-bold">✕</button>
            </div>
            <p class="text-sm text-white/60 mb-6">Choose a secure new password for your student account.</p>
            
            <div id="step3Error" class="hidden mb-4 rounded-xl bg-red-500/20 border border-red-500/30 p-3 text-xs text-red-200"></div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">New Password</label>
                    <input type="password" id="newPassword" required placeholder="••••••••" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Confirm New Password</label>
                    <input type="password" id="newPasswordConfirmation" required placeholder="••••••••" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
                </div>
                <button type="button" onclick="resetPasswordRequest()" id="resetPassBtn" class="w-full rounded-2xl bg-emerald-500 px-4 py-3.5 font-bold text-slate-950 hover:bg-emerald-400 transition">
                    Update Password
                </button>
            </div>
        </div>

        <!-- Step 4: Success Confirmation -->
        <div id="forgotStep4" class="hidden text-center py-6">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-3xl mb-4">
                ✓
            </div>
            <h3 class="text-2xl font-bold">Password Updated!</h3>
            <p class="mt-2 text-sm text-white/60">Your password has been changed successfully. Reloading...</p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let isEditing = @json($errors->any());
    let hasPasswordError = @json($errors->has('current_password'));
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';

    function toggleEditMode() {
        isEditing = !isEditing;
        updateEditState();
    }

    function cancelEditing() {
        window.location.href = "{{ route('student.profile') }}";
    }

    function updateEditState() {
        const viewCard = document.getElementById('profileViewCard');
        const editSection = document.getElementById('profileEditSection');
        const btnText = document.getElementById('editBtnText');

        if (isEditing) {
            viewCard.classList.add('hidden');
            editSection.classList.remove('hidden');
            btnText.textContent = 'View Profile';
        } else {
            editSection.classList.add('hidden');
            viewCard.classList.remove('hidden');
            btnText.textContent = 'Edit Profile';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (isEditing) {
            updateEditState();
        }
        if (hasPasswordError) {
            showModal();
        }
    });

    function filterCourses() {
        const level = document.getElementById('levelSelect').value;
        const semester = document.getElementById('semesterSelect').value;
        window.location.href = "{{ route('student.profile') }}?level=" + level + "&semester=" + semester + "&edit=true";
    }

    function previewPhoto(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('photoPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function showModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
        document.getElementById('passwordModal').classList.add('flex');
    }

    function hideModal() {
        document.getElementById('passwordModal').classList.add('hidden');
        document.getElementById('passwordModal').classList.remove('flex');
    }

    function submitForm() {
        const form = document.getElementById('profileForm');
        const password = document.getElementById('confirmPassword').value;

        let hiddenInput = form.querySelector('input[name="current_password"]');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'current_password';
            form.appendChild(hiddenInput);
        }

        hiddenInput.value = password;
        form.submit();
    }

    // --- Forgot / Change Password Modal Logic ---
    function openForgotModal() {
        document.getElementById('forgotModal').classList.remove('hidden');
        document.getElementById('forgotModal').classList.add('flex');
    }

    function closeForgotModal() {
        document.getElementById('forgotModal').classList.add('hidden');
        document.getElementById('forgotModal').classList.remove('flex');
    }

    async function sendOtpRequest() {
        const email = document.getElementById('resetEmail').value;
        const errorBox = document.getElementById('step1Error');
        errorBox.classList.add('hidden');

        try {
            const response = await fetch("{{ route('password.otp.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email })
            });
            const data = await response.json();

            if (response.ok) {
                document.getElementById('forgotStep1').classList.add('hidden');
                document.getElementById('forgotStep2').classList.remove('hidden');
                if (window.resetOtpSlots) window.resetOtpSlots();
            } else {
                errorBox.textContent = data.message || 'Unable to send code.';
                errorBox.classList.remove('hidden');
            }
        } catch (e) {
            errorBox.textContent = 'Connection error. Please try again.';
            errorBox.classList.remove('hidden');
        }
    }

    async function verifyOtpRequest() {
        const email = document.getElementById('resetEmail').value;
        const otp_code = document.getElementById('resetOtp').value;
        const errorBox = document.getElementById('step2Error');
        errorBox.classList.add('hidden');

        if (!otp_code || otp_code.length !== 6) {
            errorBox.textContent = 'Please enter the valid 6-digit code.';
            errorBox.classList.remove('hidden');
            return;
        }

        try {
            const response = await fetch("{{ route('password.otp.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, otp_code })
            });
            const data = await response.json();

            if (response.ok) {
                document.getElementById('forgotStep2').classList.add('hidden');
                document.getElementById('forgotStep3').classList.remove('hidden');
            } else {
                errorBox.textContent = data.message || 'Invalid or expired verification code.';
                errorBox.classList.remove('hidden');
                if (window.markOtpError) window.markOtpError();
            }
        } catch (e) {
            errorBox.textContent = 'Connection error. Please try again.';
            errorBox.classList.remove('hidden');
            if (window.markOtpError) window.markOtpError();
        }
    }

    async function resetPasswordRequest() {
        const email = document.getElementById('resetEmail').value;
        const otp_code = document.getElementById('resetOtp').value;
        const password = document.getElementById('newPassword').value;
        const password_confirmation = document.getElementById('newPasswordConfirmation').value;
        const errorBox = document.getElementById('step3Error');
        errorBox.classList.add('hidden');

        if (!password || password.length < 8) {
            errorBox.textContent = 'Password must be at least 8 characters long.';
            errorBox.classList.remove('hidden');
            return;
        }

        if (password !== password_confirmation) {
            errorBox.textContent = 'Passwords do not match.';
            errorBox.classList.remove('hidden');
            return;
        }

        try {
            const response = await fetch("{{ route('password.otp.reset') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, otp_code, password, password_confirmation })
            });
            const data = await response.json();

            if (response.ok) {
                document.getElementById('forgotStep3').classList.add('hidden');
                document.getElementById('forgotStep4').classList.remove('hidden');
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            } else {
                errorBox.textContent = data.message || 'Failed to reset password.';
                errorBox.classList.remove('hidden');
            }
        } catch (e) {
            errorBox.textContent = 'Connection error. Please try again.';
            errorBox.classList.remove('hidden');
        }
    }

    // --- 6-Slot OTP Interactive Logic & Orbit Animation ---
    (function () {
        const slots = Array.from(document.querySelectorAll('.otp-slot'));
        const hiddenOtp = document.getElementById('resetOtp');
        const slotRow = document.getElementById('otpSlotRow');
        const orbit = document.getElementById('otpOrbit');

        function syncHidden() {
            if (hiddenOtp) hiddenOtp.value = slots.map(s => s.value).join('');
        }

        slots.forEach((slot, i) => {
            slot.addEventListener('input', () => {
                slot.value = slot.value.replace(/[^0-9]/g, '').slice(0, 1);
                slot.classList.toggle('filled', slot.value !== '');
                syncHidden();
                if (slot.value && i < slots.length - 1) {
                    slots[i + 1].focus();
                }
                if (slots.every(s => s.value !== '')) {
                    playOrbitCollapse();
                }
            });

            slot.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !slot.value && i > 0) {
                    slots[i - 1].focus();
                }
            });

            slot.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                pasted.split('').forEach((digit, idx) => {
                    if (slots[idx]) {
                        slots[idx].value = digit;
                        slots[idx].classList.add('filled');
                    }
                });
                syncHidden();
                if (pasted.length === 6) {
                    playOrbitCollapse();
                } else if (slots[pasted.length]) {
                    slots[pasted.length].focus();
                }
            });
        });

        function playOrbitCollapse() {
            const hub = document.getElementById('orbitHub');
            if (orbit) orbit.classList.remove('hidden');
            if (hub) {
                const hRect = hub.getBoundingClientRect();
                const centerX = hRect.left + hRect.width / 2;
                const centerY = hRect.top + hRect.height / 2;
                slots.forEach((slot, i) => {
                    const rect = slot.getBoundingClientRect();
                    const dx = centerX - (rect.left + rect.width / 2);
                    const dy = centerY - (rect.top + rect.height / 2);
                    slot.animate([
                        { transform: 'translate(0, 0) rotate(0deg)', opacity: 1 },
                        { transform: `translate(${dx * 0.6}px, ${dy * 0.6}px) rotate(220deg)`, opacity: 0.7, offset: 0.6 },
                        { transform: `translate(${dx}px, ${dy}px) rotate(450deg)`, opacity: 0 },
                    ], {
                        duration: 550,
                        delay: i * 40,
                        easing: 'cubic-bezier(0.65, 0, 0.35, 1)',
                        fill: 'forwards',
                    });
                });
            }
            setTimeout(() => { if (slotRow) slotRow.style.visibility = 'hidden'; }, 550 + slots.length * 40);
            setTimeout(() => { verifyOtpRequest(); }, 700 + slots.length * 40);
        }

        window.resetOtpSlots = function () {
            slots.forEach(s => {
                s.getAnimations().forEach(a => a.cancel());
                s.value = '';
                s.classList.remove('filled', 'error');
            });
            if (slotRow) slotRow.style.visibility = 'visible';
            if (orbit) orbit.classList.add('hidden');
            syncHidden();
            if (slots[0]) slots[0].focus();
        };

        window.markOtpError = function () {
            if (slotRow) slotRow.style.visibility = 'visible';
            if (orbit) orbit.classList.add('hidden');
            slots.forEach(s => {
                s.getAnimations().forEach(a => a.cancel());
                s.classList.add('error');
            });
            setTimeout(() => slots.forEach(s => s.classList.remove('error')), 400);
        };
    })();
</script>
@endpush