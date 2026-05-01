{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Indomarket</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts - Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .password-strength-meter {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="min-h-screen relative overflow-x-hidden bg-gray-50">
    {{-- Background Decorative Elements --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-amber-100 rounded-full opacity-50 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-100 rounded-full opacity-50 blur-3xl"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-br from-amber-50 to-emerald-50 rounded-full opacity-30 blur-3xl">
        </div>
    </div>

    {{-- Scrollable Container --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center py-8 px-4">
        <div class="max-w-lg w-full animate-fadeInUp">
            {{-- Logo & Brand --}}
            <div class="text-center mb-6 lg:mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl shadow-lg mb-3 lg:mb-4">
                    <i class="fas fa-store text-white text-2xl lg:text-3xl"></i>
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-gray-800">
                    Indo<span class="text-emerald-600">market</span>
                </h1>
                <p class="text-gray-500 text-sm lg:text-base mt-2">Buat akun untuk mulai belanja</p>
            </div>

            {{-- Register Card --}}
            <div class="bg-white rounded-3xl shadow-xl p-6 lg:p-8 border border-gray-100">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-3 lg:p-4 mb-4 lg:mb-6">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-start gap-3">
                                <div class="bg-red-100 rounded-xl p-2 flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-600 text-sm"></i>
                                </div>
                                <p class="text-red-800 text-sm">{{ $error }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="space-y-3 lg:space-y-4">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-user text-sm"></i>
                                </span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="John Doe" required
                                    class="w-full pl-11 lg:pl-12 pr-4 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                              focus:border-emerald-500 focus:ring-0 transition-all
                                              placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                            </div>
                        </div>

                        {{-- Email & Telepon dalam grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </span>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        placeholder="nama@email.com" required
                                        class="w-full pl-11 lg:pl-12 pr-4 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                                  focus:border-emerald-500 focus:ring-0 transition-all
                                                  placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                                </div>
                            </div>

                            <div>
                                <label for="phone"
                                    class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">Telepon</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-phone text-sm"></i>
                                    </span>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        placeholder="081234567890"
                                        class="w-full pl-11 lg:pl-12 pr-4 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                                  focus:border-emerald-500 focus:ring-0 transition-all
                                                  placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="address"
                                class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">Alamat</label>
                            <div class="relative">
                                <span class="absolute left-4 top-4 text-gray-400">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </span>
                                <textarea name="address" id="address" rows="2" placeholder="Alamat lengkap..."
                                    class="w-full pl-11 lg:pl-12 pr-4 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                                 focus:border-emerald-500 focus:ring-0 transition-all resize-none
                                                 placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        {{-- Password & Konfirmasi --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
                            <div x-data="{ show: false, password: '', strength: 0 }">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock text-sm"></i>
                                    </span>
                                    <input :type="show ? 'text' : 'password'" name="password" id="password"
                                        x-model="password"
                                        @input="
                                               strength = 0;
                                               if(password.length >= 8) strength++;
                                               if(password.match(/[A-Z]/)) strength++;
                                               if(password.match(/[0-9]/)) strength++;
                                               if(password.match(/[^A-Za-z0-9]/)) strength++;
                                           "
                                        placeholder="Minimal 8 karakter" required
                                        class="w-full pl-11 lg:pl-12 pr-12 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                                  focus:border-emerald-500 focus:ring-0 transition-all
                                                  placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                                    <button type="button" @click="show = !show"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fas text-sm" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>

                                {{-- Password Strength --}}
                                <div class="mt-2 flex gap-1">
                                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                                        :class="strength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                                        :class="strength >= 2 ? 'bg-orange-500' : 'bg-gray-200'"></div>
                                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                                        :class="strength >= 3 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                                        :class="strength >= 4 ? 'bg-emerald-500' : 'bg-gray-200'"></div>
                                </div>
                                <p class="text-[10px] lg:text-xs text-gray-400 mt-1"
                                    x-show="password.length > 0 && strength < 3">
                                    Gunakan huruf besar, angka, dan simbol
                                </p>
                                <p class="text-[10px] lg:text-xs text-emerald-600 mt-1" x-show="strength >= 4">
                                    Password kuat! ✅
                                </p>
                            </div>

                            <div x-data="{ show: false }">
                                <label for="password_confirmation"
                                    class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">
                                    Konfirmasi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock text-sm"></i>
                                    </span>
                                    <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                        id="password_confirmation" placeholder="Ulangi password" required
                                        class="w-full pl-11 lg:pl-12 pr-12 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                                  focus:border-emerald-500 focus:ring-0 transition-all
                                                  placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                                    <button type="button" @click="show = !show"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fas text-sm" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="mt-4 lg:mt-6">
                        <label class="flex items-start cursor-pointer group">
                            <input type="checkbox" required
                                class="w-4 h-4 rounded-lg border-2 border-gray-300 text-emerald-600
                                          focus:ring-emerald-500 transition-all mt-0.5 flex-shrink-0">
                            <span class="ml-2 text-xs lg:text-sm text-gray-600">
                                Saya menyetujui
                                <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium">Syarat &
                                    Ketentuan</a>
                                dan
                                <a href="#"
                                    class="text-emerald-600 hover:text-emerald-700 font-medium">Kebijakan Privasi</a>
                            </span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 text-white py-3.5 lg:py-4 rounded-xl
                                   font-semibold hover:from-emerald-700 hover:to-emerald-600 transition-all
                                   shadow-sm hover:shadow-md transform hover:-translate-y-0.5 text-base lg:text-lg mt-4 lg:mt-6">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </button>
                </form>

                {{-- Login Link --}}
                <div class="mt-4 lg:mt-6 text-center">
                    <p class="text-gray-500 text-sm">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
                            Masuk sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
