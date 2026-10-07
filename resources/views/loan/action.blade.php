<div class="d-flex justify-content-center gap-1">
    <a href="{{ route('loan.show', $model) }}" class="btn btn-sm btn-info">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('loan.edit', $model) }}" class="btn btn-sm btn-warning">
        <i class="bi bi-pencil-square"></i>
    </a>
    <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('loan.destroy', $model) }}"
        data-table="loans-table">
        <i class="bi bi-trash"></i>
    </button>
</div>
