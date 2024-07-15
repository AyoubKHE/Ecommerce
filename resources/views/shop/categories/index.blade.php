@extends('shop.layouts.master', ['navCategories' => $data['navCategories']])

@section('content')
    <section class="mt-0 ">

        <!-- Category Top Banner -->
        <div class="py-6 bg-img-cover bg-dark bg-overlay-gradient-dark position-relative overflow-hidden mb-4 bg-pos-center-center"
            style="background-image: url('{{ asset('storage/' . $data['productCategoryData']['image_path']) }}'); background-size: contain;">
            <div class="container position-relative z-index-20" data-aos="fade-right" data-aos-delay="300">

                <h1 class="fw-bold display-6 mb-4 text-white">{{ $data['productCategoryData']['name'] }}
                    ({{ $data['productCategoryData']['productsCount'] }})</h1>
                <input type="hidden" id="product-category-id" value="{{ $data['productCategoryData']['id'] }}">
                <div class="col-12 col-md-6">
                    <p class="lead text-white mb-0">
                        {{ $data['productCategoryData']['description'] }}
                    </p>
                </div>
            </div>
        </div>
        <!-- Category Top Banner -->

        <div class="container">

            <div class="row">

                <!-- Category Aside/Sidebar -->
                <div class="d-none d-lg-flex col-lg-3">

                    <div class="pe-4">
                        <!-- Category Aside -->
                        <aside>

                            <!-- Filter Category -->
                            @isset($data['subCategoriesProductsCount'])
                                <div class="mb-4">
                                    <h2 class="mb-4 fs-6 mt-2 fw-bolder">{{ $data['productCategoryData']['name'] }}</h2>
                                    <nav>
                                        <ul class="list-unstyled list-default-text">

                                            @foreach ($data['subCategoriesProductsCount'] as $sub_category_id => $sub_category_info)
                                                <li class="mb-2">
                                                    <a class="text-decoration-none text-body text-secondary-hover transition-all d-flex justify-content-between align-items-center"
                                                        href="{{ route('shop.products-categories', $sub_category_id) }}">
                                                        <span>
                                                            <i class="ri-arrow-right-s-line align-bottom ms-n1"></i>
                                                            {{ $sub_category_info['category_name'] }}
                                                        </span>
                                                        <span
                                                            class="text-muted ms-4">({{ $sub_category_info['products_count'] }})</span>
                                                    </a>
                                                </li>
                                            @endforeach


                                        </ul>
                                    </nav>
                                </div>
                            @endisset

                            <!-- / Filter Category-->

                            <!-- Price Filter -->
                            <div class="py-4 widget-filter widget-filter-price border-top">
                                <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                                    data-bs-toggle="collapse" href="#filter-price" role="button" aria-expanded="true"
                                    aria-controls="filter-price">
                                    Price
                                </a>
                                <div id="filter-price" class="collapse show">
                                    <div class="filter-price mt-6"></div>
                                    <div class="d-flex justify-content-between align-items-center mt-7">
                                        <div class="input-group mb-0 me-2 border">
                                            <span
                                                class="input-group-text bg-transparent fs-7 p-2 text-muted border-0">DA</span>
                                            <input type="number"
                                                min="{{ $data['productCategoryData']['MinMaxPrices']['min_price'] }}"
                                                max="{{ $data['productCategoryData']['MinMaxPrices']['max_price'] }}"
                                                value="{{ $data['productCategoryData']['MinMaxPrices']['min_price'] }}"
                                                step="1"
                                                class="filter-min form-control-sm border flex-grow-1 text-muted border-0">
                                        </div>
                                        <div class="input-group mb-0 ms-2 border">
                                            <span
                                                class="input-group-text bg-transparent fs-7 p-2 text-muted border-0">DA</span>
                                            <input type="number"
                                                min="{{ $data['productCategoryData']['MinMaxPrices']['min_price'] }}"
                                                max="{{ $data['productCategoryData']['MinMaxPrices']['max_price'] }}"
                                                value="{{ $data['productCategoryData']['MinMaxPrices']['max_price'] }}"
                                                step="1"
                                                class="filter-max form-control-sm flex-grow-1 text-muted border-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Price Filter -->

                            <!-- Brands Filter -->
                            <div class="py-4 widget-filter border-top">
                                <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                                    data-bs-toggle="collapse" href="#filter-brands" role="button" aria-expanded="true"
                                    aria-controls="filter-brands">
                                    Brands
                                </a>
                                <div id="filter-brands" class="collapse show">
                                    <div class="input-group my-3 py-1">
                                        <input type="text" class="form-control py-2 filter-search rounded"
                                            placeholder="Search" aria-label="Search">
                                        <span
                                            class="input-group-text bg-transparent px-2 position-absolute top-7 end-0 border-0 z-index-20"><i
                                                class="ri-search-2-line text-muted"></i></span>
                                    </div>
                                    <div class="simplebar-wrapper">
                                        <div class="filter-options" data-pixr-simplebar>

                                            @foreach ($data['productCategoryData']['productsBrands'] as $brand_name => $brand_count)
                                                <div class="form-group form-check mb-0">
                                                    <input type="checkbox" class="form-check-input" id="filter-brand-0">
                                                    <label
                                                        class="form-check-label fw-normal text-body flex-grow-1 d-flex justify-content-between"
                                                        for="filter-brand-0">{{ $brand_name }} <span
                                                            class="text-muted">({{ $brand_count }})</span></label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Brands Filter -->

                            <!-- Other Filters -->
                            @foreach ($data['productCategoryData']['productsAttributes'] as $product_attribute => $product_attribute_options)
                                <div class="py-4 widget-filter border-top">

                                    <a class="small text-body text-decoration-none text-secondary-hover transition-all transition-all fs-6 fw-bolder d-block collapse-icon-chevron"
                                        data-bs-toggle="collapse"
                                        href="#filter-{{ str_replace(' ', '-', $product_attribute) }}" role="button"
                                        aria-expanded="true"
                                        aria-controls="filter-{{ str_replace(' ', '-', $product_attribute) }}">
                                        {{ $product_attribute }}
                                    </a>
                                    <div id="filter-{{ str_replace(' ', '-', $product_attribute) }}" class="collapse show">
                                        <div class="filter-options mt-3">

                                            @foreach ($product_attribute_options as $key => $option)
                                                <div
                                                    class="form-group d-inline-block mr-2 mb-2 form-check-bg form-check-custom">
                                                    <input type="checkbox" class="form-check-bg-input"
                                                        id="filter-{{ str_replace(' ', '-', $product_attribute) }}-{{ $key }}">
                                                    <label class="form-check-label fw-normal"
                                                        for="filter-{{ str_replace(' ', '-', $product_attribute) }}-{{ $key }}">{{ $option }}</label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- / Other Filters -->
                        </aside>
                        <!-- / Category Aside-->
                    </div>

                </div>
                <!-- / Category Aside/Sidebar -->

                <!-- Category Products-->
                <div class="col-12 col-lg-9">

                    <!-- Top Toolbar-->
                    <div class="mb-4 d-md-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center flex-grow-1 mb-4 mb-md-0">
                            <small class="d-inline-block fw-bolder">Filtered by:</small>
                            <ul class="list-unstyled d-inline-block mb-0 ms-2">
                                <li class="bg-light py-1 fw-bolder px-2 cursor-pointer d-inline-block me-1 small">Type:
                                    Slip On <i class="ri-close-circle-line align-bottom ms-1"></i></li>
                            </ul>
                            <span
                                class="fw-bolder text-muted-hover text-decoration-underline ms-2 cursor-pointer small">Clear
                                All</span>
                        </div>
                        <div class="d-flex align-items-center flex-column flex-md-row">
                            <!-- Filter Trigger-->
                            <button
                                class="btn bg-light p-3 d-flex d-lg-none align-items-center fs-xs fw-bold text-uppercase w-100 mb-2 mb-md-0 w-md-auto"
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters"
                                aria-controls="offcanvasFilters">
                                <i class="ri-equalizer-line me-2"></i> Filters
                            </button>
                            <!-- / Filter Trigger-->
                            <div class="dropdown ms-md-2 lh-1 p-3 bg-light w-100 mb-2 mb-md-0 w-md-auto">
                                <p class="fs-xs fw-bold text-uppercase text-muted-hover p-0 m-0" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Sort By <i
                                        class="ri-arrow-drop-down-line ri-lg align-bottom"></i></p>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item fs-xs fw-bold text-uppercase text-muted-hover mb-2"
                                            href="#">Price: Hi Low</a></li>
                                    <li><a class="dropdown-item fs-xs fw-bold text-uppercase text-muted-hover mb-2"
                                            href="#">Price: Low Hi</a></li>
                                    <li><a class="dropdown-item fs-xs fw-bold text-uppercase text-muted-hover mb-2"
                                            href="#">Name</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- / Top Toolbar-->

                    <div id="products-table">
                        {{-- <!-- Products-->
                        <div class="row g-4 mb-5">

                            @if (isset($data['productCategoryData']['products']))
                                @foreach ($data['productCategoryData']['products'] as $product)
                                    <div class="col-12 col-sm-6 col-md-4">

                                        @php
                                            $product->product_images = explode(', ', $product->product_images);

                                            $image1Path = explode(
                                                ' | ',
                                                collect($product->product_images)
                                                    ->filter(function ($image) {
                                                        $is_default = explode(' | ', $image)[0];

                                                        return $is_default == 1;
                                                    })
                                                    ->first(),
                                            )[1];

                                            $imageHoverPath = explode(
                                                ' | ',
                                                collect($product->product_images)
                                                    ->filter(function ($image) {
                                                        $is_default = explode(' | ', $image)[0];

                                                        return $is_default == 0;
                                                    })
                                                    ->first(),
                                            )[1];

                                        @endphp

                                        <!-- Card Product-->
                                        @include('shop.layouts.products.product_card', [
                                            'productName' => $product->name,
                                            'productPrice' => $product->price,
                                            'productRating' => $product->rating ?? 50,
                                            'image1Path' => $image1Path,
                                            'imageHoverPath' => $imageHoverPath,
                                        ])
                                        <!--/ Card Product-->
                                    </div>
                                @endforeach
                            @else
                                @foreach ($data['productCategoryData']['subCategoriesProducts']['products'] as $sub_categories_products)
                                    @foreach ($sub_categories_products as $sub_category_product)
                                        <div class="col-12 col-sm-6 col-md-4">

                                            @php
                                                $sub_category_product->product_images = explode(
                                                    ', ',
                                                    $sub_category_product->product_images,
                                                );

                                                $image1Path = explode(
                                                    ' | ',
                                                    collect($sub_category_product->product_images)
                                                        ->filter(function ($image) {
                                                            $is_default = explode(' | ', $image)[0];

                                                            return $is_default == 1;
                                                        })
                                                        ->first(),
                                                )[1];

                                                $imageHoverPath = explode(
                                                    ' | ',
                                                    collect($sub_category_product->product_images)
                                                        ->filter(function ($image) {
                                                            $is_default = explode(' | ', $image)[0];

                                                            return $is_default == 0;
                                                        })
                                                        ->first(),
                                                )[1];

                                            @endphp


                                            <!-- Card Product-->
                                            @include('shop.layouts.products.product_card', [
                                                'productName' => $sub_category_product->name,
                                                'productPrice' => $sub_category_product->price,
                                                'productRating' => $sub_category_product->rating ?? 50,
                                                'image1Path' => $image1Path,
                                                'imageHoverPath' => $imageHoverPath,
                                            ])
                                            <!--/ Card Product-->
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif

                        </div>
                        <!-- / Products-->

                        <!-- Pagination-->

                        @if (count($data['linksData']['links']) > 1)
                            <nav class="border-top mt-5 pt-5 d-flex justify-content-between align-items-center"
                                aria-label="Category Pagination">

                                <ul class="pagination">
                                    <li class="page-item {{ $data['linksData']['currentPage'] == 1 ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href={{ 'http://127.0.0.1:8000/products-categories?page=' . $data['linksData']['currentPage'] - 1 }}>
                                            <i class="ri-arrow-left-line align-bottom"></i>
                                        </a>
                                    </li>
                                </ul>


                                <ul class="pagination">
                                    @foreach ($data['linksData']['links'] as $key => $link)
                                        <li
                                            class="page-item {{ $key + 1 == $data['linksData']['currentPage'] ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $link }}">{{ $key + 1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>



                                <ul class="pagination">
                                    <li
                                        class="page-item {{ $data['linksData']['currentPage'] == $data['linksData']['lastPage'] ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ 'http://127.0.0.1:8000/products-categories?page=' . $data['linksData']['currentPage'] + 1 }}">
                                            <i class="ri-arrow-right-line align-bottom"></i>

                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif

                        <!-- / Pagination--> --}}

                        @include('shop.layouts.products.products_table', [
                            'product_category_id' => $data['productCategoryData']['id'],
                            'products' =>
                                $data['productCategoryData']['products'],
                            'linksData' => $data['linksData'],
                        ])


                    </div>


                    <!-- Related Categories-->
                    <div class="border-top mt-5 pt-5">
                        <p class="lead fw-bolder">
                            {{ $data['productCategoryData']['parent_id'] == null ? 'Autre catégories' : 'Catégories associées' }}
                        </p>
                        <div class="d-flex flex-wrap justify-content-start align-items-center">

                            @foreach ($data['relatedCategories'] as $related_category)
                                <a class="btn btn-sm btn-outline-dark rounded-pill me-2 mb-2 mb-md-0 text-white-hover"
                                    style="margin-bottom: 10px !important"
                                    href="{{ route('shop.products-categories', $related_category['id']) }}">{{ $related_category['name'] }}</a>
                            @endforeach

                        </div>
                    </div>
                    <!-- Related Categories-->

                </div>
                <!-- / Category Products-->

            </div>
        </div>

    </section>
@endsection

@section('js')
    <script src="{{ asset('js/myScripts/shop/main.js') }}"></script>
@endsection
