<x-app-layout>
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-800">Sales Analytics</h1>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-8">
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-chart-line text-blue-500"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Sales</h3>
                        <p class="text-2xl font-semibold">₱{{ number_format($totalSales, 2) }}</p>
                        <span class="text-green-500 text-sm">+12.5%</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-shopping-cart text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Average Order Value</h3>
                        <p class="text-2xl font-semibold">₱{{ number_format($averageOrderValue, 2) }}</p>
                        <span class="text-green-500 text-sm">+5.2%</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-users text-purple-500"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Customers</h3>
                        <p class="text-2xl font-semibold">{{ $totalCustomers }}</p>
                        <span class="text-green-500 text-sm">+8.3%</span>
                    </div>
                </div>
            </div>
        </section>


    </div>
</x-app-layout>
