<?php namespace inwave\Blog;

use App\Http\Controllers\Controller;
use inwave\Blog\Models\Category;
use inwave\Blog\Models\Option;
use inwave\Blog\Models\Post;

class BlogController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::isPublished()->paginate(10);

        return view('blog::index')
            ->withPosts($posts)
            ->withCategories($categories)
            ->withPageTitle(config('blog.title'));
    }

    public function show($slug) {
        $post = Post::isPublished()->whereSlug($slug)->first();
        $categories = Category::all();

        return view('blog::post.show')
            ->withPost($post)
            ->withCategories($categories)
            ->withPageTitle($post->title.' - Magazine');
    }

    public function showPost($slug) {
        $post = Post::isPublished()->whereSlug($slug)->first();
        $categories = Category::all();
        return view('blog::post.show')
            ->withPageTitle($post->title)
            ->withPost($post)
            ->withCategories($categories)
            ->withActiveCategory($post->category->id);
    }

    public function rss() {
        $posts = Post::isPublished()->orderBy('published_at', 'desc')->take(10)->get(); //TODO use options instead of take(10) !
        $last_build_date = \DateTime::createFromFormat('Y-m-d H:i:s', Post::max('created_at'))->format('D, d M Y H:i:s O');

        $content = view('blog::rss')
            ->withPosts($posts)
            ->withLastBuildDate($last_build_date)
            ->withSiteName(Option::get('site_name'));

        return \Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function showCategory($slug) {
        $categories = Category::all();
        $category = Category::whereSlug($slug)->first();
        $posts = Post::isPublished()->where('category_id', $category->id)->paginate(10);

        return view('blog::category.show')
            ->withPageTitle($category->name)
            ->withPosts($posts)
            ->withCategory($category)
            ->withCategories($categories)
            ->withActiveCategory($category->id);
    }
}
