<x-guest-layout>
    <div class="h-screen relative" style="overflow: hidden;">
        <div class="flex flex-col md:flex-row h-full">
            <div class="hidden md:block w-1/2 bg-cover bg-center">
                <img class="rimg" src="rk.png" alt="rk">
            </div>
            <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-white relative">
                <div class="icon" style="position: absolute; top: 16px; right: 16px;">
                    <img src="icon.png" alt="icon" style="height: 48px; width: 55px;">
                </div>
                <div class="w-full max-w-md space-y-8">
                    <div>
                        <p class="text-gray-600">Join our community</p>
                        <h2 class="text-4xl font-bold text-gray-900 mb-2">Register to KR</h2>
                    </div>
                    <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="space-y-4">
                            <!-- Name -->
                            <div class="relative">
                                <label for="name" class="text-sm font-medium text-gray-700">Name</label>
                                <input id="name" name="name" type="text" required
                                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Enter your name" value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="relative">
                                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Enter your email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="relative">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" autocomplete="new-password" required
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
                            <!-- Confirm Password -->
                            <div class="relative">
                                <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Confirm your password">
                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Register
                            </button>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Already have an account?
                                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Sign in</a>
                            </p>
                        </div>
                    </form>
                </div>
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
