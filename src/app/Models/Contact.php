<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'last_name','first_name','gender','email','tel',
        'address','building','category_id','content'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
