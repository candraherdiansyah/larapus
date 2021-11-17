<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class Author extends Model
{
    use HasFactory;

    // memberikan akses data apa saja yang bisa dilihat
    protected $visible = ['name'];
    // memberikan akses data apa saja yang bisa di isi
    protected $fillable = ['name'];
    // mencatat waktu pembuatan dan update data otomatis
    public $timestamps = true;

    // membuat relasi one to many
    public function books()
    {
        // data model "Author" bisa memiliki banyak data
        // dari model "Book" melalui fk "author_id"
        return $this->hasMany('App\Models\Book', 'author_id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($author) {
            // mengecek apakah penulis masih punya buku
            if ($author->books->count() > 0) {
                // menyiapkan pesan error
                $html = 'Penulis tidak bisa dihapus karena masih memiliki buku : ';
                $html .= '<ul>';
                foreach ($author->books as $book) {
                    $html .= "<li>$book->title</li>";
                }
                $html .= '</ul>';
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => $html,
                ]);
                // membatalkan proses penghapusan
                return false;
            }
        });
    }
}
