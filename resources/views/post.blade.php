<x-app-layout>

<div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{$post->title}}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2"><p>{{ $post->created_at->format('d/m/y - H:i')}}</p>
                            <a href="{{ uri("/users/{$post->user->id}") }}"><p>{{$post->user->name}}</p> </a>
                            </div>
                            <!-- Post categories-->
                            <a class="badge bg-secondary text-decoration-none link-light" href="{{ uri("/categories/{$post->category_id}")}}">{{$post->category->category_name}}</a>
                            <div style="padding-top:5px">
                            @auth
                            @if (auth()->user()->id == $post->user_id)

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPostModal">
                            <i class="fas fa-plus me-2">Edit Post</i>
                        </button>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                            <i class="fas fa-plus me-2">Delete Post</i>
                        </button>                         
                         @endif
                         @endauth
                    </div>
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="https://dummyimage.com/900x400/ced4da/6c757d.jpg" alt="..." /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4">{{$post->post}}</p>
                        </section>
                    </article>
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
<!-- Edit Post Modal-->
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalLabel">Delete Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{uri("/posts/{$post->id}/edit")}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="Title" class="form-label "" >Title</label>
                            <input type="text" class="form-control" id="Title"  name="title" value="{{ $post->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="Content" class="form-label">Content</label>
                            <textarea class="form-control" id="Content" rows="3" name="post"  required>{{$post->post}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="Category" class="form-label">Category</label>
                            <select class="form-select" id="Category"  name="category_id" required>
                                @foreach($categories as $category )
                                <option value="{{ $category->id}}"> {{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Edit Post</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
    <!-- Delete Post Modal -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
            <div class="modal-header border-bottom  border-secondary pb-3">
                    <h5 class="modal-title w-100 text-center" id="deleteModalLabel" style="text-align: center">Confirm Delete </h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    <form action="{{uri("/posts/{$post->id}/delete")}}" method="POST"  onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger " onlclick="alert('Are you sure you want to delete the post?')">Delete</button>
                    </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>