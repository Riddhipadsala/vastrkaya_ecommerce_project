<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-2">
    <div class="container">

        <!-- Logo -->
        <div>
            <img src="{{asset('logo.png')}}" alt="logo" style="height: 10rem; width: auto;">
        </div>

        <!-- Mobile Menu Button -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <li class="nav-item">
                    <a href="{{ url('/') }}"
                       class="nav-link fw-medium hover:bg-slate-100 transition-colors">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/products') }}"
                       class="nav-link fw-medium hover:bg-slate-100 transition-colors">
                        Products
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/categories') }}"
                       class="nav-link fw-medium hover:bg-slate-100 transition-colors">
                        Categories
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/login') }}"
                       class="btn btn-outline-success btn-sm px-3 mt-2 mt-lg-0">
                        Login
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/cart') }}"
                       class="btn btn-success btn-sm px-3 mt-2 mt-lg-0">
                        Cart
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>