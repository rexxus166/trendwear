<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    </style>
</head>
<body class="bg-white">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block lg:w-1/2 relative order-2"> 
            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=2020&auto=format&fit=crop" 
                 alt="Fashion Lifestyle" 
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute top-10 right-10 text-white text-right">
                <h2 class="text-4xl font-bold mb-2">Join the Club.</h2>
                <p class="text-lg opacity-90">Get exclusive access to new drops.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto h-screen">
            <div class="w-full max-w-md py-8">
                
                <div class="lg:hidden mb-6">
                    <h1 class="text-2xl font-bold">TrendWear.</h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold mb-2">Create Account</h2>
                    <p class="text-gray-500">Sign up to start shopping your style.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder="Alex Alexander" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all @error('name') border-red-500 ring-red-500 @enderror">
                        
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">No. Handphone</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 text-sm font-medium">+62</span>
                            
                            <input id="phone" 
                                   type="text" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   required 
                                   placeholder="812-3456-7890" 
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all @error('phone') border-red-500 ring-red-500 @enderror">
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               placeholder="alex@example.com" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all @error('email') border-red-500 ring-red-500 @enderror">
                        
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="••••••••" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all @error('password') border-red-500 ring-red-500 @enderror">
                            
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="••••••••" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                             
                             @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" required class="mt-1 w-4 h-4 rounded border-gray-300 text-black focus:ring-black">
                            <span class="text-sm text-gray-500 leading-tight">
                                By creating an account, I agree to the <a href="#" class="text-black underline">Terms of Service</a> and <a href="#" class="text-black underline">Privacy Policy</a>.
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-3.5 rounded-full font-semibold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg">
                        Create Account
                    </button>
                </form>

                <p class="text-center mt-8 text-gray-500 text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-black hover:underline">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>