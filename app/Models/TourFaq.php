<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'question_en',
        'question_de',
        'answer_en',
        'answer_de',
        'sort_order',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
