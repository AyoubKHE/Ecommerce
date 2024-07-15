<!-- Products-->
<div class="row g-4 mb-5">

    @foreach ($products as $product)
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

</div>
<!-- / Products-->

<!-- Pagination-->

@if (count($linksData['links']) > 1)
    <nav class="border-top mt-5 pt-5 d-flex justify-content-between align-items-center" aria-label="Category Pagination">

        <ul class="pagination">
            <li class="page-item {{ $linksData['currentPage'] == 1 ? 'disabled' : '' }}">
                <a class="page-link"
                    href="{{ 'http://127.0.0.1:8000/api/shop/products-categories?categoryId=' . $product_category_id . '&page=' . $linksData['currentPage'] - 1 }}">
                    Précédent
                </a>
            </li>
        </ul>


        <ul class="pagination">
            @foreach ($linksData['links'] as $key => $link)
                <li class="page-item {{ $key + 1 == $linksData['currentPage'] ? 'active' : '' }}">
                    <a class="page-link" href="{{ $link }}">{{ $key + 1 }}
                    </a>
                </li>
            @endforeach
        </ul>



        <ul class="pagination">
            <li class="page-item {{ $linksData['currentPage'] == $linksData['lastPage'] ? 'disabled' : '' }}">
                <a class="page-link"
                    href="{{ 'http://127.0.0.1:8000/api/shop/products-categories?categoryId=' . $product_category_id . '&page=' . $linksData['currentPage'] + 1 }}">
                    Prochain

                </a>
            </li>
        </ul>
    </nav>
@endif

<!-- / Pagination-->
