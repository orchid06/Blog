<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Dislike;
use App\Models\PendingComment;
use App\Models\Category;

class BlogController extends Controller
{


    public function index(): View
    {
        $fblog = Blog::latest()->first();
        $blogs = Blog::latest()->paginate(4);
        $categories = Category::all();

        return view('home')->with(['blogs'      => $blogs, 
                                   'fblog'      => $fblog,
                                   'categories' => $categories]);
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
            'cat_id'          => $request->input('cat_id')
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
            'cat_id'          => $request->input('cat_id')
        ]);

        return back()->with('success', 'Blog Updated');
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
        $search      = $request->input('search');
        $fblog       = Blog::latest()->first();
        $categories  = Category::all();

        $blogs = Blog::where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")->paginate(4);

        return view('home')->with([
            'blogs'      => $blogs,
            'fblog'      => $fblog,
            'categories' => $categories
        ]);
    }

    public function like($blogId): RedirectResponse
    {

        $existingLike = Like::where('user_id', auth()->id())
            ->where('blog_id', $blogId)
            ->first();

        $existingDisLike = Dislike::where('user_id', auth()->id())
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

        if ($existingDisLike) {

            $existingDisLike->delete();
        }

        return back()->with('success', 'Blog post liked');
    }

    public function dislike($blogId): RedirectResponse
    {

        $existingDisLike = Dislike::where('user_id', auth()->id())
            ->where('blog_id', $blogId)
            ->first();

        $existingLike = Like::where('user_id', auth()->id())
            ->where('blog_id', $blogId)
            ->first();

        if ($existingDisLike) {

            $existingDisLike->delete();
            return back()->with('success', 'Dislike removed');
        }


        Dislike::create([
            'user_id' => auth()->id(),
            'blog_id' => $blogId,
        ]);

        if ($existingLike) {

            $existingLike->delete();
            
        }

        return back()->with('success', 'Blog post Disliked');
    }

    public function blogDetail(string $slug ): View
    {
        $blog = Blog::where('slug', $slug )->first();

        $comments = $blog->comments()->where('status', 1)->get();

        return view('dashboard.user.blogDetail')->with([
            'blog' => $blog,
            'comments' => $comments
        ]);
    }

    public function comment(Request $request, int $id): RedirectResponse
    {
        Comment::create([

            'blog_id' => $id,
            'user_id' => auth()->id(),
            'comment' => $request->input('comment')
        ]);

        return back()->with('success', 'Comment added for review');
    }

    public function viewCategory(int $id): View
    {
        
        $fblog      = Blog::latest()->first();
        $blogs      = Blog::where('cat_id' , $id)->paginate(4);
        $categories = Category::all();

        return view('home')->with(['blogs'       => $blogs,
                                    'fblog'      => $fblog,
                                    'categories' => $categories]);

    }
}
