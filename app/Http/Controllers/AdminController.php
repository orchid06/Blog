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

        return view('dashboard.admin.home', compact('users'));
    }

    public function viewBlog(): View
    {
        $blogs = Blog::latest()->get();

        return view('dashboard.admin.blog', compact('blogs'));
    }

    public function viewCart($id): View
    {
        $user  = auth('web')->user();
        $user = User::findorfail($id);
        $user_name = $user->name;
        $user_id = $user->id;

        $cartProducts = $user->carts;

        $totalCartProduct = $cartProducts->count();
        $totalCartQty     = $cartProducts->sum('qty');
        $totalCartPrice   = $cartProducts->sum(function ($cartProduct) {
            return $cartProduct->price * $cartProduct->qty;
        });

        return view('dashboard.user.cart', compact('cartProducts', 'totalCartProduct', 'totalCartQty', 'totalCartPrice', 'user_name', 'user_id'));
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
        $ids = $user->carts()->pluck('id')->toArray();

        if ($ids) {
            $productController = new ProductController();
            foreach ($ids as $id) {
                $productController->cartProductDelete($id);
            }
        }
        $user->delete();


        return back()->with('success', 'User deleted successfully.');
    }



    public function search(Request $request): View
    {
        $search = "%" . $request->input('search') . "%";

        $products = Product::where('title', 'LIKE', $search)
            ->orWhere('description', 'LIKE', $search)->paginate(3);

        $totalProduct  = Product::count();
        $totalQty      = Product::sum('qty');
        $totalPrice    = Product::sum('price');

        return view('dashboard.admin.product', compact(
            'products',
            'totalQty',
            'totalPrice',
            'totalProduct',
        ));
    }
}
