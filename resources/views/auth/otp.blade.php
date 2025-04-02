@extends("layouts.authlayout")
@section('title', 'OTP Verification')

@section('content')
<main class="mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                <div class="card">
                    <h3 class="card-header text-center">Enter OTP</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('verify.otp') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email ?? '' }}">
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Enter OTP" id="otp" class="form-control" name="otp" required autofocus>
                                @if ($errors->has('otp'))
                                    <span class="text-danger">{{ $errors->first('otp') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Verify OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
