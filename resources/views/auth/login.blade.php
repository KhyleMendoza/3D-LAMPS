<x-guest-layout>
    <div class="h-screen relative" style="overflow: hidden;">
        <div class="flex flex-col md:flex-row h-full">
            <div class="icon">
                <img src="icon.png" alt="icon" style="position: absolute; height: 48px; width: 55px;">
            </div>
            <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-white">
                <div class="w-full max-w-md space-y-8">
                    <div>
                        <p class="text-gray-600">Start your journey</p>
                        <h2 class="text-4xl font-bold text-gray-900 mb-2">Sign In to KR</h2>
                    </div>
                    <form class="space-y-4" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-4">
                            <div class="relative">
                                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Enter your email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required
                                        class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                        placeholder="Enter your password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" onclick="togglePassword()">
                                        <i class="far fa-eye" id="togglePassword"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                            @endif
                        </div>
                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Sign in
                            </button>
                        </div>
                        <a href="{{ route('guest.dashboard') }}" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-indigo-600 bg-gray-100 hover:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
                            Continue as Guest
                        </a>
                        <div>
                            <p class="text-sm text-gray-600">Don't have an account?
                                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">Sign up</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hidden md:block w-1/2 bg-cover bg-center">
                <img class="rimg" src="rk.png" alt="rk">
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const password = document.querySelector('#password');
            const toggle = document.querySelector('#togglePassword');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            toggle.classList.toggle('fa-eye');
            toggle.classList.toggle('fa-eye-slash');
        }
    </script>
</x-guest-layout>
