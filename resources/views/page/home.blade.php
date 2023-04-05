<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.rtl.min.css" integrity="sha384-T5m5WERuXcjgzF8DAb7tRkByEZQGcpraRTinjpywg37AO96WoYN9+hrhDVoM6CaT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <style>
        .article-thumbnail-wrapper , .article-thumbnail-slider .carousel-item{
            height: 250px !important;
        }
        .article-thumbnail-wrapper img{
            height: 100%;
            max-height: 100%;
        }
        .card-footer ul:first-child{
            float: right;
            position: relative;
            top: 8px;
        }
        .card-footer ul:first-child li {
            display: inline-block;
            margin-left: 15px ;
        }
        .card-footer .read-more{
            float: left;
            position: relative;
            top: 5px;
        }
    </style>
</head>
<body>
<h1>تعداد کل مقالات : {{ $articles->total() }}</h1>
@unless($articles->isEmpty())
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($articles->items() as $articleKey=>$article)
            @php
                /** @var \Illuminate\Database\Eloquent\Collection $thumbnails*/
                $thumbnails = $article->thumbnails;
                $thumbnailsCount = $thumbnails->count();
                $author = $article->author;
                /** @var \Illuminate\Database\Eloquent\Collection $avatars*/
                $avatars = $article->author->avatars;
                $avatarsCount = $avatars->count();
            @endphp
            <div class="col">
                <div class="card">
                    <section class="article-thumbnail-wrapper">
                        @if($thumbnailsCount>1)
                            <div id="carouselExampleIndicators" class="carousel slide article-thumbnail-slider">
                                <div class="carousel-indicators">
                                    @for($counter = 0 ; $counter<$thumbnailsCount;$counter++)
                                        @php
                                            $isfirstSlide  = $counter==0 ;
                                        @endphp
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                                data-bs-slide-to="{{$counter}}" {!! (($isfirstSlide) ? 'class="active"' : '') !!}
                                                aria-current="true" aria-label="Slide {{$counter+1}}"></button>
                                    @endfor
                                </div>
                                <div class="carousel-inner">
                                    @foreach($thumbnails as $key => $thumbnail)
                                        <div class="carousel-item {{($key==0) ? 'active' : ''}}">
                                            <img src="{{asset($thumbnail->img)}}" class="d-block w-100" alt="...">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @elseif($thumbnailsCount==1)
                            @php
                                $thumbnail = $thumbnails->first()->img;
                            @endphp
                            <img src="{{asset($thumbnail)}}" class="card-img-top" alt="...">
                        @else
                            <img src="{{asset('img/No_Image_Available.jpg')}}" class="card-img-top" alt="...">
                        @endif
                    </section>
                    <div class="card-body">
                        <h5 class="card-title">{{$article->title}}</h5>
                        <p class="card-text">{{$article->description}}</p>
                    </div>
                    <div class="card-footer">
                        <ul>
                            <li>
                                @if($avatarsCount>=2)
                                    @php
                                        $modalId = "avatar-modal-".$articleKey;
                                        $avatarSliderId = "avatar-slider-".$articleKey;
                                    @endphp

                                    <img src="{{asset($avatars->first()->avatar)}}" alt=""
                                         class="rounded-circle me-2" width="32" height="32"  data-bs-toggle="modal"
                                         data-bs-target="#{{$modalId}}" >
                                    <!-- Modal -->
                                    <div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{$author->name}} avatars</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="{{$avatarSliderId}}" class="carousel slide">
                                                        <div class="carousel-indicators">
                                                            @for($counter = 0 ; $counter<$avatarsCount;$counter++)
                                                                @php
                                                                    $isfirstSlide = $counter==0;
                                                                @endphp
                                                                <button type="button" data-bs-target="#{{$avatarSliderId}}"
                                                                        data-bs-slide-to="{{$counter}}" {!! (($isfirstSlide) ? 'class="active"' : '')!!}
                                                                        aria-current="true" aria-label="Slide {{$counter+1}}">
                                                                </button>
                                                            @endfor
                                                        </div>
                                                        <div class="carousel-inner">
                                                            @foreach($avatars as $avatarKey=>$avatar)
                                                                <div class="carousel-item {{(($avatarKey==0) ? 'active':'')}}">
                                                                    <img src="{{asset($avatar->avatar)}}" class="d-block w-100" >
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#{{$avatarSliderId}}" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#{{$avatarSliderId}}" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @elseif($avatarsCount==1)
                                    <img src="{{asset($avatars->first()->avatar)}}" alt="" class="rounded-circle me-2" width="32" height="32">
                                @else
                                    <img src="{{asset('img/default-avatar.png')}}" alt="" class="rounded-circle me-2" width="32" height="32">
                                @endif
                                <a href="">
                                    {{$author->name}}
                                </a>
                            </li>
                            <li>
                                <i class="bi bi-calendar-event"></i>
                                {{$article->created_at}}
                            </li>
                            <li>
                                <i class="bi bi-chat-square"></i>
                                {{$article->comments_count_id}}
                            </li>
                        </ul>
                        <a href="{{route('single-article',$article->slug)}}" type="button" class="btn btn-outline-success read-more" href="">بیشتر بخوانید</a>

                    </div>
                </div>
            </div>

        @endforeach

    </div>
{{$articles->links('pagination::bootstrap-5')}}
@else
    <h1> No Article Found </h1>
@endunless
</body>
</html>
