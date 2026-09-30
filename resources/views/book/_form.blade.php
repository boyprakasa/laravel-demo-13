<div class="mb-3">
    <label for="title" class="form-label">Judul</label>
    <input type="text" id="title" name="title" value="{{ old('title', $book->title ?? '') }}"
        class="form-control @error('title') is-invalid @enderror">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="writer" class="form-label">Penulis</label>
    <input type="text" id="writer" name="writer" value="{{ old('writer', $book->writer ?? '') }}"
        class="form-control @error('writer') is-invalid @enderror">
    @error('writer')
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
