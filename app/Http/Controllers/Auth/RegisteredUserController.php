<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
      /**
       * Display the registration view.
       */
      public function create(): View
      {
            return view('auth.register');
      }

      /**
       * Handle an incoming registration request.
       *
       * @throws \Illuminate\Validation\ValidationException
       */
      public function store(Request $request)
      {
            $request->validate([
                  'name' => ['required', 'string', 'max:255'],
                  'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                  'password' => ['required', 'confirmed', Rules\Password::defaults()],
                  'avatar' => 'file|image|mimes:jpg,jpeg,png'
            ]);

            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $fileExtension = $avatar->getClientOriginalExtension();
            $name = $request->name;
            $fileName = time() . uuid_create() . $name[0] . $name[1] . '.' . $fileExtension;


            Storage::disk('custom')->putFileAs('avatar/', $avatar, $fileName,);

            $user = User::create([
                  'name' => $request->name,
                  'email' => $request->email,
                  'password' => Hash::make($request->password),
                  'avatar' => $fileName
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
      }
}
