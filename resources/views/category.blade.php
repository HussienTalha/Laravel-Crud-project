<x-app-layout>
 <!-- Page Header -->

<header class="py-5 bg-light border-bottom mb-4" style="background-image: url('{{ asset('img/home-bg.jpg')}}'); background-size: cover; background-position:center">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">{{$category->category_name}} Category</h1>
                </div>
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
                            <div class="small text-muted">{{$featured_post->created_at->format('d/m/y - H:i')}}
                            <p>Post By: <a href="{{ uri("/users/{$featured_post->user_id}") }}">{{$featured_post->user->name}}</a></p>
 
                            </div>
                                    <h2 class="card-title h4 ">{{ Str::limit($featured_post->title,50) }}</h2>
                           <p class="card-text">{{Str::limit($featured_post->post)}}</p>
                            <a class="btn btn-primary" href="{{ uri("/posts/{$featured_post->id}") }}">Read more →</a>
                        </div>
                    </div>
                    @else
                    <div>
                       <h2> There's No Posts Yet In This Category!</h2>
                 <div class="text-center my-5">
                        @auth
                        <p>Be The First One To Post</p>
                        
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newItemModal">
                            <i class="fas fa-plus me-2">Create Post</i>
                        </button>
                @endauth
                </div>
            </div>
                    @endif

                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        @foreach($posts as $index => $post)
                        @if($index>0)
                        <div class="col-lg-6">
                            <!-- Blog post-->
                            <div class="card mb-4" style="height: 450px; display: flex; flex-direction: column;">
                                <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                                <div class="card-body d-flex flex-column" style="flex: 1;">
                                    <div class="small text-muted"><p>{{ $post->created_at->format('d/m/y - H:i') }} <br>
                                     Post By: <a href="{{ uri("/users/{$post->user_id}") }}">{{$post->user->name}}</a></p>
                                   </div>
                                    <h2 class="card-title h4">{{ Str::limit($post->title,50) }}</h2>
                                    <p class="card-text flex-grow-1 " >
                            
                            {{ Str::limit($post->post,50)}}</p>
                                    <a class="btn btn-primary align-self-start mt-3" href="{{uri("posts/{ $post->id }")}}">Read more →</a>
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
                  
                </div>
            </div>
        </div>

    <!-- Create Post Modal -->
<div>
 <div class="modal fade" id="newItemModal" tabindex="-1" aria-labelledby="newItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newItemModalLabel">Create Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/posts" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="Title" class="form-label" >Title</label>
                            <input type="text" class="form-control" id="Title"  name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="Content" class="form-label">Content</label>
                            <textarea class="form-control" id="Content" rows="3" name="post" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="Category" class="form-label">Category</label>
                            <select class="form-select" id="Category"  name="category_id" required>
                                <option value="{{ $category->id}}"> {{ $category->category_name }}</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>