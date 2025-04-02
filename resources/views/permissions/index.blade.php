@extends('layouts.app')
@section("content")



<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card-header">
                    <h4>Permissions</h4>
                </div>
                <div class="card-body">
                    <table class="table table-boarded table-striped">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
