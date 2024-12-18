<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="mb-8">
                <div class="w-20 h-20 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Cancelled</h1>
                <p class="text-lg text-gray-600">Your payment process has been cancelled.</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <div class="grid gap-4">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <span class="text-gray-600">Attempted Amount</span>
                        <span class="font-medium text-gray-900">₱{{ $attemptedAmount }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <span class="text-gray-600">Date</span>
                        <span class="font-medium text-gray-900">{{ now()->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Cancellation Reason</span>
                        <span class="font-medium text-red-600">{{ $cancellationReason }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('guest.dashboard') }}" class="px-6 py-3 bg-slate-900 text-white font-medium rounded-lg text-white hover:bg-slate-800 transition-colors duration-200">
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
