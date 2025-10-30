@extends('layouts.app')

@section('title', 'Login - MyHIMATIKA')

@section('body-class',
    'min-h-screen bg-slate-50 dark:bg-slate-900 flex items-center justify-center transition-colors
    duration-300')

@section('content')
    <div class="flex w-full min-h-screen">
        <!-- Left Side - Background Image/Decoration (Hidden on Mobile & Tablet) -->
        <div
            class="hidden xl:flex xl:w-1/2 bg-gradient-to-br from-cyan-600 via-blue-700 to-blue-800 dark:from-slate-800 dark:via-slate-900 dark:to-black relative overflow-hidden">
            <!-- Decorative Circles -->
            <div class="absolute top-10 left-10 w-40 h-40 border-4 border-white/30 rounded-full"></div>
            <div class="absolute top-20 left-20 w-32 h-32 border-4 border-white/20 rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-48 h-48 border-4 border-white/30 rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 border-4 border-white/20 rounded-full"></div>

            <!-- Background Image Placeholder -->
            <div class="absolute inset-0 bg-cover bg-center opacity-20"
                style="background-image: url('{{ asset('images/login_page.png') }}');">
            </div>

            <!-- Content Overlay -->
            <div class="relative z-10 flex flex-col justify-center items-start px-16 text-white">
                <div class="mb-8">
                    <img src="{{ asset('images/logohimatika.png') }}" alt="Logo HIMATIKA" class="h-20 w-20 mb-3">
                </div>
                <h1
                    class="text-5xl font-heading font-bold mb-4 bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">
                    MyHIMATIKA</h1>
                <p class="text-xl text-white/90 mb-6 font-medium">Sistem Manajemen Kaderisasi</p>
                <p class="text-white/80 text-lg leading-relaxed max-w-md font-body">
                    Platform digital untuk mengelola kehadiran, tugas, dan penilaian Padamu HIMATIKA.
                </p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div
            class="w-full xl:w-1/2 flex items-center justify-center px-4 py-12 bg-slate-50 dark:bg-slate-900 relative transition-colors duration-300">
            <!-- Mobile & Tablet Background (Only visible on mobile/tablet, behind the form) -->
            <div
                class="xl:hidden absolute inset-0 bg-gradient-to-br from-cyan-600 via-blue-700 to-blue-800 dark:from-slate-800 dark:via-slate-900 dark:to-black overflow-hidden">
                <!-- Background Image for Mobile & Tablet -->
                <div class="absolute inset-0 bg-cover bg-center opacity-15"
                    style="background-image: url('{{ asset('images/login_page.png') }}');">
                </div>
                <!-- Decorative Circles for Mobile & Tablet -->
                <div class="absolute top-5 left-5 w-32 h-32 border-4 border-white/20 rounded-full"></div>
                <div class="absolute bottom-5 right-5 w-40 h-40 border-4 border-white/20 rounded-full"></div>
            </div>

            <div class="w-full max-w-md relative z-10">
                <div class="text-center mb-8 xl:hidden">
                    <div class="mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-2">
                        <img src="{{ asset('images/logohimatika.png') }}" alt="Logo HIMATIKA" class="h-16 w-16">
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 transition-colors duration-300">

                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-heading font-bold text-slate-800 dark:text-slate-100 mb-2">Halo Peserta
                                PH!
                            </h2>
                            <p class="text-slate-600 dark:text-slate-400">Masuk ke sistem MyHIMATIKA</p>
                        </div>

                        <div class="xl:hidden">
                            <button onclick="toggleTheme()"
                                class="p-2 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all duration-200 group"
                                title="Toggle Dark Mode">
                                <i data-feather="sun"
                                    class="w-5 h-5 text-slate-600 dark:hidden group-hover:rotate-12 transition-transform"></i>
                                <i data-feather="moon"
                                    class="w-5 h-5 text-slate-400 hidden dark:block group-hover:-rotate-12 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <ul class="list-none">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-700 text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                <i data-feather="mail" class="inline-block w-4 h-4 mr-1"></i>
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                placeholder="your@email.com"
                                class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition duration-200 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 placeholder-slate-400 dark:placeholder-slate-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                <i data-feather="lock" class="inline-block w-4 h-4 mr-1"></i>
                                Password
                            </label>

                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    placeholder="Enter your password"
                                    class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition duration-200 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 placeholder-slate-400 dark:placeholder-slate-500 pr-12">

                                <!-- Eye icon (hold to show password) -->
                                <button type="button" id="holdShowPassword" aria-label="Tahan untuk melihat password"
                                    class="absolute inset-y-0 right-2 flex items-center px-2 text-slate-500 dark:text-slate-300 hover:text-slate-700 transition-opacity duration-150">
                                    <i data-feather="eye" id="holdEyeIcon" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <!-- Styled switch for Remember Me -->
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="remember" name="remember" type="checkbox" class="sr-only peer" />
                                    <div id="rememberTrack"
                                        class="relative w-11 h-6 bg-slate-200 dark:bg-slate-700 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-300 dark:peer-focus:ring-cyan-800 transition-colors duration-200">
                                        <div id="rememberDot"
                                            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow transform transition-all duration-200 translate-x-0">
                                        </div>
                                    </div>
                                </label>

                                <label for="remember"
                                    class="ml-3 text-sm text-slate-700 dark:text-slate-300 select-none">Remember
                                    me</label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white py-3.5 px-4 rounded-xl focus:ring-4 focus:ring-cyan-200 dark:focus:ring-cyan-800 transition duration-200 font-semibold text-lg shadow-lg transform hover:-translate-y-0.5 font-heading">
                            Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Hold-to-show password behavior
        (function() {
            const holdBtn = document.getElementById('holdShowPassword');
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('holdEyeIcon');

            if (!holdBtn || !pwdInput) return;

            const show = (e) => {
                // try to prevent the button from stealing focus so we can restore caret
                if (e && e.preventDefault) e.preventDefault();

                // save current selection/caret
                let sel = {
                    start: null,
                    end: null
                };
                try {
                    sel.start = pwdInput.selectionStart;
                    sel.end = pwdInput.selectionEnd;
                } catch (err) {
                    sel.start = null;
                    sel.end = null;
                }

                // change to text and restore caret
                pwdInput.type = 'text';
                try {
                    pwdInput.focus();
                    if (sel.start !== null && sel.end !== null) {
                        pwdInput.setSelectionRange(sel.start, sel.end);
                    }
                } catch (err) {
                    // ignore
                }

                if (eyeIcon) {
                    // show open eye when visible
                    eyeIcon.setAttribute('data-feather', 'eye');
                }
            };

            const hide = () => {
                // save selection, switch type back and restore selection
                let sel = {
                    start: null,
                    end: null
                };
                try {
                    sel.start = pwdInput.selectionStart;
                    sel.end = pwdInput.selectionEnd;
                } catch (err) {
                    sel.start = null;
                    sel.end = null;
                }

                pwdInput.type = 'password';
                try {
                    pwdInput.focus();
                    if (sel.start !== null && sel.end !== null) {
                        pwdInput.setSelectionRange(sel.start, sel.end);
                    }
                } catch (err) {
                    // ignore
                }

                if (eyeIcon) {
                    // show closed eye when hidden
                    eyeIcon.setAttribute('data-feather', 'eye-off');
                }
            };

            // Mouse
            holdBtn.addEventListener('mousedown', show);
            holdBtn.addEventListener('mouseup', hide);
            holdBtn.addEventListener('mouseleave', hide);

            // Touch (non-passive so we can preventDefault and avoid focus stealing)
            holdBtn.addEventListener('touchstart', show, {
                passive: false
            });
            holdBtn.addEventListener('touchend', hide);
            holdBtn.addEventListener('touchcancel', hide);

            // Also allow keyboard: press and hold Space or Enter on the button
            holdBtn.addEventListener('keydown', (e) => {
                if (e.code === 'Space' || e.code === 'Enter') show(e);
            });
            holdBtn.addEventListener('keyup', (e) => {
                if (e.code === 'Space' || e.code === 'Enter') hide();
            });
        })();

        // Make the remember switch visually reflect the checkbox state (works even if Tailwind peer selector not applied)
        (function() {
            const rememberInput = document.getElementById('remember');
            const rememberTrack = document.getElementById('rememberTrack');
            const rememberDot = document.getElementById('rememberDot');

            if (!rememberInput || !rememberTrack || !rememberDot) return;

            const applyState = (checked) => {
                if (checked) {
                    rememberTrack.classList.remove('bg-slate-200');
                    rememberTrack.classList.add('bg-cyan-600');
                    // ensure visible in dark mode too (some Tailwind builds may not include dark:bg-cyan-600)
                    rememberTrack.style.backgroundColor = '#0891b2';
                    rememberDot.classList.add('translate-x-5');
                } else {
                    rememberTrack.classList.add('bg-slate-200');
                    rememberTrack.classList.remove('bg-cyan-600');
                    // remove inline override so Tailwind classes take effect again
                    rememberTrack.style.backgroundColor = '';
                    rememberDot.classList.remove('translate-x-5');
                }
            };

            // Initialize based on current value (server may set checked)
            applyState(rememberInput.checked);

            rememberInput.addEventListener('change', (e) => {
                applyState(e.target.checked);
            });
        })();
    </script>
@endsection
