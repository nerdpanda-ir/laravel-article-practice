@php
    /** @var \Illuminate\Database\Eloquent\Collection $thumbnails*/
    $thumbnails = $article->thumbnails;
    $thumbnailsCount = $thumbnails->count();
    /** @var \Illuminate\Database\Eloquent\Collection $authorAvatars*/
    $authorAvatars =  $article->author->avatars;
    $authorAvatarsCount =  $authorAvatars->count();

@endphp
<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$article->title}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.rtl.min.css" integrity="sha384-T5m5WERuXcjgzF8DAb7tRkByEZQGcpraRTinjpywg37AO96WoYN9+hrhDVoM6CaT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <style>
        #thumbnail_carousel {
            height: 300px;
        }
        #thumbnail_carousel img{
            width: 100%;
            height: 100%;
            max-height: 100%;
        }
        #thumbnail_carousel .carousel-inner {
            height: inherit;
        }
        #thumbnail_carousel .carousel-item{
            height: inherit;
        }
        .author-avatar{
            margin: 0 12px 0 4px;
        }
        .blog-post-meta li{
            display: inline-block;
        }
        .comment{
            margin-bottom: 42px;
        }
        .comment:first-child{
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div id="thumbnail_carousel" class="carousel slide" data-bs-ride="carousel">
    @if($thumbnailsCount>=2)
        <div class="carousel-indicators">
            @for($counter = 0 ; $counter<$thumbnails->count();$counter++)
                @php
                    $isFirst = $counter == 0 ;
                @endphp
                <button type="button" data-bs-target="#thumbnail_carousel"
                        data-bs-slide-to="{{$counter}}"
                        class="{{(($isFirst) ? "active" : '')}}"
                        aria-label="Slide {{$counter}}"
                        aria-current="true"></button>
            @endfor
        </div>
        <div class="carousel-inner">
            @foreach($thumbnails as $key=>$thumbnail)
                <div class="carousel-item {{(($loop->first) ? 'active' : '')}}">
                    <img src="{{asset($thumbnail->img)}}" class="d-block w-100" alt="...">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#thumbnail_carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">السابق</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#thumbnail_carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">التالي</span>
        </button>
    @elseif($thumbnailsCount==1)
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset($thumbnails->first()->img)}}" class="d-block w-100" alt="...">
            </div>
        </div>
    @else
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('img/default-single-article.jpg')}}" class="d-block w-100" alt="...">
            </div>
        </div>
    @endif
</div>
<article class="blog-post">
    <h2 class="blog-post-title mb-1">{{$article->title}}</h2>
    <ul class="blog-post-meta" style="display: inline-block">
        <li style="margin-left: 12px">
            <i class="bi bi-chat-square"></i>
            {{$article->comments_count_id}}
        </li>
        <li>
            نوشته شده در
            {{$article->created_at}}
        </li>
        <li>
            توسط
            @if($authorAvatarsCount==0)
                <img src="{{asset('img/default-avatar.png')}}" width="32" height="32" class="avatar author-avatar"/>
            @elseif($authorAvatarsCount==1)
                <img src="{{asset($authorAvatars->first()->avatar)}}" width="32" height="32" class="avatar author-avatar"/>
            @else
                <section style="display: inline-block">
                    <img src="{{asset($authorAvatars->first()->avatar)}}" alt=""
                         class="author-avatar rounded-circle me-2 avatar"
                         data-bs-toggle="modal" data-bs-target="#author-avatar-modal"
                         width="32" height="32">
                    <!-- Modal -->
                    <div class="modal fade" id="author-avatar-modal" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"> {{$article->author->name}} Avatars</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="author-avatar-slider" class="carousel slide">
                                        <div class="carousel-indicators">
                                            <button type="button" data-bs-target="#author-avatar-slider"
                                                    data-bs-slide-to="0" class="active" aria-current="true"
                                                    aria-label="Slide 1">
                                            </button>
                                            <button type="button" data-bs-target="#author-avatar-slider" data-bs-slide-to="1"
                                                    aria-current="true" aria-label="Slide 2">
                                            </button>
                                        </div>
                                        <div class="carousel-inner">
                                            @foreach($authorAvatars as $authorAvatar)
                                                <div class="carousel-item {{(($loop->first) ? 'active' : '')}}">
                                                    <img src="{{asset($authorAvatar->avatar)}}" class="d-block w-100">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#author-avatar-slider" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#author-avatar-slider" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            <a href="#"> {{$article->author->name}} </a>
        </li>

    </ul>

    <section>
        {{$article->description}}
    </section>
    <hr>
    <section>
        {{$article->body}}
    </section>
    </article>
    <section>
        @unless($comments->isEmpty())
            @foreach($comments as $comment)
                @php
                    $commentAuthor = $comment->author;
                    /** @var \Illuminate\Database\Eloquent\Collection $commentAuthorAvatars*/
                    $commentAuthorAvatars = $comment->author->avatars;
                    $commentAuthorAvatarsCount = $commentAuthorAvatars->count();
                @endphp
                <div class="card comment">
                    <div class="card-header">
                        @if($commentAuthorAvatarsCount>1)
                            @php
                                $modalId= "comment-avatar-modal-{$loop->index}";
                                $sliderId= "comment-avatar-slider-{$loop->index}";
                            @endphp
                            <img src="{{asset($commentAuthorAvatars->first()->avatar)}}" alt=""
                                 class="comment-avatar rounded-circle me-2 avatar" width="42" height="42"
                                 data-bs-toggle="modal" data-bs-target="#{{$modalId}}">
                            <!-- Modal -->
                            <div class="modal fade" id="{{$modalId}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$commentAuthor->name}} avatars</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="{{$sliderId}}" class="carousel slide">
                                                <div class="carousel-inner">
                                                    @foreach($commentAuthorAvatars as $avatar)
                                                        <div class="carousel-item {{(($loop->first) ? 'active':'')}}">
                                                            <img src="{{asset($avatar->avatar)}}" class="d-block w-100" alt="...">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#{{$sliderId}}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#{{$sliderId}}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @elseif($commentAuthorAvatarsCount==1)
                            <img src="{{asset($commentAuthorAvatars->first()->avatar)}}" alt=""
                                 class="comment-avatar rounded-circle me-2 avatar" width="42" height="42">
                        @else
                            <img src="{{asset('img/default-avatar.png')}}" alt=""
                                 class="comment-avatar rounded-circle me-2 avatar" width="42" height="42">
                        @endif
                        {{$comment->author->name}}
                    </div>
                    <div class="card-body">
                        {{$comment->body}}
                    </div>
                </div>
            @endforeach
            {{$comments->links('pagination::bootstrap-5')}}
        @else
            <h1>این مقاله هیچ کامنتی برای نمایش ندارد شما اولین نفری باشید که کامنتی برای این مقاله مینویسد</h1>
        @endunless
    </section>
</body>
</html>
