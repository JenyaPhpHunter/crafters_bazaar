@extends('layouts.app')

@section('content')
    <div class="section section-fluid section-padding border-bottom animate__animated animate__fadeIn">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40 animate__animated animate__slideInRight">
                    @include('products.include.images')
                    @include('products.include.additional-info')
                </div>
                <!-- Product Summery Start -->
                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-summery product-summery-center animate__animated animate__slideInRight">
                        <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data" id="product-form" class="animate__animated animate__zoomIn">
                            @csrf
                            <input type="hidden" name="color_id" id="selectedColor" value="">
                            <input type="hidden" name="brand_id" id="selectedBrand" value="">
                            <input type="hidden" name="action" id="form-action" value="">
                            <input type="hidden" name="additional_information" id="additional-info-hidden" value="">
                            <div class="mb-4">
                                @include('products.include.title-price')
                            </div>
                            <div class="mb-4">
                                @include('products.include.kind-subkind')
                            </div>
                            <div class="mb-4">
                                @include('products.include.quantity-produce')
                            </div>
                            <div class="mb-4">
                                @include('products.include.colors')
                            </div>
                            <div class="mb-4">
                                @include('products.include.file_upload')
                            </div>
                            <div class="mb-4">
                                @include('products.include.brands')
                            </div>
                            <div class="mb-4">
                                @include('products.include.tags_social')
                            </div>
                        </form>
                        @isset($user)
                            @if(empty($user->name) || empty($user->surname) || empty($user->email) || empty($user->phone))
                                <div class="alert alert-warning alert-dismissible fade show mt-4 animate__animated animate__bounceIn" role="alert">
                                    <div class="col-auto learts-mb-20">
                                        <a href="{{ route('users.show', ['user' => $user->id]) }}#account-info"
                                           class="btn btn-secondary">Перейти в профіль</a>
                                    </div>
                                    <p>Перед тим як виставити товар на продаж, збережіть цей товар та заповніть
                                        обов'язкові поля у своєму профілі.</p>
                                </div>
                            @endif
                        @endisset
                    </div>
                </div>
                <!-- Product Summery End -->
            </div>
            <!-- Додаємо кнопки після обох колонок, по центру -->
            <div class="product-buttons-centered animate__animated animate__fadeInUp">
                @include('products.include.buttons')
            </div>
        </div>
    </div>

{{--    @include('products.include.product-info-tabs')--}}
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/photoswipe.min.css">
@endpush

@push('scripts')
    <!-- PhotoSwipe: галерея зображень -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe-lightbox.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // === PhotoSwipe: ініціалізація лайтбоксу для галереї ===
            if (typeof PhotoSwipeLightbox !== 'undefined' && $('.product-gallery-slider').length) {
                const lightbox = new PhotoSwipeLightbox({
                    gallery: '.product-gallery-slider',
                    children: '.product-zoom',
                    pswpModule: () => PhotoSwipe
                });
                lightbox.init();
            }

            // === Slick Slider: головна галерея ===
            if (typeof initSlick === 'function') {
                if ($('.product-gallery-slider').length) {
                    initSlick($('.product-gallery-slider'), {
                        dots: true,
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        asNavFor: '.product-thumb-slider, .product-thumb-slider-vertical',
                        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
                    });
                }

                // === Slick: вертикальні мініатюри ===
                if ($('.product-thumb-slider-vertical').length) {
                    initSlick($('.product-thumb-slider-vertical'), {
                        infinite: true,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        vertical: true,
                        focusOnSelect: true,
                        asNavFor: '.product-gallery-slider',
                        prevArrow: '<button class="slick-prev"><i class="ti-angle-up"></i></button>',
                        nextArrow: '<button class="slick-next"><i class="ti-angle-down"></i></button>'
                    });
                }
            }

            // === НАЗВА ТОВАРУ: синхронізація з hidden input ===
            const titleEditable = document.getElementById('title');
            const titleHidden = document.getElementById('title-hidden');
            const syncTitle = () => { titleHidden.value = titleEditable.textContent.trim(); };
            if (titleEditable && titleHidden) {
                titleEditable.addEventListener('input', syncTitle);
                titleEditable.addEventListener('blur', syncTitle);
                titleEditable.addEventListener('keydown', (e) => { if (e.key === 'Enter') e.preventDefault(); });
                if (titleEditable.textContent.trim()) syncTitle();
            }

            // === ЦІНА: ТІЛЬКИ ЦІЛЕ ЧИСЛО, ПО ЦЕНТРУ, БЕЗ .00 ===
            const priceEditable = document.getElementById('price_input');
            const priceHidden = document.getElementById('price-hidden');
            const syncPrice = () => {
                let value = priceEditable.value.replace(/[^\d]/g, '');
                if (value === '') {
                    priceEditable.value = '';
                    priceHidden.value = '';
                    return;
                }
                const num = parseInt(value, 10);
                if (!isNaN(num) && num >= 0) {
                    priceEditable.value = num;
                    priceHidden.value = num;
                } else {
                    priceEditable.value = '';
                    priceHidden.value = '';
                }
            };
            if (priceEditable && priceHidden) {
                priceEditable.addEventListener('input', syncPrice);
                priceEditable.addEventListener('blur', syncPrice);
                priceEditable.addEventListener('focus', () => { if (!priceEditable.value.trim()) priceEditable.value = ''; });
                priceEditable.addEventListener('keydown', (e) => { if (e.key === 'Enter') e.preventDefault(); });
                if (priceEditable.value.trim()) syncPrice();
            }

// === CUSTOM DROPDOWN: ФУНКЦІОНАЛ ===
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                const wrapper = dropdown.closest('.custom-dropdown-wrapper');
                const section = wrapper.closest('.form-section');
                const selected = dropdown.querySelector('.dropdown-selected');
                const options = dropdown.querySelector('.dropdown-options');
                const search = dropdown.querySelector('.dropdown-search');
                const hiddenInput = dropdown.querySelector('input[type="hidden"]');

                // Додавання/зняття класу .focused при фокусі
                const handleFocus = () => {
                    wrapper.classList.add('has-focus');
                    if (section) section.classList.add('focused');
                };
                const handleBlur = () => {
                    wrapper.classList.remove('has-focus');
                    if (section) section.classList.remove('focused');
                };

                selected.addEventListener('click', () => {
                    dropdown.classList.toggle('open');
                    if (dropdown.classList.contains('open')) {
                        search.focus();
                    }
                });

                selected.addEventListener('focus', handleFocus);
                selected.addEventListener('blur', handleBlur);
                search.addEventListener('focus', handleFocus);
                search.addEventListener('blur', handleBlur);

                search.addEventListener('input', () => {
                    const query = search.value.toLowerCase();
                    options.querySelectorAll('li').forEach(option => {
                        const text = option.getAttribute('data-title').toLowerCase();
                        option.style.display = text.includes(query) ? 'flex' : 'none';
                    });
                });

                options.querySelectorAll('li').forEach(option => {
                    option.addEventListener('click', () => {
                        selected.textContent = option.textContent;
                        hiddenInput.value = option.getAttribute('data-value');
                        selected.classList.add('selected-value'); // Додаємо клас для обраного значення
                        dropdown.classList.remove('open');
                        search.value = ''; // Очищаємо поле пошуку
                        selected.focus(); // Повертаємо фокус на selected
                    });
                });

                // Закриття при кліку поза dropdown
                document.addEventListener('click', (e) => {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('open');
                        search.value = ''; // Очищаємо поле пошуку при закритті
                        wrapper.classList.remove('has-focus');
                        if (section) section.classList.remove('focused');
                    }
                });

                // Ініціалізація: якщо вже є обране значення (наприклад, при редагуванні)
                if (hiddenInput.value) {
                    const initialOption = Array.from(options.querySelectorAll('li'))
                        .find(option => option.getAttribute('data-value') === hiddenInput.value);
                    if (initialOption) {
                        selected.textContent = initialOption.textContent;
                        selected.classList.add('selected-value');
                    }
                }
            });

// === CUSTOM DROPDOWN: Зміна кольору мітки при фокусі ===
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                const wrapper = dropdown.closest('.custom-dropdown-wrapper');
                const label = wrapper.previousElementSibling; // Беремо попередній sibling (label)
                const selected = dropdown.querySelector('.dropdown-selected');
                const search = dropdown.querySelector('.dropdown-search');

                const handleLabelFocus = () => {
                    if (label && label.classList.contains('form-label')) {
                        label.classList.add('label-focused');
                    }
                };

                const handleLabelBlur = () => {
                    if (label && label.classList.contains('form-label')) {
                        label.classList.remove('label-focused');
                    }
                };

                selected.addEventListener('focus', handleLabelFocus);
                selected.addEventListener('blur', handleLabelBlur);
                search.addEventListener('focus', handleLabelFocus);
                search.addEventListener('blur', handleLabelBlur);
            });
        });

        // Зняття фокусу при завантаженні
        window.onload = () => {
            document.querySelectorAll('.dropdown-selected, .dropdown-search, .form-control').forEach(el => {
                if (document.activeElement === el) el.blur();
            });
        };
    </script>
@endpush
