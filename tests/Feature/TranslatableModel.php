<?php

namespace Diviky\LaravelFormComponents\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TranslatableModel extends Model
{
    use HasTranslations;

    public $translatable = ['input', 'output'];
}
