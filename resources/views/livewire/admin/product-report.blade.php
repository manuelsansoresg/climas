<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Reporte de productos</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                {{-- <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li class="nk-block-tools-opt">
                                            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Nuevo Cliente
                                            </a>
                                        </li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3 mb-4" wire:submit.prevent="applyFilters">
                                <div class="col-md-2">
                                    <label>Desde</label>
                                    <input type="date" class="form-control" wire:model.defer="filters.date_from">
                                </div>
                                <div class="col-md-2">
                                    <label>Hasta</label>
                                    <input type="date" class="form-control" wire:model.defer="filters.date_to">
                                </div>
                                <div class="col-md-2">
                                    <label>Categoría</label>
                                    <select class="form-control" wire:model="filters.category_id">
                                        <option value="">Todas</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Subcategoría</label>
                                    <select class="form-control" wire:model="filters.subcategory_id" @if(!$filters['category_id']) disabled @endif>
                                        <option value="">Todas</option>
                                        @foreach($subcategories as $subcat)
                                            <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Subcategoría 2</label>
                                    <select class="form-control" wire:model="filters.subcategory2_id" @if(!$filters['subcategory_id']) disabled @endif>
                                        <option value="">Todas</option>
                                        @foreach($subcategories2 as $subcat2)
                                            <option value="{{ $subcat2->id }}">{{ $subcat2->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Subcategoría 3</label>
                                    <select class="form-control" wire:model="filters.subcategory3_id" @if(!$filters['subcategory2_id']) disabled @endif>
                                        <option value="">Todas</option>
                                        @foreach($subcategories3 as $subcat3)
                                            <option value="{{ $subcat3->id }}">{{ $subcat3->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" wire:model.defer="filters.name" placeholder="Buscar por nombre">
                                </div>
                                <div class="col-md-2 mt-4 align-self-end">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </form>
                            <div class="table-responsive position-relative">
                                @if($loading)
                                    <div class="justify-content-center align-items-center position-absolute w-100 h-100 bg-white bg-opacity-50" style="z-index:10;top:0;left:0;min-height:120px;display:flex;">
                                        <div class="spinner-border text-primary" role="status" style="width:2.5rem;height:2.5rem;">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Subcategoría</th>
                                            <th>Subcategoría 2</th>
                                            <th>Subcategoría 3</th>
                                            <th>Precio Público</th>
                                            <th>Existencia</th>
                                            <th>Vendidos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>{{ $product->subcategory->name ?? 'N/A' }}</td>
                                                <td>{{ $product->subcategory2->name ?? 'N/A' }}</td>
                                                <td>{{ $product->subcategory3->name ?? 'N/A' }}</td>
                                                <td>${{ number_format($product->precio_publico, 2) }}</td>
                                                <td>{{ $product->existencia }}</td>
                                                <td>{{ $product->vendidos }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No hay productos para mostrar.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
