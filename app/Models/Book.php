<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $visible = ['title', 'author_id', 'amount', 'cover'];
    protected $fillable = ['title', 'author_id', 'amount', 'cover'];
    public $timestamps = true;

    public function author()
    {
        // data dari Model "Book" bisa di miliki oleh model "Author"
        // melalui fk "author_id"
        return $this->belongsTo('App\Models\Author', 'author_id');
    }

    public function image()
    {
        // jika ada data dari cover dan juga file yang di folder public images books itu ada
        // yang sesuai dengan namanya
        // maka kita akan memangiil file nya di dalam image book nama foto
        if ($this->cover && file_exists(public_path('images/books/' . $this->cover))) {
            return asset('images/books/' . $this->cover);
        } else {
            return asset('images/no_image.jpg');
        }
    }

    public function deleteImage()
    {
        if ($this->cover && file_exists(public_path('images/books/' . $this->cover))) {
            return unlink(public_path('images/books/' . $this->cover));
        }

    }

}
