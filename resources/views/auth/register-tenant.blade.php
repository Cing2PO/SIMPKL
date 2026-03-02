@extends('layouts.auth')

@section('title', 'Daftar Tenant - SIMPKL')

@section('content')
<div class="min-h-screen py-10 px-4">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-1 tracking-tight">SIMPKL</h1>
            <p class="text-gray-500 text-sm">Sistem Manajemen Internship &amp; Placement</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Daftar Sebagai Tenant</h2>
                <p class="text-blue-100 text-sm mt-1">Daftarkan institusi Anda dan buat akun admin untuk mulai menggunakan SIMPKL.</p>
            </div>

            {{-- Step Indicator --}}
            <div class="flex border-b border-gray-100">
                <div class="flex-1 py-3 px-6 flex items-center gap-3 step-tab active-tab" id="tab-1">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold step-badge step-badge-active" id="badge-1">1</div>
                    <span class="text-sm font-semibold step-label" id="label-1">Informasi Institusi</span>
                </div>
                <div class="flex-1 py-3 px-6 flex items-center gap-3 step-tab" id="tab-2">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold step-badge step-badge-inactive" id="badge-2">2</div>
                    <span class="text-sm font-semibold step-label text-gray-400" id="label-2">Akun Admin</span>
                </div>
                <div class="flex-1 py-3 px-6 flex items-center gap-3 step-tab" id="tab-3">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold step-badge step-badge-inactive" id="badge-3">3</div>
                    <span class="text-sm font-semibold step-label text-gray-400" id="label-3">Pilih Paket</span>
                </div>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mx-8 mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-9.25a.75.75 0 011.5 0v4a.75.75 0 01-1.5 0v-4zm.75-2a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-red-700 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Success Flash --}}
            @if (session('success'))
                <div class="mx-8 mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('tenant.register') }}" id="registerForm">
                @csrf

                <div class="px-8 py-6">

                    {{-- =========== STEP 1: Informasi Institusi =========== --}}
                    <div id="step-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Detail Institusi
                        </h3>

                        <div class="grid grid-cols-1 gap-5">
                            {{-- Institution Name --}}
                            <div>
                                <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    id="institution_name"
                                    name="institution_name"
                                    class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('institution_name') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                    placeholder="Contoh: SMK Negeri 1 Jakarta"
                                    value="{{ old('institution_name') }}"
                                    required
                                />
                                @error('institution_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Institusi <span class="text-red-500">*</span></label>
                                <textarea
                                    id="address"
                                    name="address"
                                    rows="2"
                                    class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('address') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                    placeholder="Jl. Contoh No. 1, Kecamatan, Kota, Provinsi"
                                    required
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contact --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Institusi <span class="text-red-500">*</span></label>
                                    <input
                                        type="email"
                                        id="contact_email"
                                        name="contact_email"
                                        class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_email') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                        placeholder="info@institusi.sch.id"
                                        value="{{ old('contact_email') }}"
                                        required
                                    />
                                    @error('contact_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon Institusi <span class="text-red-500">*</span></label>
                                    <input
                                        type="text"
                                        id="contact_phone"
                                        name="contact_phone"
                                        class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_phone') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                        placeholder="021-xxxxxxxx"
                                        value="{{ old('contact_phone') }}"
                                        required
                                    />
                                    @error('contact_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="nextStep(2)" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm py-2.5 px-6 rounded-lg transition">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- =========== STEP 2: Akun Admin =========== --}}
                    <div id="step-2" class="hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Akun Admin Institusi
                        </h3>
                        <p class="text-sm text-gray-500 mb-5">Akun ini akan menjadi admin untuk mengelola institusi Anda di SIMPKL.</p>

                        <div class="grid grid-cols-1 gap-5">
                            {{-- Admin Name --}}
                            <div>
                                <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    id="admin_name"
                                    name="admin_name"
                                    class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admin_name') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                    placeholder="Nama lengkap admin"
                                    value="{{ old('admin_name') }}"
                                    required
                                />
                                @error('admin_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Admin Email --}}
                            <div>
                                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email Admin <span class="text-red-500">*</span></label>
                                <input
                                    type="email"
                                    id="admin_email"
                                    name="admin_email"
                                    class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admin_email') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                    placeholder="admin@emailanda.com"
                                    value="{{ old('admin_email') }}"
                                    required
                                />
                                @error('admin_email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Admin Password --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10 @error('password') border-red-400 bg-red-50 @else border-gray-300 @enderror"
                                            placeholder="Min. 8 karakter"
                                            required
                                        />
                                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            class="w-full px-4 py-2.5 border rounded-lg text-sm outline-none transition focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10 border-gray-300"
                                            placeholder="Ulangi kata sandi"
                                            required
                                        />
                                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <button type="button" onclick="prevStep(1)" class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium text-sm py-2.5 px-6 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali
                            </button>
                            <button type="button" onclick="nextStep(3)" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm py-2.5 px-6 rounded-lg transition">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- =========== STEP 3: Pilih Paket =========== --}}
                    <div id="step-3" class="hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pilih Paket Langganan
                        </h3>

                        @if ($errors->has('plan_id'))
                            <p class="text-red-500 text-xs mb-3">{{ $errors->first('plan_id') }}</p>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="planCards">
                            @forelse ($plans as $plan)
                                @php
                                    $features = is_string($plan->features) ? json_decode($plan->features, true) : $plan->features;
                                    $features = is_array($features) ? $features : ($features ? explode(',', $plan->features) : []);
                                @endphp
                                <label class="plan-card relative cursor-pointer block">
                                    <input
                                        type="radio"
                                        name="plan_id"
                                        value="{{ $plan->id }}"
                                        class="sr-only plan-radio"
                                        {{ old('plan_id') == $plan->id ? 'checked' : '' }}
                                        required
                                    />
                                    <div class="plan-card-inner border-2 border-gray-200 rounded-xl p-5 transition-all">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <p class="font-bold text-gray-900 text-base">{{ $plan->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $plan->duration }} hari</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xl font-extrabold text-blue-600">
                                                    {{ $plan->price == 0 ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        @if (!empty($features))
                                            <ul class="space-y-1 mt-3 border-t border-gray-100 pt-3">
                                                @foreach ($features as $feature)
                                                    <li class="flex items-center gap-2 text-sm text-gray-600">
                                                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ trim($feature) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        {{-- Selected checkmark --}}
                                        <div class="plan-check hidden absolute top-3 right-3 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="col-span-2 text-center py-10 text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="text-sm">Belum ada paket tersedia. Silakan hubungi administrator.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="flex justify-between mt-6">
                            <button type="button" onclick="prevStep(2)" class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium text-sm py-2.5 px-6 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali
                            </button>
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-sm py-2.5 px-8 rounded-lg transition shadow-md hover:shadow-lg"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Daftarkan Institusi
                            </button>
                        </div>
                    </div>

                </div>{{-- /px-8 py-6 --}}
            </form>

            {{-- Footer --}}
            <div class="px-8 pb-6 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('auth.loginForm') }}" class="text-blue-600 hover:underline font-medium">Masuk di sini</a>
                </p>
            </div>
        </div>

        <p class="text-center text-gray-400 text-xs mt-6">© {{ date('Y') }} SIMPKL. All rights reserved.</p>
    </div>
</div>

<style>
.step-tab { cursor: default; }
.step-badge-active { background-color: #2563EB; color: #fff; }
.step-badge-done   { background-color: #16A34A; color: #fff; }
.step-badge-inactive { background-color: #E5E7EB; color: #9CA3AF; }
.step-label { color: #1F2937; }

/* Plan card selection */
.plan-radio:checked + .plan-card-inner {
    border-color: #2563EB;
    background-color: #EFF6FF;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}
.plan-radio:checked ~ .plan-check {
    display: flex !important;
}
</style>

<script>
    const totalSteps = 3;
    let currentStep = @if ($errors->any()) {{ old('step', 1) }} @else 1 @endif;

    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById('step-' + i).classList.add('hidden');
            const badge = document.getElementById('badge-' + i);
            const label = document.getElementById('label-' + i);
            if (i < step) {
                badge.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold step-badge step-badge-done';
                badge.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                label.className = 'text-sm font-semibold step-label text-green-700';
            } else if (i === step) {
                badge.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold step-badge step-badge-active';
                badge.textContent = i;
                label.className = 'text-sm font-semibold step-label';
            } else {
                badge.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold step-badge step-badge-inactive';
                badge.textContent = i;
                label.className = 'text-sm font-semibold step-label text-gray-400';
            }
        }
        document.getElementById('step-' + step).classList.remove('hidden');
        currentStep = step;
    }

    function nextStep(step) {
        showStep(step);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function prevStep(step) {
        showStep(step);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.querySelector('svg path:first-child').style.opacity = isText ? '1' : '0.4';
    }

    // Init with errors: go to the step with errors
    @if ($errors->any())
        showStep({{ old('step', 1) }});
    @else
        showStep(1);
    @endif

    // Plan card click highlight
    document.querySelectorAll('.plan-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.plan-card-inner').forEach(c => {
                c.classList.remove('border-blue-600', 'bg-blue-50');
            });
            document.querySelectorAll('.plan-check').forEach(c => c.classList.add('hidden'));
            if (this.checked) {
                this.nextElementSibling.classList.add('border-blue-600', 'bg-blue-50');
                this.closest('.plan-card').querySelector('.plan-check').classList.remove('hidden');
            }
        });
        // Trigger on load for old selection
        if (radio.checked) radio.dispatchEvent(new Event('change'));
    });
</script>
@endsection
