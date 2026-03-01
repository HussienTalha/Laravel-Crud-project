<x-app-layout>
    <!-- Page Header -->
    <header class="py-5 bg-light border-bottom mb-4" style="background-image: url('{{ asset('img/home-bg.jpg')}}'); background-size: cover; background-position:center">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">{{$user->name}} </h1>
            </div>
        </div>>
    </header>
        
    <!-- Page content-->
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Featured blog post-->
                @php
                $featured_post = $posts->first();
                @endphp
                
                @if($featured_post)
                <div class="card mb-4">
                    <a href="#!"><img class="card-img-top" src="https://dummyimage.com/850x350/dee2e6/6c757d.jpg" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted">{{$featured_post->created_at}}</div>
                        <h2 class="card-title h4 ">{{ Str::limit($featured_post->title,50) }}</h2>
                       <p class="card-text">{{Str::limit($featured_post->post)}}</p>
                        <a class="btn btn-primary" href="{{ uri("/posts/{$featured_post->id}") }}">Read more →</a>
                    </div>
                </div>
                @else
                <div>
                    <h2>{{$user->name}} Hasn't Posted Yet</h2>
                </div>
                @endif     

                    
                 <div class="row">
                
                
                    @foreach($posts as $index => $post)
                        @if($index > 0)
                        <div class="col-lg-6">
                            <!-- Blog post-->
                            <div class="card mb-4" style="height: 450px; display: flex; flex-direction: column;">
                                <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                                <div class="card-body d-flex flex-column" style="flex: 1;">
                                    <div class="small text-muted">
                                        <p>{{ $post->created_at }} <br>Created By : {{ $post->user->name }}</p>
                                    </div>
                                    <h2 class="card-title h4 ">{{ Str::limit($post->title,50) }}</h2>
                                    <p class="card-text flex-grow-1">{{ Str::limit($post->post,50)}}</p>
                                    <a class="btn btn-primary align-self-start mt-3" href="{{ uri("posts/{$post->id}") }}">Read more →</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Pagination-->
              <nav aria-label="Pagination">
                    <hr class="my-0" />
                    @if($posts->hasPages())
                        <ul class="pagination justify-content-center my-4">
                            {{-- Previous --}}
                            <li class="page-item @if($posts->onFirstPage()) disabled @endif">
                                <a class="page-link" href="{{ $posts->previousPageUrl() }}">Newer</a>
                            </li>

                            {{-- Page Numbers --}}
                            @for($i = 1; $i<= $posts->lastPage(); $i++)
                                <li class="page-item @if($posts->currentPage() == $i) active @endif">
                                    <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next --}}
                            <li class="page-item @if(!$posts->hasMorePages()) disabled @endif">
                                <a class="page-link" href="{{ $posts->nextPageUrl() }}">Older</a>
                            </li>
                        </ul>
                    @endif
             </nav>
            </div>  
            
            <!-- Side widgets-->
            <div class="col-lg-4">
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($categories as $category)
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="{{ uri("/categories/{$category->id}") }}">{{ $category->category_name }}</a></li>
                                </ul>
                            </div>
                            @empty
                            <p>No Categories!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>  <!-- Close col-lg-4 -->
        </div> 
    </div>  
</x-app-layout>