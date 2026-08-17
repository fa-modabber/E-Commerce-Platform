 <header class="header_section">
     <div class="container">
         <nav class="navbar navbar-expand-lg custom_nav-container">
             <a class="navbar-brand" href="{{ route('home') }}">
                 <span>
                     مرچیفای
                 </span>
             </a>

             <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                 data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                 aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>

             <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <ul class="navbar-nav mx-auto">
                     <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                         <a class="nav-link" href="{{ route('home') }}">صفحه اصلی</a>
                     </li>
                     <li class="nav-item {{ request()->is('menu') ? 'active' : '' }}">
                         <a class="nav-link" href="{{ route('products.menu') }}">منو محصولات</a>
                     </li>
                     <li class="nav-item {{ request()->is('about-us') ? 'active' : '' }}">
                         <a class="nav-link" href="{{ route('about-us') }}">درباره ما</a>
                     </li>
                     <li class="nav-item {{ request()->is('contact-us') ? 'active' : '' }}">
                         <a class="nav-link" href="{{ route('contact-us.index') }}">تماس باما</a>
                     </li>
                 </ul>
                 <div class="user_option">
                     <a class="cart_link position-relative" href="{{ route('cart.index') }}">
                         <i class="bi bi-cart-fill text-white fs-5"></i>
                         <span class="position-absolute top-0 translate-middle badge rounded-pill">
                             {{ session()->has('cart') ? count(session()->get('cart')) : 0 }}
                         </span>
                     </a>
                     @auth
                         <a href="{{ route('profile.index') }}" class="btn-auth">
                             پروفایل
                         </a>
                     @endauth
                     @guest
                         <a href="{{ route('auth.loginForm') }}" class="btn-auth">
                             ورود
                         </a>
                     @endguest
                 </div>
             </div>
         </nav>
     </div>
 </header>
