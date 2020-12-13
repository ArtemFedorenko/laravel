<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Article extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'user_id',
        'status_id'
    ];

    public function status()
    {
        return $this->hasOne('App\Models\ArticleStatuses.php');
    }

}
