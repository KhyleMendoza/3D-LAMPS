<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        @if ($message = session('success'))
        <div id="success-message" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-[80] transition-opacity duration-300 opacity-1" role="alert">
            <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path fill="currentColor"
                    d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
                </path>
            </svg>
            <span class="text-green-800">{{ $message }}</span>
            <button type="button" class="ml-auto text-green-600 hover:text-green-800 focus:outline-none" aria-label="Close" onclick="closeMessage('success-message')">
                &times;
            </button>
        </div>
    @endif

    @if ($error = session('error'))
        <div id="error-message" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-[80] transition-opacity duration-300 opacity-1" role="alert">
            <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path fill="currentColor"
                    d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                </path>
            </svg>
            <span class="text-red-800">{{ $error }}</span>
            <button type="button" class="ml-auto text-red-600 hover:text-red-800 focus:outline-none" aria-label="Close" onclick="closeMessage('error-message')">
                &times;
            </button>
        </div>
    @endif

    <script>
        function closeMessage(id) {
            const message = document.getElementById(id);
            if (message) {
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 300);
            }
        }
        setTimeout(() => closeMessage('success-message'), 5000);
        setTimeout(() => closeMessage('error-message'), 5000);
    </script>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Create Promo Code</h2>
            <form action="{{ route('promotion.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Redeem Code</label>
                        <input type="text" name="code" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter redeem code">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="quantity" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter quantity">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Discount Percentage</label>
                        <input type="number" name="discount_percentage" min="0" max="100" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter discount %">
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">Add Code</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Promo Codes</h2>
            <div class="overflow-x-auto">
                @if ($promos->isEmpty())
                    <p class="text-gray-500 text-center py-6">No promo codes available.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($promos as $promo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $promo->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $promo->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $promo->discount_percentage }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('promotion.edit', $promo) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('promotion.destroy', $promo) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
