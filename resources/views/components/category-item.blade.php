<div class="category-list-item">
    <div class="category-list-icon" style="background-color: {{ $category->show ? $category->color : 'transparent' }}">
        <i class="{{ $category->icon }}" style="color: {{ $category->show ? '#ffffff' : '#d3d3d3' }}"></i>
    </div>
    <a href="{{ route('categories.show', ['category' => $category->id]) }}" class="category-list-link {{ $category->show ? '' : 'inactive' }}">
        {{ $category->name }}
    </a>
</div>