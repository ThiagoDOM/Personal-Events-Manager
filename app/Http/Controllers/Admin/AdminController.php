<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query();
        if($request->name)
            $user->where('name', 'LIKE', "%$request->name%");

        return Inertia::render('Admin/Admins/List', [
            'admins' => UserResource::collection(
                $user->latest()->paginate()->withQueryString()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

        if(!$admin->isAdmin() || $admin->id == auth()->user()->id){

            // return Redirect::back()->with('errors', 'Error adding ad');
            return response()->json([
                'message' => "You"
            ],401);
            throw new UnauthorizedHttpException('Unauthorized');
        } else {
            $admin->delete();
            // return response()->json('Deleted with success!');
        }

    }
}
