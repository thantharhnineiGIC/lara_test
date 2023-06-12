<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(string $id)
    {
        $user = User::findOrFail($id);
        return view('profile.index',compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user->profile);

        return view('profile.edit',compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if(request('image')){
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
            $image->save();
        }

        auth()->user()->profile->update(array_merge(
            $data,
            ['image' => $imagePath]
        ));

        return redirect("/profile/{$user->id}");
    }
}
