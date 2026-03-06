<nav style="background: #1c1b1b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">

    <!-- Logo -->
    <div>
        <a href="{{ route('shop.index') }}" style="color: white; text-decoration: none; font-weight: bold; font-size: 1.2rem;">
            🛒 NRUS Shop
        </a>
    </div>

    <ul style="list-style: none; display: flex; gap: 1.5rem; margin: 0; align-items: center;">

        <!-- Public Links -->
        <li><a href="/" style="text-decoration: none; color: #ffffff;">Home</a></li>
        <li><a href="/products" style="text-decoration: none; color: #ffffff;">Products</a></li>
        <li><a href="/about" style="text-decoration: none; color: #ffffff;">About Us</a></li>
        <li><a href="/contact" style="text-decoration: none; color: #ffffff;">Contact</a></li>

        @guest
            <li style="margin-left:auto;">
                <a href="{{ route('login') }}" style="text-decoration: none; color: #4da6ff; font-weight: bold;">
                    Login
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}" style="text-decoration: none; color: #4da6ff; font-weight: bold;">
                    Register
                </a>
            </li>
        @endguest

        @auth

            <!-- Admin Links -->
           @if(auth()->user()->role === 'admin')

<li x-data="{ open: false }" style="position: relative;">

    <button 
        @click="open = !open"
        style="background:none;border:none;color:white;cursor:pointer;">
        Admin ▾
    </button>

    <ul 
        x-show="open"
        x-transition
        @click.outside="open = false"
        x-cloak
        style="
            position:absolute;
            top:30px;
            background:#2b2b2b;
            list-style:none;
            padding:10px;
            width:180px;
        ">

        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
        <li><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>

    </ul>

</li>

            @else

                <!-- Normal User Links -->
                <li><a href="{{ route('shop.index') }}" style="text-decoration: none; color: #ffffff;">Shop</a></li>
                <li><a href="/cart" style="text-decoration: none; color: #ffffff;">Cart</a></li>
                <li><a href="{{ route('profile.edit') }}" style="text-decoration: none; color: #ffffff;">Profile</a></li>

            @endif

            <!-- Username -->
            <li style="margin-left:auto; color: #ffffff;">
                {{ auth()->user()->name }}
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; cursor: pointer; font-size: 1rem; color: #ff4d4d;">
                        Logout
                    </button>
                </form>
            </li>

        @endauth

    </ul>
</nav>