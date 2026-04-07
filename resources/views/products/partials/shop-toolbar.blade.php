<!-- SHOP TOOLBAR -->
<div class="shop-toolbar section-fluid border-bottom">
    <div class="container">
        <div class="row learts-mb-n20">

            <!-- Таб-фільтри -->
            <div class="col-md col-12 align-self-center learts-mb-20">
                <div class="isotope-filter shop-product-filter" data-target="#shop-products">
                    <button class="active" data-filter="*">Всі товари</button>
                    <button data-filter=".featured">Рекомендовані</button>
                    <button data-filter=".new">Новинки</button>
                    <button data-filter=".sale">Акції</button>
                </div>
            </div>

            <!-- Controls -->
            <div class="col-md-auto col-12 learts-mb-20">
                <ul class="shop-toolbar-controls d-flex flex-wrap justify-content-end align-items-center gap-4">

                    <!-- Сортування зліва -->
                    <li class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-medium">Сортування:</span>
                        <div class="product-sorting">
                            <select id="sortProducts" class="nice-select">
                                <option value="menu_order">За замовчуванням</option>
                                <option value="price_up">Ціна: від низької</option>
                                <option value="price_down">Ціна: від високої</option>
                                <option value="newness">Найновіші</option>
                            </select>
                        </div>
                    </li>

                    <!-- Кнопки 3/4/5 колонок -->
                    <li>
                        <div class="product-column-toggle d-none d-xl-flex">
                            <button class="toggle hintT-top" data-column="5" title="5 колонок"><i class="ti-layout-grid4-alt"></i></button>
                            <button class="toggle active hintT-top" data-column="4" title="4 колонки"><i class="ti-layout-grid3-alt"></i></button>
                            <button class="toggle hintT-top" data-column="3" title="3 колонки"><i class="ti-layout-grid2-alt"></i></button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
