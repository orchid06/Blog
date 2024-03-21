<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\ProductController;
use App\Models\Comment;
use App\Models\Category;

class AdminController extends Controller
{
    public function uploadImage(mixed $file): string
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/user/', $imageName);
        return $imageName;
    }

    public function check(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email|exists:admins,email',
            'password' => 'required|min:5|max:30'
        ], [
            'email.exists' => 'This email is not exists on admin table'
        ]);


        return   Auth::guard('admin')->attempt($request->only('email', 'password'))
            ? back()
            : redirect()->route('admin.login')->with('fail', 'Incorrect credentials');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function index(): View
    {
        $users    = User::all();

        return view('dashboard.admin.home')->with(['users' => $users]);
    }

    public function viewBlog(): View
    {
        $blogs      = Blog::latest()->get();
        $categories = Category::all();

        return view('dashboard.admin.blog')->with(['blogs'      => $blogs, 
                                                   'categories' => $categories]);
    }

    public function userCreate(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:30',
            'cpassword' => 'required|min:5|max:30|same:password'
        ]);

        $imageName = $request->hasFile('image')
            ? $this->uploadImage($request->file('image'))
            : null;

        $user = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->email;
        $user->password = ($request->password);
        $user->image    = $imageName;
        $user->save();

        return back()->with('success', 'User registered successfully');
    }

    public function userUpdate(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::findOrFail($id);

        $imageName = $request->hasFile('image')
            ? $this->uploadImage($request->file('image'))
            : $user->image;

        $password = $request->input('password');

        $user->update([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'image'    => $imageName,
            'password' => $password ?? $user->password,
        ]);

        return back()->with('success', 'User Updated');
    }

    public function userDelete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();


        return back()->with('success', 'User deleted successfully.');
    }

    public function toggleActive(Request $request, int $id): RedirectResponse
    {
        $user = User::findorfail($id);
        $user->update([
            'is_active' => $request->input('is_active')
        ]);

        return redirect()->back()->with('success', 'User active status updated');
    }

    public function emailVerify(Request $request, int $id): RedirectResponse
    {
        $user = User::findorfail($id);
        $user->update([
            'email_verified_at' => $request->input('email_verified_at')
        ]);

        return redirect()->back()->with('success', 'Email Verification status updated');
    }

    public function comments(): view
    {
        $comments = Comment::latest()->get();

        return view('dashboard.admin.comment')->with('comments', $comments);
    }

    public function commentApprove(Request $request, int $id): RedirectResponse
    {
        $user = Comment::findorfail($id);
        $user->update([
            'status' => $request->input('status')
        ]);

        return redirect()->back()->with('success', 'Comment Approved');
    }

    public function commentUpdate(Request $request, int $id): RedirectResponse
    {
        $comment = Comment::findorfail($id);

        $comment->update([
            'comment' => $request->input('comment')
        ]);

        return redirect()->back()->with('success', 'Comment updated');
    }

    public function commentDecline(Request $request, int $id): RedirectResponse
    {
        $comment = Comment::findorfail($id);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment Declined');
    }

    public function viewComment(int $id): view
    {
        $comments = Comment::where('blog_id', $id)->get();

        return view('dashboard.admin.comment')->with('comments', $comments);
    }

    public function categoryUpdate(Request $request)
    {
        dd($request);
    }

    public function addNewCategory(Request $request)
    {
        Category::create([
            'name' => $request->input('name')
        ]);

        return back()->with('success' , 'Category Added');
    }
}
