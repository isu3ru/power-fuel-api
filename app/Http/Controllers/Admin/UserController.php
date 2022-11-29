<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }

    public function index()
    {
        $title = 'Users';
        $crumbStart = 'Admin';
        $crumbEnd = 'Users';

        $userLevels = [
            UserLevel::LOCAL_AUTHORITY => 'Local Authority',
            UserLevel::WMA => 'WMA',
        ];

        $users = User::all();

        return view('admin.users.index', compact('title', 'crumbStart', 'crumbEnd', 'userLevels', 'users'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($request->password);

        $this->userRepository->create($data);

        return redirect()->route('admin.user.index')->with('success', 'New user created!');
    }

    public function removeUser($telephone)
    {
        $user = User::where('telephone', $telephone)->first();
        // Revoke all tokens...
        $user->tokens()->delete();
        $user->forceDelete();

        return response()->json(['msg' => 'user deleted']);
    }
}
