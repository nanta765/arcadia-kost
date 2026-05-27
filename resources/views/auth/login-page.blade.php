<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia Kost — Login</title>
    <link rel="icon" href="{{ asset('images/arcadia-logo.jpg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD,opsz@300,0,0,24" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#0A0A0A",
                        canvas: "#FFFFFF",
                        surface: "#F3F4F6",
                        "border-subtle": "#E5E7EB",
                        "text-secondary": "#4B5563"
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    spacing: {
                        'section': '120px',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-canvas text-primary font-sans antialiased">

    {{-- Main Content --}}
    <main class="min-h-screen flex flex-col md:flex-row w-full max-w-[1920px] mx-auto overflow-hidden">
        {{-- Back button --}}
        <a href="{{ url('/') }}" class="absolute top-6 left-6 z-30 flex items-center justify-center w-10 h-10 rounded-full border border-white/40 text-white hover:bg-white/10 transition-all">
            <span class="material-symbols-outlined text-xl">arrow_back</span>
        </a>
        {{-- Left: Image --}}
        <section class="hidden md:block md:w-1/2 relative min-h-[600px]">
            <div class="absolute inset-0 bg-primary/20 z-10"></div>
            <img alt="Arcadia Kost Lombok" class="absolute inset-0 w-full h-full object-cover" src="{{ asset('images/hero.jpg') }}">
            <div class="absolute bottom-16 left-16 z-20 max-w-md">
                <h1 class="font-sans text-5xl font-bold text-white mb-4">Escape to Tranquility.</h1>
                <p class="font-sans text-lg text-white/90">Experience the perfect blend of modern minimalist living and organic tropical beauty in the heart of Lombok.</p>
            </div>
        </section>

        {{-- Right: Form --}}
        <section class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 lg:p-24 bg-canvas">
        <div class="w-full max-w-md">
            {{-- Tabs --}}
            <div class="flex mb-10 bg-surface rounded-full p-1.5 relative">
                <button class="flex-1 py-3 text-center rounded-full text-sm font-semibold z-10 transition-all duration-300 text-primary bg-white shadow-sm" id="tab-login" onclick="toggleAuth('login')">Login</button>
                <button class="flex-1 py-3 text-center rounded-full text-sm font-medium z-10 transition-all duration-300 text-text-secondary" id="tab-register" onclick="toggleAuth('register')">Register</button>
            </div>

            {{-- Heading --}}
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold mb-2" id="form-title">Welcome Back</h2>
                <p class="text-text-secondary text-sm" id="form-subtitle">Login to manage your reservations.</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ url('/login') }}" class="space-y-5" id="auth-form">
                @csrf
                <input type="hidden" id="auth-mode" value="{{ $mode ?? 'login' }}">

                {{-- Name (register only) --}}
                <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-name">
                    <label class="block text-sm font-semibold mb-2">Full Name</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary/40">person</span>
                        <input name="name" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm" placeholder="John Doe" type="text" value="{{ old('name') }}">
                    </div>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary/40">mail</span>
                        <input name="email" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm" placeholder="email@arcadia.com" type="email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary/40">lock</span>
                        <input name="password" id="password-input" class="w-full pl-12 pr-12 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm" placeholder="••••••••" type="password" required>
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-text-secondary/40 hover:text-primary" onclick="togglePassword('password-input', this)">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password Confirmation (register only) --}}
                <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-password-confirmation">
                    <label class="block text-sm font-semibold mb-2">Confirm Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary/40">lock</span>
                        <input name="password_confirmation" id="password-confirm-input" class="w-full pl-12 pr-12 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm" placeholder="••••••••" type="password">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-text-secondary/40 hover:text-primary" onclick="togglePassword('password-confirm-input', this)">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                    @error('password_confirmation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Phone (register only) --}}
                <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-phone">
                    <label class="block text-sm font-semibold mb-2">Phone Number</label>
                    <div class="flex gap-2">
                        <select name="country_code" class="w-28 pl-3 pr-8 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm appearance-none bg-no-repeat" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2716%27 height=%2716%27 fill=%27%234B5563%27%3E%3Cpath d=%27M4 6l4 4 4-4%27/%3E%3C/svg%3E'); background-position: right 0.5rem center;">
                            <option value="+62">🇮🇩 +62</option>
                            <option value="+60">🇲🇾 +60</option>
                            <option value="+65">🇸🇬 +65</option>
                            <option value="+66">🇹🇭 +66</option>
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+86">🇨🇳 +86</option>
                            <option value="+81">🇯🇵 +81</option>
                            <option value="+82">🇰🇷 +82</option>
                            <option value="+91">🇮🇳 +91</option>
                        </select>
                        <input name="phone_number" class="flex-1 pl-4 pr-4 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm placeholder:text-text-secondary/50" placeholder="812 3456 7890" type="tel" value="{{ old('phone_number') }}">
                    </div>
                    @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Profession (register only) --}}
                <div class="hidden opacity-0 transform -translate-y-2 transition-all duration-300" id="field-profession">
                    <label class="block text-sm font-semibold mb-2">Profession</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary/40">work</span>
                        <input name="profession" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-border-subtle bg-surface focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none text-sm" placeholder="Student, Employee, etc." type="text" value="{{ old('profession') }}">
                    </div>
                    @error('profession')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl text-sm font-semibold hover:bg-black/80 transition-all active:scale-[0.98]" id="submit-btn">
                        Login Now
                    </button>
                </div>

            </form>

            <p class="mt-8 text-center text-text-secondary text-xs">
                Forgot your password? <a class="text-primary font-semibold hover:underline" href="{{ route('password.request') }}">Click here</a>
            </p>
        </div>
        </section>
    </main>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerText = 'visibility_off';
            } else {
                input.type = 'password';
                icon.innerText = 'visibility';
            }
        }

        const registerFields = ['field-name', 'field-phone', 'field-password-confirmation', 'field-profession'];

        function toggleAuth(mode) {
            const loginBtn = document.getElementById('tab-login');
            const registerBtn = document.getElementById('tab-register');
            const formTitle = document.getElementById('form-title');
            const formSubtitle = document.getElementById('form-subtitle');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('auth-form');

            if (mode === 'register') {
                registerBtn.classList.add('text-primary', 'font-semibold', 'bg-white', 'shadow-sm');
                registerBtn.classList.remove('text-text-secondary', 'font-medium');
                loginBtn.classList.remove('text-primary', 'font-semibold', 'bg-white', 'shadow-sm');
                loginBtn.classList.add('text-text-secondary', 'font-medium');

                registerFields.forEach(id => {
                    const el = document.getElementById(id);
                    el.classList.remove('hidden');
                    setTimeout(() => { el.classList.remove('opacity-0', '-translate-y-2'); }, 10);
                });

                formTitle.innerText = 'Create Account';
                formSubtitle.innerText = 'Start your journey with Kos Arcadia.';
                submitBtn.innerText = 'Register Now';
                form.action = "{{ url('/register') }}";
            } else {
                loginBtn.classList.add('text-primary', 'font-semibold', 'bg-white', 'shadow-sm');
                loginBtn.classList.remove('text-text-secondary', 'font-medium');
                registerBtn.classList.remove('text-primary', 'font-semibold', 'bg-white', 'shadow-sm');
                registerBtn.classList.add('text-text-secondary', 'font-medium');

                registerFields.forEach(id => {
                    const el = document.getElementById(id);
                    el.classList.add('opacity-0', '-translate-y-2');
                    setTimeout(() => el.classList.add('hidden'), 300);
                });

                formTitle.innerText = 'Welcome Back';
                formSubtitle.innerText = 'Login to manage your reservations.';
                submitBtn.innerText = 'Login Now';
                form.action = "{{ url('/login') }}";
            }
        }
    </script>

</body>
</html>
