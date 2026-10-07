<div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input type="text" id="name" name="name" value="{{ old('name', $member->name ?? '') }}"
        class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $member->email ?? '') }}"
        class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="phone_number" class="form-label">Nomor Telepon</label>
    <input type="text" id="phone_number" name="phone_number"
        value="{{ old('phone_number', $member->phone_number ?? '') }}"
        class="form-control @error('phone_number') is-invalid @enderror">
    @error('phone_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="address" class="form-label">Alamat</label>
    <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $member->address ?? '') }}</textarea>
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
