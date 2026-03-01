<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile update') }}</div>

                    <form method="POST" action="/profile">
                        
                        @csrf
                        @method('PATCH')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" name ="name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" name="email">
                        </div>
                        <div class="mb-3">
                          <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" autocomplete="new-password">
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
                                           name="password_confirmation" autocomplete="new-password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                     @enderror
                        </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
