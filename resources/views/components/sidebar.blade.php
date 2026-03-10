<div class="w-64 bg-white border-r border-gray-200 min-h-screen hidden md:block">
    <nav class="mt-10 px-6">
        <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
            Products
        </a>
        <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
            Users
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
            Reviews
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
            Transactions
        </a>
    </nav>
</div>