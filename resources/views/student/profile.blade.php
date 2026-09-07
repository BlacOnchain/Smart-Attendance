@extends('student')

@section('content')
<style>
    /* OTP slot inputs — light glass theme, matching the rest of the site */
    .otp-slot {
        width: 44px;
        height: 54px;
        border-radius: 14px;
        background: rgba(255,255,255,0.75);
        border: 1px solid #d7dbd2;
        color: var(--ink);
        font-family: 'IBM Plex Mono', monospace;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .otp-slot:focus {
        border-color: rgba(5,150,105,0.6);
        box-shadow: 0 0 0 4px rgba(5,150,105,0.14);
    }
    .otp-slot.filled {
        border-color: rgba(5,150,105,0.5);
        background: rgba(5,150,105,0.08);
    }
    .otp-slot.error {
        border-color: rgba(190,18,60,0.7);
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
        stroke: rgba(5,150,105,0.45);
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
        background: var(--brand);
        box-shadow: 0 0 18px 4px rgba(5,150,105,0.45);
    }

    .profile-card {
        background: rgba(255,255,255,0.82);
        border: 1px solid rgba(255,255,255,0.95);
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        box-shadow: 0 24px 60px -24px rgba(16,32,26,0.18);
    }
    .info-tile {
        background: rgba(5,150,105,0.05);
        border: 1px solid rgba(5,150,105,0.14);
        border-radius: 16px;
        padding: 14px 16px;
    }
    .eyebrow {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 600;
        color: var(--brand-dark);
        letter-spacing: 0.01em;
    }
</style>

<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Top Profile Header & Action Buttons Bar -->
    <section class="stagger-up rounded-[28px] p-6 sm:p-8 text-white relative overflow-hidden" style="--d: 0s; background: linear-gradient(135deg, #059669, #0d9488 60%, #047857); box-shadow: 0 24px 50px -18px rgba(5,150,105,0.4);">
        <div class="pointer-events-none absolute inset-0 opacity-40" style="background: radial-gradient(420px 300px at 90% -10%, rgba(255,255,255,0.25), transparent 70%);"></div>
        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4 sm:gap-6">
                @php
                    $photoUrl = $user->profile_photo_url
                        ?? ($user->profile_photo_path ? asset('storage/' . $user->profile_photo_path)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=059669&color=fff&size=128');
                @endphp
                <img src="{{ $photoUrl }}" alt="Profile photo" class="h-20 w-20 sm:h-24 sm:w-24 rounded-2xl object-cover border-2 border-white/50 shadow-lg">
                <div>
                    <p class="eyebrow text-emerald-50/90">Student Portal</p>
                    <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-sm text-emerald-50/90 font-medium mt-0.5">{{ $user->email }} &bull; <span class="font-semibold">{{ $student->level_label }}</span></p>
                </div>
            </div>

            <!-- Action Buttons -->
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
    <section id="profileViewCard" class="profile-card stagger-up rounded-[28px] p-6 sm:p-8 space-y-6" style="--d: 0.08s">
        <div class="flex items-center justify-between border-b pb-4" style="border-color: var(--line)">
            <div>
                <p class="eyebrow">Personal overview</p>
                <h3 class="mt-1 text-xl font-bold" style="color: var(--ink)">Student information</h3>
            </div>
            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                {{ $student->level_label }} &bull; {{ $selectedSemester }} Semester
            </span>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 text-sm">
            <div class="info-tile">
                <p class="text-xs font-semibold" style="color: #7a8580">Full name</p>
                <p class="font-bold text-base mt-1" style="color: var(--ink)">{{ $user->name }}</p>
            </div>
            <div class="info-tile">
                <p class="text-xs font-semibold" style="color: #7a8580">Matric number</p>
                <p class="font-bold text-base mt-1" style="color: var(--ink)">{{ $student->matric_number ?: 'Not set' }}</p>
            </div>
            <div class="info-tile">
                <p class="text-xs font-semibold" style="color: #7a8580">Phone number</p>
                <p class="font-bold text-base mt-1" style="color: var(--ink)">{{ $student->phone_number ?: 'Not set' }}</p>
            </div>
            <div class="info-tile">
                <p class="text-xs font-semibold" style="color: #7a8580">Department</p>
                <p class="font-bold text-base mt-1" style="color: var(--ink)">{{ $student->department ?: 'Not set' }}</p>
            </div>
            <div class="info-tile">
                <p class="text-xs font-semibold" style="color: #7a8580">Level</p>
                <p class="font-bold text-base mt-1" style="color: var(--ink)">{{ $student->level_label }}</p>
            </div>
            <div class="info-tile">
                <p class="text-xs font-semibold" style="color: #7a8580">Active semester</p>
                <p class="font-bold text-base mt-1" style="color: var(--ink)">{{ $selectedSemester }} Semester</p>
            </div>
        </div>

        <!-- Security Settings Card -->
        <div class="pt-6 border-t flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 rounded-2xl p-5" style="border-color: var(--line); background: rgba(5,150,105,0.05); border: 1px solid rgba(5,150,105,0.14);">
            <div>
                <h4 class="eyebrow">Account security</h4>
                <p class="text-sm font-semibold mt-1" style="color: var(--ink)">Manage your account password securely via email verification code.</p>
            </div>
            <button type="button" onclick="openForgotModal()" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-emerald-700 shadow-sm transition shrink-0">
                Change password
            </button>
        </div>

        <!-- Recent Sign-ins (With "Log out of session" button beside each item) -->
        <div class="pt-4 border-t" style="border-color: var(--line)">
            <div class="flex items-center justify-between mb-4">
                <h4 class="eyebrow">Recent sign-ins</h4>
            </div>
            <div class="space-y-3" id="recentLoginsList">
                @forelse ($recentLogins as $login)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-2xl px-4 py-3 text-sm info-tile" data-login-row="{{ $login->id }}">
                        <div class="min-w-0">
                            <p class="font-semibold flex items-center gap-2" style="color: var(--ink)">
                                {{ $login->ip_address }}
                                @if ($login->session_id && $login->session_id === $currentSessionId)
                                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-emerald-700">This device</span>
                                @endif
                            </p>
                            <p class="text-xs truncate max-w-md" style="color: #7a8580">{{ \Illuminate\Support\Str::limit($login->user_agent, 50) }}</p>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-4 shrink-0 border-t sm:border-t-0 pt-2 sm:pt-0" style="border-color: var(--line)">
                            <span class="text-xs font-semibold" style="color: #9aa39c">{{ $login->logged_in_at->diffForHumans() }}</span>
                            @if ($login->session_id && $login->session_id === $currentSessionId)
                                <span class="text-xs font-semibold px-3 py-1.5" style="color: #9aa39c">Active now</span>
                            @else
                                <button type="button" onclick="logoutSession({{ $login->id }}, this)" class="rounded-xl border bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-red-600 transition shadow-sm" style="border-color: var(--line)">
                                    Log out of session
                                </button>
                            @endif
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
        <div class="pt-4 border-t" style="border-color: var(--line)">
            <div class="flex items-center justify-between mb-4">
                <h4 class="eyebrow">Enrolled courses ({{ count($enrolledCourseIds) }})</h4>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($availableCourses as $course)
                    @if (in_array($course->id, $enrolledCourseIds))
                        <div class="info-tile flex items-center justify-between">
                            <div>
                                <span class="font-bold text-sm" style="color: var(--ink)">{{ $course->course_code }}</span>
                                <p class="text-xs font-medium mt-0.5" style="color: #7a8580">{{ $course->course_title }}</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-800">Enrolled</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- EDIT MODE FORM SECTION (Hidden by default) -->
    <section id="profileEditSection" class="hidden profile-card stagger-up rounded-[28px] p-6 sm:p-8" style="--d: 0s">
        <form id="profileForm" action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="flex items-center justify-between border-b pb-4" style="border-color: var(--line)">
                <div>
                    <p class="eyebrow">Editing mode</p>
                    <h3 class="mt-1 text-xl font-bold" style="color: var(--ink)">Update profile & courses</h3>
                </div>
                <button type="button" onclick="cancelEditing()" class="rounded-xl border px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50" style="border-color: var(--line)">
                    ✕ Cancel & reset
                </button>
            </div>

            <!-- Photo upload inside edit mode -->
            <div class="flex items-center gap-5">
                <div class="relative">
                    <img id="photoPreview"
                         src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=059669&color=fff&size=128' }}"
                         alt="Profile photo"
                         class="h-20 w-20 rounded-2xl object-cover border shadow-sm" style="border-color: var(--line)">
                    <label for="photoInput" class="absolute -bottom-2 -right-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-emerald-600 text-white shadow-sm hover:bg-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828H9V13z" />
                        </svg>
                    </label>
                    <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                </div>
                <div>
                    <p class="text-xs font-semibold" style="color: #9aa39c">Avatar</p>
                    <p class="text-sm font-bold mt-0.5" style="color: var(--ink)">Click the badge to change photo</p>
                </div>
            </div>

            @error('photo')
                <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
            @enderror

            <!-- Form inputs grid -->
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="glass-input w-full rounded-2xl px-4 py-3">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="field-label">Matric number</label>
                    <input type="text" name="matric_number" value="{{ old('matric_number', $student->matric_number) }}" class="glass-input w-full rounded-2xl px-4 py-3">
                    @error('matric_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="field-label">Phone number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}" class="glass-input w-full rounded-2xl px-4 py-3">
                    @error('phone_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="field-label">Department</label>
                    <input type="text" name="department" value="{{ old('department', $student->department) }}" class="glass-input w-full rounded-2xl px-4 py-3">
                    @error('department') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="field-label">Level</label>
                    <select name="level" id="levelSelect" onchange="filterCourses()" class="glass-input w-full rounded-2xl px-4 py-3">
                        <option value="">Select level</option>
                        @foreach ($levelOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('level', $selectedLevel ?? $student->level) == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="field-label">Semester</label>
                    <select name="semester" id="semesterSelect" onchange="filterCourses()" class="glass-input w-full rounded-2xl px-4 py-3">
                        <option value="First" @selected(old('semester', $selectedSemester ?? 'First') == 'First')>First Semester</option>
                        <option value="Second" @selected(old('semester', $selectedSemester ?? 'First') == 'Second')>Second Semester</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="field-label">Email (read-only)</label>
                    <div class="info-tile" style="color: var(--ink)">{{ $user->email }}</div>
                </div>
            </div>

            <!-- Course selection checkboxes -->
            <div class="rounded-2xl p-5" style="background: rgba(5,150,105,0.05); border: 1px solid rgba(5,150,105,0.14);">
                <p class="eyebrow mb-3">Course registration selection</p>
                <div class="grid gap-2.5 sm:grid-cols-2">
                    @forelse ($availableCourses as $course)
                        <label class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50/50 cursor-pointer border" style="border-color: var(--line)">
                            <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                   @checked(in_array($course->id, old('courses', $enrolledCourseIds)))
                                   class="h-4 w-4 rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500">
                            <span>
                                <span class="font-semibold" style="color: var(--ink)">{{ $course->course_code }}</span>
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
                    Save profile changes
                </button>
            </div>
        </form>
    </section>

</div>

<!-- Password Confirmation Modal for Profile Update -->
<div id="passwordModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4" style="background: rgba(16,32,26,0.45); backdrop-filter: blur(6px);">
    <div class="w-full max-w-md rounded-[28px] bg-white p-6 shadow-2xl border" style="border-color: var(--line)">
        <h3 class="text-lg font-semibold" style="color: var(--ink)">Confirm password</h3>
        <p class="mt-2 text-sm" style="color: #7a8580">Type your current password to save these changes securely.</p>

        <input type="password" id="confirmPassword" class="glass-input mt-4 w-full rounded-2xl px-4 py-3" placeholder="Enter password">

        @error('current_password')
            <p class="mt-2 text-xs font-bold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $message }}</p>
        @enderror

        <div class="mt-5 flex gap-3">
            <button type="button" onclick="hideModal()" class="flex-1 rounded-2xl border px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50" style="border-color: var(--line)">Cancel</button>
            <button type="button" onclick="submitForm()" class="flex-1 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Confirm & save</button>
        </div>
    </div>
</div>

<!-- FORGOT / CHANGE PASSWORD MODAL OVERLAY -->
<div id="forgotModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4" style="background: rgba(16,32,26,0.45); backdrop-filter: blur(6px);">
    <div class="w-full max-w-md rounded-[32px] p-8 shadow-2xl bg-white border" style="border-color: var(--line); color: var(--ink);">

        <!-- Step 1: Confirm Email (Pre-filled with user's email) -->
        <div id="forgotStep1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold">Change password</h3>
                <button onclick="closeForgotModal()" class="text-lg font-bold" style="color: #9aa39c">✕</button>
            </div>
            <p class="text-sm mb-6" style="color: #7a8580">We'll send a 6-digit verification code to your registered email address to verify it's you.</p>

            <div id="step1Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700"></div>

            <div class="space-y-4">
                <div>
                    <label class="field-label">Your email address</label>
                    <input type="email" id="resetEmail" value="{{ $user->email }}" readonly class="glass-input w-full rounded-2xl px-4 py-3 cursor-not-allowed" style="color: #7a8580">
                </div>
                <button type="button" onclick="sendOtpRequest()" id="sendOtpBtn" class="w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white hover:bg-emerald-700 transition">
                    Send verification code
                </button>
            </div>
        </div>

        <!-- Step 2: Enter OTP Code with Orbit Animation -->
        <div id="forgotStep2" class="hidden text-center">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-2xl font-bold">Enter verification code</h3>
                <button onclick="closeForgotModal()" class="text-lg font-bold" style="color: #9aa39c">✕</button>
            </div>
            <p class="text-sm mb-5" style="color: #7a8580">Enter the 6-digit code sent to your registered email.</p>

            <div id="step2Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700 text-left"></div>

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
                <h3 class="text-2xl font-bold">New password</h3>
                <button onclick="closeForgotModal()" class="text-lg font-bold" style="color: #9aa39c">✕</button>
            </div>
            <p class="text-sm mb-6" style="color: #7a8580">Choose a secure new password for your student account.</p>

            <div id="step3Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700"></div>

            <div class="space-y-4">
                <div>
                    <label class="field-label">New password</label>
                    <input type="password" id="newPassword" required placeholder="••••••••" class="glass-input w-full rounded-2xl px-4 py-3">
                </div>
                <div>
                    <label class="field-label">Confirm new password</label>
                    <input type="password" id="newPasswordConfirmation" required placeholder="••••••••" class="glass-input w-full rounded-2xl px-4 py-3">
                </div>
                <button type="button" onclick="resetPasswordRequest()" id="resetPassBtn" class="w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white hover:bg-emerald-700 transition">
                    Update password
                </button>
            </div>
        </div>

        <!-- Step 4: Success Confirmation -->
        <div id="forgotStep4" class="hidden text-center py-6">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-3xl mb-4">
                ✓
            </div>
            <h3 class="text-2xl font-bold">Password updated</h3>
            <p class="mt-2 text-sm" style="color: #7a8580">Your password has been changed successfully. Reloading...</p>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .field-label { font-size: 13px; font-weight: 500; color: #5b6660; margin-bottom: 6px; display: block; }
    .glass-input {
        background: rgba(255,255,255,0.85);
        border: 1px solid #d7dbd2;
        color: var(--ink);
        box-shadow: 0 1px 2px rgba(16,32,26,0.04), inset 0 1px 0 rgba(255,255,255,0.6);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .glass-input::placeholder { color: #9aa39c; }
    .glass-input:focus {
        outline: none;
        border-color: rgba(5,150,105,0.55);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(5,150,105,0.12);
    }
</style>
@endpush

@push('scripts')
<script>
    let isEditing = @json($errors->any());
    let hasPasswordError = @json($errors->has('current_password'));
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';

    async function logoutSession(id, buttonEl) {
        const row = buttonEl.closest('[data-login-row]');
        const originalLabel = buttonEl.textContent;
        buttonEl.disabled = true;
        buttonEl.textContent = 'Logging out...';

        try {
            const response = await fetch(`/student/profile/logout-session/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();

            if (!response.ok || !data.success) {
                buttonEl.disabled = false;
                buttonEl.textContent = originalLabel;
                alert(data.message || 'Could not log out that session.');
                return;
            }

            if (data.current_session) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            row.style.transition = 'opacity 0.2s ease';
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 200);
        } catch (e) {
            buttonEl.disabled = false;
            buttonEl.textContent = originalLabel;
            alert('Connection error. Please try again.');
        }
    }

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