<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    </style>
</head>
<body class="bg-white">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop" 
                 alt="Fashion Model" 
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute bottom-10 left-10 text-white">
                <h2 class="text-4xl font-bold mb-2">TrendWear.</h2>
                <p class="text-lg opacity-90">Elevate your everyday style.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                
                <div class="lg:hidden mb-8">
                    <h1 class="text-2xl font-bold">TrendWear.</h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-bold mb-2">Welcome Back</h2>
                    <p class="text-gray-500">Please enter your details to sign in.</p>
                    
                    <x-auth-session-status class="mb-4 mt-4" :status="session('status')" />
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   placeholder="alex@example.com" 
                                   class="w-full pl-4 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all @error('email') border-red-500 ring-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••" 
                                   class="w-full pl-4 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all @error('password') border-red-500 ring-red-500 @enderror">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 rounded border-gray-300 text-black focus:ring-black">
                            <span class="text-sm text-gray-500">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-black hover:underline">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-3.5 rounded-full font-semibold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg">
                        Sign In
                    </button>

                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-400">Or continue with</span>
                        </div>
                    </div>

                    <a href="{{ route('social.redirect', 'google') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                        Sign in with Google
                    </a>

                </form>

                <p class="text-center mt-8 text-gray-500 text-sm">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-black hover:underline">Create account</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>