<div class="mb-3">
    <label for="member_id" class="form-label">Anggota</label>
    <select id="member_id" name="member_id" class="form-select @error('member_id') is-invalid @enderror">
        <option value="">Pilih Anggota</option>
        @foreach ($members as $item)
            <option value="{{ $item->id }}"
                {{ old('member_id', isset($loan) ? $loan->member_id : '') === $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    @error('member_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="book_id" class="form-label">Buku</label>
    <select id="book_id" name="book_id" class="form-select @error('book_id') is-invalid @enderror">
        <option value="">Pilih Buku</option>
        @foreach ($books as $item)
            <option value="{{ $item->id }}"
                {{ old('book_id', isset($loan) ? $loan->book_id : '') === $item->id ? 'selected' : '' }}>
                {{ $item->title }}
            </option>
        @endforeach
    </select>
    @error('book_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="loan_date" class="form-label">Tanggal Pinjam</label>
    {{ $loan->loan_date }}
    <input type="date" id="loan_date" name="loan_date"
        value="{{ old('loan_date', isset($loan) ? $loan->loan_date->format('Y-m-d') : '') }}"
        class="form-control @error('loan_date') is-invalid @enderror">
    @error('loan_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="expected_return_date" class="form-label">Tanggal Pengembalian yang Diperkirakan</label>
    <input type="date" id="expected_return_date" name="expected_return_date"
        value="{{ old('expected_return_date', isset($loan) ? $loan->expected_return_date->format('Y-m-d') : '') }}"
        class="form-control @error('expected_return_date') is-invalid @enderror">
    @error('expected_return_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="actual_return_date" class="form-label">Tanggal Pengembalian Sejati</label>
    <input type="date" id="actual_return_date" name="actual_return_date"
        value="{{ old('actual_return_date', isset($loan) ? $loan->actual_return_date->format('Y-m-d') : '') }}"
        class="form-control @error('actual_return_date') is-invalid @enderror">
    @error('actual_return_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="on_loan" {{ old('status', isset($loan) ? $loan->status : '') === 'on_loan' ? 'selected' : '' }}>
            Sedang Dipinjam</option>
        <option value="returned"
            {{ old('status', isset($loan) ? $loan->status : '') === 'returned' ? 'selected' : '' }}>Dikembalikan
        </option>
        <option value="overdue" {{ old('status', isset($loan) ? $loan->status : '') === 'overdue' ? 'selected' : '' }}>
            Terlambat</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="fine" class="form-label">Denda (Rp)</label>
    <input type="number" id="fine" name="fine" value="{{ old('fine', isset($loan) ? $loan->fine : '') }}"
        class="form-control @error('fine') is-invalid @enderror" min="0" step="1000">
    @error('fine')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
