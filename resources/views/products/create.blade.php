@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!-- Single Products Section Start -->
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <!-- Product Images Start -->
                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-images">
                        <button class="product-gallery-popup hintT-left" data-hint="Натисніть, щоб збільшити" data-images='[
                            {"src": "{{ asset('images/product/single/1/product-zoom-1.webp') }}", "w": 700, "h": 1100},
                            {"src": "{{ asset('images/product/single/1/product-zoom-2.webp') }}", "w": 700, "h": 1100},
                            {"src": "{{ asset('images/product/single/1/product-zoom-3.webp') }}", "w": 700, "h": 1100},
                            {"src": "{{ asset('images/product/single/1/product-zoom-4.webp') }}", "w": 700, "h": 1100}
                        ]'><i class="far fa-expand"></i></button>
                        <a href="https://www.youtube.com/watch?v=1jSsy7DtYgc"
                           class="product-video-popup video-popup hintT-left" data-hint="Click to see video"><i
                                class="fal fa-play"></i></a>
                        <div class="product-gallery-slider">
                            <div class="product-zoom"
                                 data-image="{{ asset('images/product/single/1/product-zoom-1.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-1.webp') }}" alt="">
                            </div>
                            <div class="product-zoom"
                                 data-image="{{ asset('images/product/single/1/product-zoom-2.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-2.webp') }}" alt="">
                            </div>
                            <div class="product-zoom"
                                 data-image="{{ asset('images/product/single/1/product-zoom-3.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-3.webp') }}" alt="">
                            </div>
                            <div class="product-zoom"
                                 data-image="{{ asset('images/product/single/1/product-zoom-4.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-4.webp') }}" alt="">
                            </div>
                        </div>
                        <div class="product-thumb-slider">
                            <div class="item">
                                <img src="{{ asset('images/product/single/1/product-thumb-1.webp') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/product/single/1/product-thumb-2.webp') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/product/single/1/product-thumb-3.webp') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/product/single/1/product-thumb-4.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- Single Products Infomation Section Start -->
                    <div class="section section-padding border-bottom">
                        <div class="container">
                            <label for="additional_information">Додаткова інформація</label>
                            <textarea id="additional_information" name="additional_information" rows="10" cols="50"
                                      placeholder="За необхідності внесіть додаткову інформацію про товар" style="border: 1px solid black; padding-left: 0.5em;">{{ old('additional_information') }}</textarea>
                            <div class="product-meta">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="label"><span>Теги</span></td>
                                        <td class="value">
                                            <ul class="product-tags">
                                                <li><a href="#">handmade</a></li>
                                                <li><a href="#">learts</a></li>
                                                <li><a href="#">mug</a></li>
                                                <li><a href="#">product</a></li>
                                                <li><a href="#">learts</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label"><span>Поширити</span></td>
                                        <td class="va">
                                            <div class="product-share">
                                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                                <a href="#"><i class="fab fa-twitter"></i></a>
                                                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                                <a href="#"><i class="fab fa-pinterest"></i></a>
                                                <a href="#"><i class="fal fa-envelope"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Single Products Infomation Section End -->
                </div>
                <!-- Product Images End -->

                <!-- Product Summery Start -->
                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-summery">
                        <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="color_id" id="selectedColor" value="">

                            <label for="name">Назва</label>
                            <br>
                            <input id="name" name="name" type="text" class="product-title"
                                   placeholder="Введіть назву товару" value="{{ old('name') }}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>

                            <label for="price">Вартість, грн</label>
                            <br>
                            <input type="number" id="price" name="price" min="0" step="1" class="product-title"
                                   placeholder="Введіть вартість товару" value="{{ old('price') }}">
                            @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>

                            <label for="content">Інформація про товар</label>
                            <br>
                            <textarea id="content" name="content" rows="10" cols="50"
                                      placeholder="Введіть опис товару, щоб зацікавити покупця">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>

                            <label for="kind_product_id">Вид товару</label>
                            <br>
                            <div class="row mb-n3">
                                <div class="col-lg-4 col-12 mb-3">
                                    <select class="search-select select2-basic" id="kind_product_id" name="kind_product_id">
                                        @foreach($kind_products as $kind_product)
                                            <option value="{{ $kind_product->id }}" {{ old('kind_product_id', $selected_kind_product_id) == $kind_product->id ? 'selected' : '' }}>{{ $kind_product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('kind_product_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>
                            <button type="submit" name="action" value="add_kind" class="btn btn-primary3">
                                <i class="fab fa-galactic-republic"></i> {{ $action_types['add_kind'] }}
                            </button>
                            <br><br>

                            <label for="sub_kind_product_id">Підвид товару</label>
                            <br>
                            <div class="row mb-n3">
                                <div class="col-lg-4 col-12 mb-3">
                                    <select class="search-select select2-basic" id="sub_kind_product_id" name="sub_kind_product_id">
                                        @foreach($sub_kind_products as $sub_kind_product)
                                            <option value="{{ $sub_kind_product->id }}" {{ old('sub_kind_product_id', $selected_sub_kind_product_id) == $sub_kind_product->id ? 'selected' : '' }}>{{ $sub_kind_product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('sub_kind_product_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>
                            <button type="submit" name="action" value="add_sub_kind" class="btn btn-primary3">
                                <i class="fab fa-galactic-republic"></i> {{ $action_types['add_sub_kind'] }}
                            </button>
                            <br><br>

                            <label for="quantity">Кількість виробів в наявності</label>
                            <div class="product-quantity">
                                <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                <input type="text" class="input-qty" name="stock_balance" id="stockBalance" value="{{ old('stock_balance', 1) }}">
                                <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                @error('stock_balance')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br><br>
                            <label for="quantity">Можу виробити цей товар ще</label>
                            <input type="checkbox" id="can_produce" name="can_produce">
                            <div id="termCreationWrapper" style="display: none;">
                                <br>
                                <label for="quantity_day">Кількість днів для виготовлення і відправки</label>
                                <div id="termCreationBlock">
                                    <div class="product-quantity">
                                        <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                        <input type="text" class="input-qty" name="term_creation" value="{{ old('term_creation', 0) }}">
                                        <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="product-variations">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="label"><span>Колір</span></td>
                                        <td class="value">
                                            @foreach($colors as $key => $color)
                                                <div
                                                    class="circle"
                                                    id="circle{{ $key + 1 }}"
                                                    data-name="Circle {{ $key + 1 }}"
                                                    data-color="{{ $color->code }}"
                                                    onclick="selectColor(this)"
                                                ></div>
                                                <style>
                                                    #circle{{ $key+1 }}  {
                                                        background-color: {{ $color->code }};
                                                    }
                                                </style>
                                            @endforeach
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <label for="product_photo" class="file-input-label">
                                <i class="fas fa-image"></i> <span id="file-label">Виберіть фото</span>
                            </label>
                            <input type="file" id="product_photo" name="product_photo[]" multiple style="display: none;" onchange="updateFileLabel(this);">
                            <br><br>
                            <div class="product-buttons">
                                <button type="submit" name="action" value="put_up_for_sale"
                                        class="btn btn-dark btn-outline-hover-dark">
                                    <i class="fas fa-donate"></i> {{ $action_types['put_up_for_sale'] }}
                                </button>
                                <button type="submit" name="action" value="save"
                                        class="btn btn-dark btn-outline-hover-dark">
                                    <i class="fas fa-save"></i> {{ $action_types['save'] }}
                                </button>
                            </div>
                        </form>
                        @if($user)
                            @if(empty($user->name) || empty($user->surname) || empty($user->email) || empty($user->phone))
                                <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                                    <div class="col-auto learts-mb-20">
                                        <a href="{{ route('users.show', ['user' => $user->id]) }}#account-info" class="btn btn-secondary">Перейти в профіль</a>
                                    </div>
                                    <p>Перед тим як виставити товар на продаж, збережіть цей товар та  заповніть обов'язкові поля у своєму профілі.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <!-- Product Summery End -->
            </div>
        </div>
    </div>
    <!-- Single Products Section End -->
@endsection

