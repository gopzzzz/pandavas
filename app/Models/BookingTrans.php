<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTrans extends Model
{
    use HasFactory;

    protected $table = 'bookingtrans';

    protected $fillable = [
        'bookid',
        'customername',
        'age',
        'phonenumber',
        'adharcardnumber',
        'adharcardpf',
        'seatnumber',
    ];

    public function booking()
    {
        return $this->belongsTo(
            BookingMaster::class,
            'bookid'
        );
    }
}