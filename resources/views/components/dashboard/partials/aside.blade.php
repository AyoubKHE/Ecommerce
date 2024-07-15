<div id="layoutSidenav_nav">

    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">

            <div class="nav">

                <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                </a>

                <div class="sb-sidenav-menu-heading">Produits</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Produits
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseProducts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('products.index') }}">Affichage des produits</a>
                        <a class="nav-link" href="{{ route('products.create') }}">Ajouter un produit</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Catégories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseCategories" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('products-categories.index') }}">Affichage des catégories</a>
                        <a class="nav-link" href="{{ route('products-categories.create') }}">Ajouter une catégorie</a>
                    </nav>

                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBrands"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Marques
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseBrands" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('brands.index') }}">Affichage des marques</a>
                        <a class="nav-link" href="{{ route('brands.create') }}">Ajouter une marque</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseProductsAttributes" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Attributs de produits
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseProductsAttributes" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('products-attributes.index') }}">Affichage des attributs</a>
                        <a class="nav-link" href="{{ route('products-attributes.create') }}">Ajouter un attribut</a>
                    </nav>

                </div>

{{-- !----------------------------------------------------------------------------------------------------------------------------------- --}}

                <div class="sb-sidenav-menu-heading">Utilisateurs</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Utilisateurs
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseUsers" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('users.index') }}">Affichage des
                            utilisateurs</a>
                        <a class="nav-link" href="{{ route('users.create') }}">Ajouter un
                            utilisateur</a>
                    </nav>

                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseCustomers" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Clients
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseCustomers" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Affichage des
                            clients</a>
                        <a class="nav-link" href="#">Ajouter un
                            client</a>
                    </nav>

                </div>

{{-- !----------------------------------------------------------------------------------------------------------------------------------- --}}

                <div class="sb-sidenav-menu-heading">Vitrine</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseShowcase" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Vitrine
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseShowcase" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('showcase.header.edit') }}">Entête</a>
                        <a class="nav-link" href="{{ route('showcase.body.edit') }}">Corp</a>
                    </nav>

                </div>

            </div>

        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: <span
                    style="color: #0d6efd; font-weight: bold; margin-left: 10px">{{ auth()->user()->username }}</span>
            </div>
        </div>

    </nav>

</div>
