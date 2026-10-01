<?php

namespace App\DataTables;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BooksDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Book> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('authors', function ($book) {
                return $book->authors
                    ->map(fn($author) => '<span class="badge bg-primary me-1">' . e($author->name) . '</span>')
                    ->implode('');
            })
            ->filterColumn('authors', function ($query, $keyword) {
                $query->whereHas('authors', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->addColumn('action', 'book.action')
            ->editColumn('created_at', function ($query) {
                return format_datetime($query->created_at);
            })
            ->editColumn('updated_at', function ($query) {
                return format_datetime($query->updated_at);
            })
            ->rawColumns(['action', 'authors'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Book>
     */
    public function query(Book $model): QueryBuilder
    {
        return $model
            ->newQuery()
            ->with(['category', 'authors']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('books-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->buttons([
                Button::make('colvis')
                    ->text('Kolom')
                    ->addClass('btn btn-outline-secondary btn-sm text-white')
                    ->columns(':not(.no-colvis)'),
                Button::make('excel')
                    ->text('Excel')
                    ->addClass('btn btn-success btn-sm'),
                Button::make('csv')
                    ->text('CSV')
                    ->addClass('btn btn-secondary btn-sm'),
                Button::make('pdf')
                    ->text('PDF')
                    ->addClass('btn btn-danger btn-sm'),
            ])
            ->parameters([
                'layout' => [
                    'topStart'    => ['pageLength', 'buttons'],
                    'topEnd'      => 'search',
                    'bottomStart' => 'info',
                    'bottomEnd'   => 'paging',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center no-colvis'),
            Column::make('title')
                ->title('Judul'),
            Column::make('authors')
                ->title('Penulis')
                ->searchable(true),
            Column::make('publication_year')
                ->title('Tahun'),
            Column::make('category.name')
                ->title('Kategori'),
            Column::make('description')
                ->title('Deskripsi')
                ->addClass('text-wrap')
                ->exportable(false)
                ->printable(false)
                ->visible(false),
            Column::make('created_at')
                ->title('Dibuat')
                ->visible(false),
            Column::make('updated_at')
                ->title('Diubah'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center no-colvis'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Books_' . date('YmdHis');
    }

    public function pdf(): BinaryFileResponse
    {
        $data = $this->getDataForPrint();

        $path = tempnam(sys_get_temp_dir(), 'books_pdf_');

        Pdf::loadView('book.pdf', compact('data'))
            ->setPaper('a4', 'landscape')
            ->save($path);

        return response()
            ->download($path, $this->getFilename() . '.pdf')
            ->deleteFileAfterSend(true);
    }
}
