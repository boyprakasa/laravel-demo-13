<div class="mb-3">
    <label for="title" class="form-label">Judul</label>
    <input type="text" id="title" name="title" value="{{ old('title', $book->title ?? '') }}"
        class="form-control @error('title') is-invalid @enderror">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Penulis</label>
    <div>
        @foreach ($authors as $author)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="author_ids[]" value="{{ $author->id }}"
                    {{ in_array($author->id, old('author_ids', isset($book) ? $book->authors->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                <label class="form-check-label">{{ $author->name }}</label>
            </div>
        @endforeach
    </div>
    @error('author_ids')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="publication_year" class="form-label">Tahun Terbit</label>
    <input type="number" id="publication_year" name="publication_year"
        value="{{ old('publication_year', $book->publication_year ?? '') }}"
        class="form-control @error('publication_year') is-invalid @enderror">
    @error('publication_year')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Kategori</label>
    <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea id="description" name="description" rows="4"
        class="form-control @error('description') is-invalid @enderror">{{ old('description', $book->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
