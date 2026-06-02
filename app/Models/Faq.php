<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'faqs';

    public $translatable = ['answer', 'question'];

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
