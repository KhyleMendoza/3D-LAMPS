<x-app-layout>
    <div class="min-w-full">
        <div class="bg-white overflow-hidden border border-gray-100">
            <div class="px-8 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl md:text-xl font-semibold text-gray-800 dark:text-gray-200">Transaction History</h2>
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
                                    @if ($transaction->status !== 'refunded' && $transaction->status !== 'requesting refund')
                                        <form action="{{ route('transaction.refund', $transaction) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300 flex items-center">
                                                <i class="fas fa-undo mr-2"></i> Refund
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-sm">{{ ucfirst($transaction->status) }}</span>
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
