@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card border border-primary">
                <div class="card-header bg-primary text-white">
                    User Create
                </div>
                <form action="{{ route('admin.user.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-2">
                            <label for="user_level">User Level</label>
                            <select class="form-select" aria-label="Default select example" name="user_level"
                                id="user_level">
                                @foreach ($userLevels as $lk => $lv)
                                    <option value="{{ $lk }}">{{ $lv }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="telephone">Telephone</label>
                            <input type="tel" name="telephone" id="telephone" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 mx-4">
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Level</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->user_level }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">Permissions</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
