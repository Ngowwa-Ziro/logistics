@extends("layouts.authlayout")
@section("title", "Register")
@section("content")

    <main class="mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    @if (session()->has("success"))
                        <div class="alert alert-success">
                            {{ session()->get("success") }}
                        </div>
                    @endif
                    @if (session()->has("error"))
                        <div class="alert alert-danger">
                            {{ session()->get("error") }}
                        </div>
                    @endif
                    <div class="card">
                        <h3 class="card-header text-center">Register</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register.post') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Name" id="name" class="form-control" name="name" required autofocus>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" placeholder="Email" id="email" class="form-control" name="email" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Phone Number" id="phone" class="form-control" name="phone" required>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
