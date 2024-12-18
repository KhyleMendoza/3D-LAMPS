<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center">
        <section class="relative h-[500px] w-full">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1512389098783-66b81f86e199" alt="Christmas Promotional Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Magical Christmas Sale</h1>
                    <p class="text-xl text-gray-200 mb-8">Save up to 80% on holiday specials</p>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 w-full">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Christmas Special Offers</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full">
                    <img src="https://images.unsplash.com/photo-1607344645866-009c320b63e0" alt="Deal 1" class="w-full h-48 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-2">Holiday Gifts</h3>
                        <p class="text-gray-600 mb-4">Up to 60% off on festive collections</p>
                        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-300">Learn More</button>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full">
                    <img src="https://images.unsplash.com/photo-1543589077-47d81606c1bf" alt="Deal 2" class="w-full h-48 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-2">3D Lamps Christmas Bundles</h3>
                        <p class="text-gray-600 mb-4">Christmas bundles at 40% off</p>
                        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-300">Learn More</button>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full">
                    <img src="https://images.unsplash.com/photo-1513885535751-8b9238bd345a" alt="Deal 3" class="w-full h-48 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-2">Winter Fashion</h3>
                        <p class="text-gray-600 mb-4">Buy 2 Get 1 Free on winter wear</p>
                        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-300">Learn More</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[url('https://images.unsplash.com/photo-1576919228236-a097c32a5cd4')] bg-cover bg-center py-16 w-full relative">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-4xl font-bold text-white mb-8">Christmas Sale Starts In</h2>
                <div class="flex justify-center space-x-6">
                    <div id="days" class="bg-white bg-opacity-90 rounded-xl p-6 w-28 text-center transform hover:scale-105 transition duration-300 shadow-2xl">
                        <span class="block text-4xl font-bold text-yellow-600">0</span>
                        <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Days</span>
                    </div>
                    <div id="hours" class="bg-white bg-opacity-90 rounded-xl p-6 w-28 text-center transform hover:scale-105 transition duration-300 shadow-2xl">
                        <span class="block text-4xl font-bold text-red-600">0</span>
                        <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Hours</span>
                    </div>
                    <div id="minutes" class="bg-white bg-opacity-90 rounded-xl p-6 w-28 text-center transform hover:scale-105 transition duration-300 shadow-2xl">
                        <span class="block text-4xl font-bold text-green-600">0</span>
                        <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Minutes</span>
                    </div>
                    <div id="seconds" class="bg-white bg-opacity-90 rounded-xl p-6 w-28 text-center transform hover:scale-105 transition duration-300 shadow-2xl">
                        <span class="block text-4xl font-bold text-blue-600">0</span>
                        <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Seconds</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const targetDate = new Date('2024-12-25T00:00:00');

            function updateCountdown() {
                const now = new Date();
                const timeLeft = targetDate - now;

                if (timeLeft > 0) {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
                    const minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
                    const seconds = Math.floor((timeLeft / 1000) % 60);

                    document.getElementById('days').querySelector('span').textContent = days;
                    document.getElementById('hours').querySelector('span').textContent = hours;
                    document.getElementById('minutes').querySelector('span').textContent = minutes;
                    document.getElementById('seconds').querySelector('span').textContent = seconds;
                } else {
                    document.querySelector('.text-center h2').textContent = 'The Sale is Live!';
                    clearInterval(countdownInterval);
                }
            }

            const countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
        });
    </script>
</x-app-layout>
