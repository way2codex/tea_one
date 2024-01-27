@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Customer') }}</div>

                    <div class="card-body">
                        <form action="{{ route('customers.update', $customer->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
