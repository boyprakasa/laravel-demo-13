<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

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

    public function calculateFine(): float
    {
        if ($this->status === 'returned' && !$this->actual_return_date) {
            return 0.0;
        }

        $checkDate = $this->actual_return_date ?: now()->toDateString();
        $expectedDate = Carbon::parse($this->expected_return_date);
        $actualDate = Carbon::parse($checkDate);

        if ($actualDate->lessThanOrEqualTo($expectedDate)) {
            return 0.0;
        }

        $daysDifference = $actualDate->diffInDays($expectedDate, false);
        return max(0, $daysDifference) * 1000; // Denda Rp1.000 per hari
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
