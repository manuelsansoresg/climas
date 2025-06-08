<div wire:poll.5s wire:ignore.self>
    <a href="/cart" class="btn text-primary position-relative">
        <i class="fas fa-shopping-bag fa-lg"></i>
        @if($count > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $count }}</span>
        @endif
    </a>
</div> 