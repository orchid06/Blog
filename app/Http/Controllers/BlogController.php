<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{


    public function index(): View
    {
        $fblog = Blog::latest()->first();
        $blogs = Blog::latest()->paginate(4);

        return view('welcome', compact('blogs', 'fblog'));
    }


    public function uploadImage(mixed $file): string
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/blog', $imageName);
        return $imageName;
    }

    public function uploadGalleryImages($files)
    {
        $galleryFileNames = [];

        foreach ($files as $galleryImage) {
            $galleryImageName = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
            $galleryImage->move('uploads/blog/gallery/', $galleryImageName);
            $galleryFileNames[] = $galleryImageName;
        }

        return $galleryFileNames;
    }

    public function deleteFile(string $filePath): void
    {
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }


    public function blogCreate(Request $request): RedirectResponse
    {
        $request->validate([
            'title'           => 'required|max:50',
            'description'     => 'required|max:200',
            'image'           => 'required|image',
            'gallery_image.*' => 'image',
        ]);

        $imageName            = $this->uploadImage($request->file('image'));

        $galleryFileNames = $request->hasFile('gallery_image') ? $this->uploadGalleryImages($request->file('gallery_image'))
            : null;


        Blog::create([
            'title'           => $request->input('title'),
            'description'     => $request->input('description'),
            'image'           => $imageName,
            'gallery_image'   => $galleryFileNames,
        ]);

        return back()->with('success', 'Blog Created successfully');
    }

    public function BlogUpdate(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title'           => 'required|max:50',
            'description'     => 'required|max:200',
            'image'           => 'image',
            'gallery_image.*' => 'image',
        ]);

        $product = Blog::findOrFail($id);

        $imageName = $request->hasFile('image')
            ? $this->uploadImage($request->file('image'))
            : $product->image;

        $galleryFileNames = $request->hasFile('gallery_image')
            ? $this->uploadGalleryImages($request->file('gallery_image'))
            : $product->gallery_image;

        $product->update([
            'title'           => $request->input('title'),
            'description'     => $request->input('description'),
            'image'           => $imageName ?? $product->image,
            'gallery_image'   => $galleryFileNames ?? $product->galery_image,
        ]);

        return back()->with('success', 'Product Updated');
    }

    public function blogDelete(int $id): RedirectResponse
    {

        $blog = Blog::findOrfail($id);

        $imagePath = public_path("uploads/{$blog->image}");
        $this->deleteFile($imagePath);

        if ($blog->gallery_image) {
            foreach ($blog->gallery_image as $galleryFileName) {
                $galleryPath = public_path("uploads/gallery/{$galleryFileName}");
                if (file_exists($galleryPath)) {
                    @unlink($galleryPath);
                }
            }
        }


        $blog->delete();

        return back()->with('success', 'Blog deleted successfully.');
    }

    public function search(Request $request): View
    {
        $search = $request->input('search');
        $fblog = Blog::latest()->first();

        $blogs = Blog::where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")->paginate(4);

        return view('dashboard.user.home')->with([
            'blogs' => $blogs,
            'fblog' => $fblog
        ]);
    }

    public function like($blogId)
    {
        
        $existingLike = Like::where('user_id', auth()->id())
            ->where('blog_id', $blogId)
            ->first();

        if ($existingLike) {
            
            $existingLike->delete();
            return back()->with('success', 'Blog post unliked successfully.');
        }

        
        Like::create([
            'user_id' => auth()->id(),
            'blog_id' => $blogId,
        ]);

        return back()->with('success', 'Blog post liked successfully.');
    }

    public function addToCart(Request $request, $id): RedirectResponse
    {

        $product = Product::findOrfail($id);

        $request->validate([
            'qty' => 'required|numeric|gt:0|max:' . $product->qty,
        ]);

        $existingCartItem = Cart::where('product_id', $product->id)
            ->where('user_id', auth('web')->id())
            ->first();

        if ($existingCartItem) {
            $existingCartItem->update(['qty' => $existingCartItem->qty + $request->input('qty')]);
        } else {

            Cart::create([
                'user_id'     => Auth::user()->id,
                'product_id'  => $product->id,
                'qty'         => $request->input('qty'),
                'price'       => $product->discountedPrice,

            ]);
        }

        $product->decrement('qty', $request->input('qty'));


        return back()->with('success', 'Item added to cart successfully.');
    }

    public function cartIndex(): View
    {
        $user  = auth('web')->user();
        $user_name = Auth::user()->name;
        $user_id = Auth::user()->id;

        $cartProducts = $user->carts;

        $totalCartProduct = $cartProducts->count();
        $totalCartQty     = $cartProducts->sum('qty');
        $totalCartPrice   = $cartProducts->sum(function ($cartProduct) {
            return $cartProduct->price * $cartProduct->qty;
        });

        return view('dashboard.user.cart', compact('cartProducts', 'totalCartProduct', 'totalCartQty', 'totalCartPrice', 'user_name', 'user_id'));
    }


    public function cartQtyUpdate(Request $request, $id): RedirectResponse
    {
        $cart     = Cart::where('user_id', $id)->firstorfail();
        $product  = $cart->product;


        $maxValue        = $product->qty;
        $existingCartQty = $cart->qty;

        $request->validate([
            'cartQty' => 'required|numeric|max:' . $maxValue,
        ]);

        $inputQty  = $request->input('cartQty');

        $stockQty  = $product->qty;

        $qtyDifference = $existingCartQty - $inputQty;

        $newQty = $stockQty;

        $newQty = match (true) {
            $qtyDifference > 0 => $stockQty + $qtyDifference,
            $qtyDifference < 0 => $stockQty - abs($qtyDifference),
            default => $stockQty
        };


        $product->update(['qty' => $newQty]);


        $cart->update(['qty' => $inputQty]);

        return back()->with('success', 'Quantity updated successfully.');
    }


    public function cartProductDelete($id): RedirectResponse
    {
        $cartProduct = Cart::findOrFail($id);

        $product = $cartProduct->product;

        $product->update(['qty' => $product->qty + $cartProduct->qty]);

        $cartProduct->delete();

        return back()->with('success', 'Item deleted successfully.');
    }


    public function productDetails($id): View
    {

        $product = Product::findOrfail($id);


        $orderProducts = Cart::where('product_id', $id)->get();

        $totalOrder = $orderProducts->sum('qty');

        return view('productDetails', compact('product', 'totalOrder'));
    }
}
