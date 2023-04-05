<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ShowSingleArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
      public function __invoke(Article $article , Comment $comment , string $slug)
      {
          $query  = $article->where('slug','=',$slug);
          $article = $query->first([
              'id','title','description','body','user_id','created_at'
          ]) ;
          if (is_null($article))
              abort(404);
          $article
              ->loadAggregate('comments','id','count')
              ->load([
                'thumbnails:img,article_id' , 'author:id,name' ,
                 'author.avatars:user_id,avatar' ,
                ]);
          $comments = $comment->where('article_id','=',$article->id)
                              ->with(['author:id,name' , 'author.avatars:avatar,user_id'])
                              ->paginate(8,['body' , 'user_id' , 'created_at']);
          return \view('page.single-article',compact('article','comments'));
      }
}
