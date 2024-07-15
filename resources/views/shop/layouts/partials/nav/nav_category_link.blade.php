<li class="nav-item me-lg-4 dropdown position-static">

    <a class="nav-link fw-bolder dropdown-toggle py-lg-4" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ $navCategory['name'] }}
    </a>

    <!-- Menswear dropdown menu-->
    <div class="dropdown-menu dropdown-megamenu">

        <div class="container">

            <div class="row g-0">
                <!-- Dropdown Menu Links Section-->
                <div class="col-12 col-lg-6">

                    <div class="row py-lg-5">

                        <!-- menu row-->
                        <div class="col col-lg-6 mb-5 mb-sm-0">
                            <h6 class="dropdown-heading">Sous catégories</h6>

                            @if ($navCategory['subCategories'] !== null)
                                <ul class="list-unstyled">

                                    @php
                                        $navCategory['subCategories'] = explode(', ', $navCategory['subCategories']);
                                    @endphp

                                    @foreach ($navCategory['subCategories'] as $subCategory)
                                        @php
                                            $subCategoryId = explode(' : ', $subCategory)[0];
                                            $subCategoryName = explode(' : ', $subCategory)[1];
                                        @endphp

                                        <li class="dropdown-list-item">
                                            <a class="dropdown-item" href="{{ route('shop.products-categories', $subCategoryId) }}">{{ $subCategoryName }}</a>
                                        </li>
                                    @endforeach

                                    <li class="dropdown-list-item"><a class="dropdown-item dropdown-link-all"
                                            href="{{ route('shop.products-categories', $navCategory['id']) }}">Voir tout</a></li>

                                </ul>
                            @else
                                N/A
                            @endif

                        </div>
                        <!-- /menu row-->

                        <!-- menu row-->
                        <div class="col col-lg-6">
                            <h6 class="dropdown-heading">Marques</h6>

                            <ul class="list-unstyled">

                                @foreach ($navCategory['brands'] as $categoryBrand => $count)
                                    <li class="dropdown-list-item">
                                        <a class="dropdown-item" href="#">{{ $categoryBrand }}</a>
                                    </li>
                                @endforeach

                                <li class="dropdown-list-item"><a class="dropdown-item dropdown-link-all"
                                        href="#">Voir tout</a></li>

                            </ul>
                        </div>
                        <!-- /menu row-->

                    </div>

                </div>
                <!-- /Dropdown Menu Links Section-->

                <!-- Dropdown Menu Images Section-->
                <div class="d-none d-lg-block col-lg-6">
                    <div class="vw-50 h-100 bg-img-cover bg-pos-center-center position-absolute"
                        style="background-image: url('{{ asset('storage/' . $navCategory['image_path']) }}');">
                    </div>
                </div>
                <!-- Dropdown Menu Images Section-->
            </div>

        </div>

    </div>
    <!-- / Menswear dropdown menu-->

</li>
