<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class PhoneBookAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'phone_book_addresses';

    protected $fillable = [
        'name',
        'phone_number',
        'user_id',
        'shared'
    ];

    protected $casts = [
        'shared' => 'boolean',
    ];
}