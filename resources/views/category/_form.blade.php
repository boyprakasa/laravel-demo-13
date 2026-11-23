{{-- <div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}"
        class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> --}}

<div class="mb-3">
    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        value="{{ old('name', $category->name ?? '') }}" placeholder="Contoh: Fiksi, Sains, Sejarah" required />
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
        rows="3" placeholder="Keterangan singkat kategori (opsional)">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
