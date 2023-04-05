<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    public function thumbnails():HasMany {
        return $this->hasMany(ArticleThumbnail::class);
    }
    public function author():BelongsTo {
        return $this->belongsTo(User::class,'user_id');
    }
    public  function author_avatars():BelongsTo{
        return $this->author()->with('avatars');
    }
    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }
    public function commentsWithPaginate(int $page,int $perPage):HasMany{
        return $this->comments()->forPage($page,$perPage);
    }
}
