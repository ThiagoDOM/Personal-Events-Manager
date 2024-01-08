<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query();
        $users->users();
        if ($request->name)
            $users->where('name', 'LIKE', "%$request->name%");

        return Inertia::render('Admin/Users/List', [
            'query' => $request->all(),
            'users' => UserResource::collection(
                $users->latest()->paginate()->withQueryString()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();

        return Inertia::render('Admin/Users/Form', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';
        $user = User::create($data);

        return Redirect::route('admin.users.edit', $user->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        if (!$user->isUser())
            abort(404);

        return Inertia::render('Admin/Users/Form', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        if (!$user->isUser())
            abort(404);

        $data = $request->all();
        if (!$data['password'])
            unset($data['password']);
        else
            $data['password'] = bcrypt($data['password']);

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $admin = User::findOrFail($id);
        // $request['id'] = $id;
        // $request['role'] = $admin->role;

        // $request->validate([
        //     'id' => ['required', 'not_in:1'],
        //     'role' => ['required', 'in:admin'],
        // ]);

        if (!$admin->isAdmin() || $admin->id == auth()->user()->id) {

            // return Redirect::back()->with('errors', 'Error adding ad');
            return response()->json([], 401);
        } else {
            $admin->delete();
            // return response()->json('Deleted with success!');
        }
    }
}
