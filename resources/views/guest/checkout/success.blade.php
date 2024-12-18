<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful</h1>
                <p class="text-lg text-gray-600">Thank You! Your payment was processed successfully.</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 mb-4">
                <div class="grid gap-4">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <span class="text-gray-600">Transaction ID</span>
                        <span class="font-medium text-gray-900">#{{ $transactionId }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <span class="text-gray-600">Shipping Fee</span>
                        <span class="font-medium text-gray-900">₱20.00</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <span class="text-gray-600">Amount Paid</span>
                        <span class="font-medium text-gray-900">₱{{ number_format($amountPaid, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <span class="text-gray-600">Date</span>
                        <span class="font-medium text-gray-900">{{ $paymentDate }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Est. Delivery:</span>
                        <span class="font-medium text-gray-900">{{ $deliveryDate }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('guest.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
