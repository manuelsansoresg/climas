<div class="container mt-5">
    <!-- Barra de búsqueda y ordenamiento -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" class="form-control"  wire:model.debounce.300ms="search" placeholder="Buscar productos..." aria-label="Buscar productos">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" wire:model="orderBy">
                <option value="name_asc">Nombre: A-Z</option>
                <option value="name_desc">Nombre: Z-A</option>
                <option value="price_asc">Precio: Menor a Mayor</option>
                <option value="price_desc">Precio: Mayor a Menor</option>
            </select>
        </div>
    </div>

    <!-- Filtros activos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-primary p-2">Aires Acondicionados <i class="fas fa-times ms-1"></i></span>
                <span class="badge bg-primary p-2">Split <i class="fas fa-times ms-1"></i></span>
                <span class="badge bg-primary p-2">LG <i class="fas fa-times ms-1"></i></span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar de filtros -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Categorías</h6>
                    <div class="categories-list">
                        <div class="mb-2">
                            
                            <div class="">
                                @foreach($categories as $category)
                                <div class="category-item mb-2">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}" id="cat{{ $category->id }}">
                                        <label class="form-check-label ms-2 cursor-pointer" for="cat{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                    @if($category->subcategories && $category->subcategories->count() > 0)
                                        <div class="subcategories-list ms-4 mt-2">
                                            @foreach($category->subcategories as $subcategory)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" wire:model="selectedCategories" value="{{ $subcategory->id }}" id="cat{{ $subcategory->id }}">
                                                    <label class="form-check-label cursor-pointer" for="cat{{ $subcategory->id }}">
                                                        {{ $subcategory->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                        </div>
                        
                    </div>

                    <h6 class="card-title fw-bold mb-3 mt-4">Precio</h6>
                    <div class="brands-list">
                        <div class="price-range">
                            <div class="mb-3">
                                <label for="minPrice" class="form-label text-muted">Precio mínimo</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" wire:model="minPrice" id="minPrice" placeholder="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="maxPrice" class="form-label text-muted">Precio máximo</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" wire:model="maxPrice" id="maxPrice" placeholder="99999">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de productos -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold" style="color:#003366;">Productos</h3>
                <span class="text-muted">12 productos encontrados</span>
            </div>
            
            <div class="row g-4">

                @foreach($products as $product)
                    <!-- Producto  -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">OFERTA</span>
                        </div>
                        <img src="{{ asset($product->image) }}" class="card-img-top p-3" alt="{{ $product->name }}">
                        <div class="card-body text-center">
                            {{-- <div class="text-muted small mb-1">MABE</div> --}}
                            <h5 class="card-title mb-2">{{ $product->name }}</h5>
                            <div class="mb-2">
                                <span class="fw-bold fs-5 text-primary">${{ number_format($product->precio_publico, 2) }}</span>
                                {{-- <span class="text-decoration-line-through text-muted ms-2">$ 6,332.00</span> --}}
                            </div>
                            <a href="/productos/prueba" class="btn btn-primary w-100">Ver Detalles</a>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
</div>