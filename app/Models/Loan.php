<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    private const FINE_PER_DAY = 1000;

    protected $fillable = [
        'member_id',
        'book_id',
        'loan_date',
        'expected_return_date',
        'actual_return_date',
        'status',
        'fine',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'expected_return_date' => 'date',
        'actual_return_date' => 'date',
    ];

    // Relasi banyak-ke-satu dengan Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected function fine(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->calculateFine(),
            set: fn($value) => $this->calculateFine() // Selalu hitung ulang saat diset
        );
    }

    public function calculateFine(): float
    {
        if ($this->status === 'returned' && !$this->actual_return_date) {
            return 0.0;
        }

        $expectedDate = Carbon::parse($this->expected_return_date)->startOfDay();

        $actualDate   = $this->actual_return_date
            ? Carbon::parse($this->actual_return_date)->startOfDay()
            : Carbon::today();

        if ($actualDate->lessThanOrEqualTo($expectedDate)) {
            return 0.0;
        }

        // expected -> actual, sehingga hasilnya positif jika terlambat
        $lateDays = (int) $expectedDate->diffInDays($actualDate);

        return (float) ($lateDays * self::FINE_PER_DAY);
    }

    public function updateStatus(): void
    {
        if ($this->status === 'on_loan') {
            $todayDate = now()->toDateString();
            $expectedDate = Carbon::parse($this->expected_return_date);

            if (Carbon::parse($todayDate)->greaterThan($expectedDate)) {
                $this->status = 'overdue';
                $this->fine = $this->calculateFine();
                $this->save();
            }
        }
    }
}
