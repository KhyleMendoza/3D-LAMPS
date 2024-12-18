<x-app-layout>
    <body class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Help Center</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Find answers to frequently asked questions and get the support you need. Can't find what you're looking for? Our support team is here to help.</p>
        </div>
    </body>

    <body class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="space-y-6 w-[90%] sm:w-[90%] md:w-[90%] lg:w-[90%] xl:w-[90%] mx-auto">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <button class="w-full px-6 py-4 text-left focus:outline-none flex items-cente0r justify-between" onclick="toggleFAQ(this)" aria-expanded="false">
                    <span class="text-lg font-semibold text-gray-900">How do I change my Profile Information?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200"></i>
                </button>
                <div class="hidden px-6 py-4 bg-gray-50">
                    <p class="text-gray-600">To change your profile information go to "Profile" and you can update name, email and update password.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <button class="w-full px-6 py-4 text-left focus:outline-none flex items-center justify-between" onclick="toggleFAQ(this)" aria-expanded="false">
                    <span class="text-lg font-semibold text-gray-900">How do I reset my password?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200"></i>
                </button>
                <div class="hidden px-6 py-4 bg-gray-50">
                    <p class="text-gray-600">To reset your password, click on the "Forgot Password" link on the login page. Enter your email address, and we'll send you instructions to reset your password.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <button class="w-full px-6 py-4 text-left focus:outline-none flex items-center justify-between" onclick="toggleFAQ(this)" aria-expanded="false">
                    <span class="text-lg font-semibold text-gray-900">How do I delete my Account?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200"></i>
                </button>
                <div class="hidden px-6 py-4 bg-gray-50">
                    <p class="text-gray-600">To delete your Account go to "Profile" and you can delete your account.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <button class="w-full px-6 py-4 text-left focus:outline-none flex items-center justify-between" onclick="toggleFAQ(this)" aria-expanded="false">
                    <span class="text-lg font-semibold text-gray-900">What are your shipping policies?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200"></i>
                </button>
                <div class="hidden px-6 py-4 bg-gray-50">
                    <p class="text-gray-600">We offer worldwide shipping with various delivery options. Standard shipping typically takes 3-5 business days, while express shipping arrives within 1-2 business days.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <button class="w-full px-6 py-4 text-left focus:outline-none flex items-center justify-between" onclick="toggleFAQ(this)" aria-expanded="false">
                    <span class="text-lg font-semibold text-gray-900">What is your refund policy?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200"></i>
                </button>
                <div class="hidden px-6 py-4 bg-gray-50">
                    <p class="text-gray-600">We offer a 30-day money-back guarantee on all purchases. To request a refund, please contact our support team with your order number and reason for return. Refunds will be processed within 5-7 business days after we receive the returned item.</p>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-white rounded-lg shadow-sm p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Need Additional Support?</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Email Support</h3>
                    <p class="text-gray-600">kr.support@gmail.com</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Phone Support</h3>
                    <p class="text-gray-600">09212618769</p>
                </div>
            </div>
        </div>
    </body>

    <script>
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector("i");
            const isExpanded = button.getAttribute("aria-expanded") === "true";

            button.setAttribute("aria-expanded", !isExpanded);
            content.classList.toggle("hidden");
            icon.style.transform = isExpanded ? "rotate(0deg)" : "rotate(180deg)";
        }
    </script>
</x-app-layout>
