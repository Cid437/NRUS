<nav style="background: #1c1b1b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
         <div>
            <a href="{{ route('shop.index') }}" style="color:white;">🛒 NRUS Shop</a>
        </div>

    <ul style="list-style: none; display: flex; gap: 1.5rem; margin: 0; align-items: center;">
        <li><a href="/" style="text-decoration: none; color: #ffffff;">Home</a></li>
        <li><a href="/products" style="text-decoration: none; color: #ffffff;">Products</a></li>
        <li><a href="/about" style="text-decoration: none; color: #ffffff;">About Us</a></li>
        <li><a href="/contact" style="text-decoration: none; color: #ffffff;">Contact Us</a></li>

        @auth
            <li><a href="/cart" style="text-decoration: none; color: #ffffff;">Cart</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 1rem; color: #333;">Logout</button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}" style="text-decoration: none; color: #05458a; font-weight: bold;">Login</a></li>
            <li><a href="{{ route('register') }}" style="text-decoration: none; color: #05458a; font-weight: bold;">Register</a></li>
        @endauth
    </ul>
</nav>