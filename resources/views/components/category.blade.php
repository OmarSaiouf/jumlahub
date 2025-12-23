<a class="category-card" href="{{ route('main.category.show', $category['id']) }}">
    <div>
        <div>
            <img class="category-icon" src="{{ $category['image'] ?? asset('images/iconsCategory.png') }}">
        </div>
        <h3>{{ $category['name'] }}</h3>
        <p>{{ $category['description'] }}</p>
    </div>
</a>
