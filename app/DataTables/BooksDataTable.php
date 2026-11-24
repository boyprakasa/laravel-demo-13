<?php

namespace App\DataTables;

use App\Models\Author;
use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable untuk menampilkan daftar buku.
 * Mengelola pengambilan data, definisi kolom, filtering, sorting, dan kolom aksi.
 */
class BooksDataTable extends DataTable
{
    /**
     * Bangun DataTable dengan kolom, filter, dan format.
     *
     * @param  QueryBuilder<Book>  $query  Hasil dari query() berisi catatan buku dengan relationship yang dimuat.
     * @return EloquentDataTable Instance DataTable yang sudah dikonfigurasi dengan semua kolom dan aksi.
     *
     * Mengonfigurasi:
     * - Kolom index berurutan
     * - Kolom penulis dengan badge
     * - Kolom aksi dengan tombol view/edit/delete
     * - Format tanggal created_at dan updated_at
     * - Raw column untuk rendering HTML (authors, action)
     * - Row ID untuk integrasi DataTables JavaScript
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            /** Menambahkan kolom index berurutan */
            ->addIndexColumn()

            /** Menambahkan kolom penulis dengan badge */
            ->addColumn('authors', function ($book) {
                return $book->authors
                    ->map(fn ($author) => '<span class="badge bg-primary me-1">'.e($author->name).'</span>')
                    ->implode('');
            })
            ->filterColumn('authors', function ($query, $keyword) {
                $query->whereHas('authors', fn ($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->orderColumn('authors', function ($query, $order) {
                $query->orderBy(
                    Author::select('authors.name')
                        ->join('author_book', 'authors.id', '=', 'author_book.author_id')
                        ->whereColumn('author_book.book_id', 'books.id')
                        ->orderBy('authors.name')
                        ->limit(1),
                    $order
                );
            })

            /** Menambahkan kolom aksi dengan tombol view/edit/delete */
            ->addColumn('action', 'book.action')

            /** Format tanggal created_at menggunakan helper format_datetime Laravel */
            ->editColumn('created_at', function ($query) {
                return format_datetime($query->created_at);
            })

            /** Format tanggal updated_at menggunakan helper format_datetime Laravel */
            ->editColumn('updated_at', function ($query) {
                return format_datetime($query->updated_at);
            })

            /** Menandai kolom sebagai raw untuk rendering HTML */
            ->rawColumns(['action', 'authors'])

            /** Menetapkan HTML row ID untuk integrasi DataTables jQuery */
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
                    'topStart' => ['pageLength', 'buttons'],
                    'topEnd' => 'search',
                    'bottomStart' => 'info',
                    'bottomEnd' => 'paging',
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
        return 'Books_'.date('YmdHis');
    }

    public function pdf(): BinaryFileResponse
    {
        $data = $this->getDataForPrint();

        $path = tempnam(sys_get_temp_dir(), 'books_pdf_');

        Pdf::loadView('book.pdf', compact('data'))
            ->setPaper('a4', 'landscape')
            ->save($path);

        return response()
            ->download($path, $this->getFilename().'.pdf')
            ->deleteFileAfterSend(true);
    }
}
