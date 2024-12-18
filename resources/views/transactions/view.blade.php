<x-app-layout>
    <div class="min-w-full">
        <div class="bg-white overflow-hidden border border-gray-100">
            <div class="px-8 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl md:text-xl font-semibold text-gray-800 dark:text-gray-200">Manage Transactions</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <button id="filterButton" type="button" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-gray-600 transition duration-300 flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <div id="filterSection" class="hidden fixed right-4 top-32 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 p-4 w-[300px] sm:w-[600px] lg:w-[800px] z-50">
                            <form method="GET" action="{{ route('transactions.view') }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Transaction Date From</label>
                                        <input type="date" name="from_date" class="w-full rounded-lg border border-gray-300 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('from_date') }}">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Transaction Date To</label>
                                        <input type="date" name="to_date" class="w-full rounded-lg border border-gray-300 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('to_date') }}">
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" class="w-full rounded-lg border border-gray-300 py-2.5 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Status</option>
                                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="requesting refund" {{ request('status') == 'requesting refund' ? 'selected' : '' }}>Requesting Refund</option>
                                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Amount Range</label>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <input type="number" name="min_amount" placeholder="Min" class="w-full rounded-lg border border-gray-300 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('min_amount') }}">
                                            <input type="number" name="max_amount" placeholder="Max" class="w-full rounded-lg border border-gray-300 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('max_amount') }}">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Sort By</label>
                                        <select name="sort" class="w-full rounded-lg border border-gray-300 py-2.5 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end mt-6 space-x-2">
                                    <a href="{{ route('transactions.view') }}" class="w-full sm:w-auto border border-gray-300 hover:bg-gray-100 text-black px-6 py-3 rounded-lg font-medium">Clear</a>
                                    <button type="submit" class="w-full sm:w-auto bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-medium">Apply Filters</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const filterButton = document.getElementById("filterButton");
                const filterSection = document.getElementById("filterSection");

                filterButton.addEventListener("click", (e) => {
                    e.stopPropagation();
                    filterSection.classList.toggle("hidden");
                });

                filterSection.addEventListener("click", (e) => {
                    e.stopPropagation();
                });

                document.addEventListener("click", () => {
                    if (!filterSection.classList.contains("hidden")) {
                        filterSection.classList.add("hidden");
                    }
                });
            </script>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Transaction ID</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Products</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Amount Paid</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Transaction Date</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Estimated Delivery</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaction->transaction_id }}</td>
                                <td class="px-8 py-6">
                                    <div class="space-y-4">
                                        @foreach ($transaction->purchased_items as $item)
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $item['name'] }}</div>
                                                    <div class="text-sm font-semibold text-gray-500">Product ID: {{ $item['product_id'] ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        Size: {{ $item['size'] ?? 'N/A' }}, Color: {{ $item['color'] ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-gray-900">₱{{ number_format($transaction->amount_paid, 2) }}</td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm text-gray-500">{{ $transaction->payment_date->format('F d, Y') }}</td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm text-gray-500">{{ $transaction->delivery_date->format('F d, Y') }}</td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $transaction->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm">
                                    @if ($transaction->status == 'requesting refund')
                                        <form action="{{ route('transactions.refund', $transaction->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300 flex items-center">
                                                <i class="fas fa-undo mr-2"></i> Refund
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="h-[30rem]">
                                <td colspan="7" class="px-8 py-6 text-center text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .border {
            border-width: 0;
        }
    </style>
</x-app-layout>
