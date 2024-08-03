@extends('layout.master')

@section('content')
    <div class="card">
        @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session()->has('success'))
                    <div class="alert alert-info">{{ session('success') }}</div>
        @endif
        
        @auth
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="">Todos</h5>
            <a href="{{ route('todo.create') }}" class="btn btn-dark">create</a>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $todo)
                        <tr>
                            <td>
                                <img width="90" class="rounded" src="{{ asset('images/' . $todo->image) }}" alt="image">
                            </td>
                            <td>{{ $todo->title }}</td>
                            <td>{{ $todo->category->title }}</td>
                            <td>
                                <a href="{{ route('todo.show', ['todo' => $todo->id]) }}"
                                    class="btn btn-sm btn-secondary">Show</a>
                                @if ($todo->status)
                                    <button disabled class="btn btn-sm btn-outline-danger">Completed</button>
                                @else
                                    <a href="{{ route('todo.completed', ['todo' => $todo->id]) }}" class="btn btn-sm btn-info">Done?</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $todos->links('layout.paginate') }}
        </div>
        @endauth
        @guest
            <h3>Please <a href="{{ route('login') }}" >Login</a> to use awsome Todo app!</h3> 
        @endguest
    </div>
@endsection
