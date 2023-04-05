<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,Article $article):View
    {
        $articles = $article->with(['author:id,name','author.avatars:user_id,avatar', 'thumbnails:img,article_id'])
                            ->addSelect([
                                'id', 'user_id' , 'title', 'description' , 'slug' , 'created_at'
                            ])
                            ->withAggregate('comments','id','count')
                            ->orderBy('created_at','desc')
                            ->orderBy('updated_at','desc')
                            ->paginate(6);
        return view('page.home',compact('articles'));
    }
}
