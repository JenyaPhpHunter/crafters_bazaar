<div>
    <header>
        @include('admin.layouts.app')
        @include('admin.include.offcanvas-cart-section')
        @include('admin.include.offcanvas-search-section')
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <!-- Додайте футер, якщо потрібно -->
    </footer>
</div>
