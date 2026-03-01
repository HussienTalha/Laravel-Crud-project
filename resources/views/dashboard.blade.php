<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name ?? 'User' }}!</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newItemModal">
                            <i class="fas fa-plus me-2"></i>New Item
                        </button>
                    </div>
                </div>
            </div>
        </div>

    
    
    <!-- Content Row -->
    
    <div class="row">
    <!-- Admins -->

    <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3" >
                        <h4 class="m-0 font-weight-bold text-primary">Admins</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><h6>Admins</h6></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->role =='admin')

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas  text-white"></i>
                                                </div>
                                                <a href="">{{$user->name}}</a>
                                            </div>
                                        </td>
                                        <td>
                                            @if(!(auth()->user()->id == $user->id) )
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAdmin{{ $user->id }}Modal">
                                                <i class="fas fa-plus me-2">Delete Admin</i>
                                            </button> 
                                         @endif
                                         </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    

    <!-- Users -->
        
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3" style="display: flex; justify-content: space-between; padding: 10px 30px">
                        <h4 class="m-0 font-weight-bold text-primary">Users</h4>
                         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                                <i class="fas fa-plus me-2">New User</i>
                          </button> 
                    </div>
                    <div class="card-body">
                    <div style="max-height: 320px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><h6>Users</h6></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas  text-white"></i>
                                                </div>
                                                <a href="{{ uri("/users/{$user->id}") }}">{{$user->name}}</a>
                                            </div>
                                        </td>
                                        <td>
                                        @if($user->role == 'user')
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#make{{ $user->id }}AdminModal">
                                                <i class="fas fa-plus me-2">Make Admin</i>
                                            </button> 
                                        @else
                                        <div style="padding-left: 30px; padding-top:10px;">
                                        <h6 > Admin </h6>
                                         </div>
                                            @endif
                                        
                                         </td>
                                        @if($user->role ='user')
                                        <td>
                                             <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser{{ $user->id }}Modal">
                                                <i class="fas fa-plus me-2">Delete User</i>
                                             </button>
                                         </td>
                                         @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <p>No Categories Yet!</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
       

        <!-- Content Row -->
        <div class="row">
            <!-- Categories -->
        
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3" style="display: flex; justify-content: space-between; padding: 10px 30px">
                        <h4 class="m-0 font-weight-bold text-primary">Categories</h4>
                         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                                <i class="fas fa-plus me-2">New Category</i>
                          </button> 
                    </div>
                    <div class="card-body">
                    <div style="max-height: 320px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><h6>Category</h6></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas  text-white"></i>
                                                </div>
                                                <a href="{{ uri("/categories/{$category->id}") }}">{{$category->category_name}}</a>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $category->id }}Modal">
                                                 <i class="fas fa-plus me-2" style="text-align: center"> Edit </i>
                                            </button> 
                                         </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $category->id }}Modal">
                                                <i class="fas fa-plus me-2">Delete</i>
                                            </button> 
                                         </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <p>No Categories Yet!</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-primary text-white shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users fa-2x"></i>
                                            <div class="ms-3">
                                                <div class="text-white-50 small">Manage</div>
                                                <div class="text-white">Users</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-success text-white shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cog fa-2x"></i>
                                            <div class="ms-3">
                                                <div class="text-white-50 small">System</div>
                                                <div class="text-white">Settings</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-info text-white shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-chart-bar fa-2x"></i>
                                            <div class="ms-3">
                                                <div class="text-white-50 small">View</div>
                                                <div class="text-white">Reports</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-warning text-white shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope fa-2x"></i>
                                            <div class="ms-3">
                                                <div class="text-white-50 small">Send</div>
                                                <div class="text-white">Messages</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    >

<!-- Categories Modals -->

     <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ uri("/categories") }}">
                        @csrf
                        <div class="mb-3">
                            <label for="itemName" class="form-label"> Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="category_name" required>
            
                        </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($categories as $category )
    
    <!-- Edit Category Modal -->
    <div class="modal fade" id="edit{{ $category->id }}Modal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit {{ $category->category_name }} Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ uri("/categories/{$category->id}/edit") }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="itemName" class="form-label"> Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="category_name" required>
            
                        </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Delete Category Modal -->
    <div class="modal fade" id="delete{{ $category->id }}Modal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Delete {{ $category->category_name }} Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <form method="POST" action="{{ uri("/categories/{$category->id}/delete") }}">
                        @csrf
                        @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <!-- Users Modals -->
  <!-- Add Category Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/addUser" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="Title" class="form-label" >Username</label>
                            <input type="text" class="form-control" id="Title"  name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="Email" rows="3" name="email" required>
                        </div>
                        <div class="mb-3">
                          <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    Use 8 or more characters with a mix of letters, numbers & symbols.
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                          <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                           name="password_confirmation" required autocomplete="new-password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                     @enderror
                        </div>
                        <label for="role" class="form-label">User Role</label>
                        <select class="form-select" name="role" id="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
            
                        </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @foreach ($users as $user )
    
    
    
    <!-- Delete User -->
<div class="modal fade" id="deleteUser{{$user->id}}Modal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User {{ $user->name }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <form method="POST" action="{{ uri("/admin/{$user->id}/deleteUser") }}">
                        @csrf
                        @method('DELETE')
            
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--Admins Modals -->

    <!--  Delete Admin  -->
<div class="modal fade" id="deleteAdmin{{$user->id}}Modal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin {{ $user->name }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <form method="POST" action="{{ uri("/admin/{$user->id}/deleteAdmin") }}">
                        @csrf
                        @method('DELETE')
            
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Make Admin -->
      <div class="modal fade" id="make{{$user->id}}AdminModal" tabindex="-1" aria-labelledby="makeAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="makeAdminModalLabel">Make {{ $user->name }} Admin </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <form method="POST" action="{{ uri("/admin/{$user->id}/makeAdmin") }}">
                        @csrf
                        @method('PUT')
            
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Make Admin</button>
                    </form>
                </div>
            </div>
        </div>
     </div>
    <!-- -->
    @endforeach


    @push('styles')
    <style>
        .border-left-primary {
            border-left: .25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: .25rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: .25rem solid #36b9cc !important;
        }
        .border-left-warning {
            border-left: .25rem solid #f6c23e !important;
        }
        .avatar-sm {
            width: 2.5rem;
            height: 2.5rem;
        }
        .text-gray-300 {
            color: #dddfeb !important;
        }
        .text-gray-800 {
            color: #5a5c69 !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Chart.js integration would go here
        // Example placeholder for actual chart implementation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard loaded - charts would be initialized here');
        });
    </script>
    @endpush
</x-app-layout>

