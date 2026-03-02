<nav style="background:#333;padding:1rem;">
    <ul style="display:flex;gap:2rem;list-style:none;color:white;">

        <!-- Logo -->
        <li>
            <a href="{{ route('shop.index') }}" style="color:white;">🛒 NRUS Shop</a>
        </li>

        @guest
            <li style="margin-left:auto;">
                <a href="{{ route('login') }}" style="color:white;">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}" style="color:white;">Register</a>
            </li>
        @endguest


        @auth
            @if(auth()->user()->role === 'admin')

                <li>
                    <a href="{{ route('admin.dashboard') }}" style="color:white;">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" style="color:white;">Products</a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" style="color:white;">Users</a>
                </li>
                <li>
                    <a href="{{ route('admin.reviews.index') }}" style="color:white;">Reviews</a>
                </li>
                <li>
                    <a href="{{ route('admin.transactions.index') }}" style="color:white;">Transactions</a>
                </li>

            @else

                <li>
                    <a href="{{ route('shop.index') }}" style="color:white;">Shop</a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" style="color:white;">Profile</a>
                </li>

            @endif

            <li style="margin-left:auto;">
                {{ auth()->user()->name }}
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>

        @endauth

    </ul>
</nav>