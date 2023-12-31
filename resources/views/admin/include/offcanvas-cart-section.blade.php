<!-- OffCanvas Cart Start -->
<div id="offcanvas-cart" class="offcanvas offcanvas-cart">
    <div class="inner">
        <div class="head">
            <span class="title">Cart</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
                <li>
                    <a href="{{ asset('product-details.html') }}" class="image"><img src="{{ asset('images/product/cart-product-1.webp') }}" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="{{ asset('product-details.html') }}" class="title">Walnut Cutting Board</a>
                        <span class="quantity-price">1 x <span class="amount">$100.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="{{ asset('product-details.html') }}" class="image"><img src="{{ asset('images/product/cart-product-2.webp') }}" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="{{ asset('product-details.html') }}" class="title">Lucky Wooden Elephant</a>
                        <span class="quantity-price">1 x <span class="amount">$35.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="{{ asset('product-details.html') }}" class="image"><img src="{{ asset('images/product/cart-product-3.webp') }}" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="{{ asset('product-details.html') }}" class="title">Fish Cut Out Set</a>
                        <span class="quantity-price">1 x <span class="amount">$9.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="foot">
            <div class="sub-total">
                <strong>Subtotal :</strong>
                <span class="amount">$144.00</span>
            </div>
            <div class="buttons">
                <a href="{{ asset('shopping-cart.html') }}" class="btn btn-dark btn-hover-primary">view cart</a>
                <a href="{{ asset('checkout.html') }}" class="btn btn-outline-dark">checkout</a>
            </div>
            <p class="minicart-message">Free Shipping on All Orders Over $100!</p>
        </div>
    </div>
</div>
<!-- OffCanvas Cart End -->
