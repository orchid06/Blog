<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Blog;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use App\Notifications\CustomVerifyEmail;

class UserController extends Controller
{
    public function uploadImage(mixed $file): string
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/user/', $imageName);
        return $imageName;
    }

    public function create(Request $request): RedirectResponse
    {

        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'image'     => 'image',
            'password'  => 'required|min:5|max:30',
            'cpassword' => 'required|min:5|max:30|same:password'
        ]);

        $imageName      = $request->hasFile('image') ? $this->uploadImage($request->file('image'))
            : null;

        $user = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->image    = $imageName ?? null;
        $user->password = ($request->password);
        $user->save();

        $user->sendEmailVerificationNotification();
        $user->generateVerificationCode();
        $user->notify(new CustomVerifyEmail($user->verification_code));

        Auth::guard('web')->login($user);

        return redirect()->route('verification.notice')->with('success', 'Registered successfully! Please check your email to verify your account.');
    }

    public function check(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:5|max:30'
        ], [
            'email.exists' => 'This email is not exists on user table'
        ]);

        return   Auth::guard('web')->attempt($request->only('email', 'password'))
            ? redirect()->route('user.index')->with('success', 'you are logged in')
            : redirect()->route('user.login')->with('fail', 'Incorrect credentials');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function index(): View
    {
        $fblog = Blog::latest()->first();
        $blogs = Blog::latest()->paginate(4);

        $user = Auth::user();

        return view('dashboard.user.home')->with(['blogs' => $blogs,
                                                  'fblog' => $fblog,
                                                   'user' => $user]);

    }

    public function toggleActive(Request $request, int $id): RedirectResponse
    {
        $user = User::findorfail($id);
        $user->update([
            'is_active' => $request->input('is_active')
        ]);

        return redirect()->back()->with('success', 'User active status updated');
    }

    public function userProfile(int $id): View
    {
        $user = User::findorfail($id);
        return view('dashboard.user.profile')->with('user', $user);
    }

    public function userUpdate(Request $request, int $id): RedirectResponse
    {
        if ($request->name) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);
        }

        if ($request->newPassword) {
            $request->validate([
                'newPassword'  => 'required|min:5|max:30',
                'cPassword' => 'required|min:5|max:30|same:newPassword'
            ]);
        }

        $user = User::findOrFail($id);

        $imageName = $request->hasFile('image')
            ? $this->uploadImage($request->file('image'))
            : $user->image;

        $oldPassword = $request->input('oldPassword');

        if ($oldPassword && !Hash::check($oldPassword, $user->password)) {
            return back()->with('error', 'Can not update password , Wrong Current Password ');
        }

        $user->update([
            'name'      => $request->input('name')        ?? $user->name,
            'email'     => $request->input('email')       ?? $user->email,
            'image'     => $imageName,
            'password'  => $request->input('newPassword') ?? $user->password,
        ]);

        return back()->with('success', 'User Updated');
    }

    public function updateLike(Request $request)
    {
        User::where('id', $request->userId)->update([
            'like'    => $request->input('likeValue'),
            'dislike' => $request->input('dislikeValue'),
        ]);
    }
}
