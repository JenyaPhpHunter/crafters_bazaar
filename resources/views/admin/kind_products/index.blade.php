@extends('admin.layouts.app')

  @section('content')
      <div class="section section-padding pt-0">
          <div class="section section-fluid learts-mt-70">
              <div class="container">
                  <div class="row learts-mb-n50">
                      <div class="col-lg-9 col-12 learts-mb-50">
                          @foreach($kind_products as $kind_product)
                              <div class="category-container" id="category-{{ $kind_product->id }}">
                                  <!-- Контейнер для категорії та карандаша -->
                                  <a href="{{ route('admin_kind_products.show', ['admin_kind_product' => $kind_product->id]) }}">
                                      <span style="{{ $kind_product->checked == 0 ? 'color: red;' : '' }}">{{ $kind_product->name }}</span>
                                  </a>
                                  @isset($user)
                                      @can('edit', $kind_product)
                                          <a href="{{ route('admin_kind_products.edit', ['admin_kind_product' => $kind_product->id]) }}">
                                              <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                          </a>
                                      @endcan
                                  @endisset
                                  <div class="subcategories" id="subcategories-{{ $kind_product->id }}">
                                      @isset($kind_product->sub_kind_products)
                                          @foreach($kind_product->sub_kind_products as $sub_kind_product)
                                              <div class="subcategory-item">
                                                  <a href="{{ route('admin_sub_kind_products.show', ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                                      <span style="{{ $sub_kind_product->checked == 0 ? 'color: red;' : '' }}">{{ $sub_kind_product->name }}</span>
                                                  </a>
                                                  @isset($user)
                                                      @can('edit', $kind_product)
                                                      <a href="{{ route('admin_sub_kind_products.edit', ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                                          <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                                      </a>
                                                      @endcan
                                                  @endisset
                                              </div>
                                          @endforeach
                                      @endisset
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endsection

