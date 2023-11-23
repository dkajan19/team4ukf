<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $userRole = UserRole::all();

        return view('user_role.index', compact('userRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rola' => 'required|string|max:255',
    ]);

        UserRole::create([
            'rola' => $request->input('rola')
    ]);

        return redirect()->route('user_role.index')
                        ->with('success', 'User role has been successfully created.');
    }

    public function show($id)
    {
        $userRole = UserRole::findOrFail($id);
    
        return view('user_role.show', compact('userRole'));
    }

    public function edit($id)
    {
        $userRole = UserRole::findOrFail($id);
    
        return view('user_role.edit', compact('userRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rola' => 'required|string|max:255',
        ]);

        $userRole = UserRole::findOrFail($id);

        $userRole->update([
            'rola' => $request->rola,
        ]);

        return redirect()->route('user_role.edit', $userRole->id)
                        ->with('success', 'User role has been successfully updated.');
    }

    public function destroy($id)
    {
        $userRole = UserRole::findOrFail($id);

        $userRole->delete();

        return redirect()->route('user_role.index')
                        ->with('success', 'User role has been successfully removed.');
    }
}