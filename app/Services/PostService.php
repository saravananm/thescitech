<?php
namespace App\Services;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use App\Services\TagService;
use App\Services\CategoryService;
use App\Services\ConfigService;

class PostService
{
	protected $categoryservice;
	protected $configvalues;

    public function __construct(CategoryService $categoryservice, ConfigService $configservice)
    {
	   // $this->categoryservice = $categoryservice;
	   $this->configservice        = $configservice;
	   $this->configvalues         = $this->configservice->configsListArray();
	}
	
	public function getDivisions()
	{
		return ["discoveries-innovations"=>"Discoveries&Innovations", "applications-impacts"=>"Applications&Impacts", "science-society"=>"Science&Society"];
	}

	public function getPosts($id)
	{
		return Post::with(['tags','categories'])->where('id',$id)->first();
	}

	public function getPostBySlug($slug)
	{
		$post =  Post::with(['tags','categories'])->where('slug',$slug)->first();
		$division = $this->getDivisions();
		return $post;
	}

	public function postsList()
	{
		return Post::orderBy('id','desc')->paginate($this->configvalues['admin_panel_list_limit']);
	}

	public function saveValidation($req)
	{
		return Validator::make($req->all(), [
			'categories' 	=> 'required',
            'title' 		=> 'required',
    		'short_message' => 'required',
    		'message' 		=> 'required',
    		'datefor' 		=> 'required',
			'author' 		=> 'required',
			'tag' 			=> 'required',
			'cover_image'   => 'required',
    		'status' 		=> 'required',
        ]);
	}

	public function updateValidation($req)
	{
		return Validator::make($req->all(), [
			'categories' 	=> 'required',
            'title' 		=> 'required',
    		'short_message' => 'required',
    		'message' 		=> 'required',
    		'datefor' 		=> 'required',
			'author' 		=> 'required',
			'tag' 			=> 'required',
			'cover_image'   => 'required',
    		'status' 		=> 'required',
        ]);
	}

	public function savePosts($req)
	{
		$post 				= new Post;
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/posts');
			$file_path = $req->image_name->hashName();
			$post->image_name 	= $file_path;
		}
        $post->title 			= $req->title;
        $post->slug 			= $this->slugify($req->title);
        $post->short_message 	= $req->short_message;
		$post->message 			= $req->message;
		$post->image_content 	= ($req->image_content==''?' ':$req->image_content);
        $post->datefor 			= $req->datefor;
        $post->author 			= $req->author;
        $post->status 			= $req->status;
        $post->cover_image 		= $req->cover_image;
        $post->side_panel 		= $req->side_panel;
		$insertedId 			= $post->save();
		$post->tags()->attach($req->tag);
		$post->categories()->attach($req->categories);

		if($req->cover_image == 1)
		{
			$this->updateCoverImageStatus($insertedId);
		}
	}

	public function updatePosts($req)
	{
		$post 				= Post::find($req->id);
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/posts');
			$file_path = $req->image_name->hashName();
			$post->image_name 	= $file_path;
		}
        $post->title 			= $req->title;
        $post->slug 			= $this->slugify($req->title);
        $post->short_message 	= $req->short_message;
		$post->message 			= $req->message;
		$post->image_content 	= ($req->image_content==''?' ':$req->image_content);
        $post->datefor 			= $req->datefor;
        $post->author 			= $req->author;
        $post->cover_image 		= $req->cover_image;
        $post->side_panel 		= $req->side_panel;
        $post->status 			= $req->status;
		$post->save();
		$post->tags()->detach();
		$post->tags()->attach($req->tag);
		$post->categories()->detach();
		$post->categories()->attach($req->categories);

		if($req->cover_image == 1)
		{
			$this->updateCoverImageStatus($req->id);
		}
	}

	public function slugify($title)
	{
		return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
	}

	public function updateCoverImageStatus($id)
	{
		Post::where('cover_image','1')->update(['cover_image' => '0']);
		Post::where('id',$id)->update(['cover_image' => '1']);
	}

	public function getPostCoverImage()
	{
		return Post::select('id','title','image_name','slug')->where('cover_image','1')->first();
	}

	public function getSidePanelTab()
	{
		$return_array = array();
		$return_array = Post::select('posts.id','title','slug')->where('side_panel','1')->where('posts.status',1)->orderBy('datefor', 'desc')->take($this->configvalues['side_panel_post_limit'])->get();
		return $return_array->toArray();
	}

	public function getTopNewsAndFeaturePosts()
	{
		return Post::with(['tags'])->join('post_categories', 'posts.id', '=', 'post_categories.post_id')->join('categories', 'post_categories.categorie_id', '=', 'categories.id')->select('posts.*')->groupBy('posts.id')->orderBy('datefor','desc')->orderBy('id','desc')->take($this->configvalues['home_page_post_limit'])->get();
	}

	public function getPostsByFilters($division, $categories)
	{
		if(empty($categories))
			return Post::with(['tags'])->join('post_categories', 'posts.id', '=', 'post_categories.post_id')->join('categories', 'post_categories.categorie_id', '=', 'categories.id')->where('division',"$division")->select('posts.id','posts.image_name','posts.title','posts.datefor','posts.slug','posts.author','posts.short_message')->groupBy('posts.id')->orderBy('datefor','desc')->orderBy('posts.id','desc')->paginate($this->configvalues['discoveries_innovations_applications_impacts_science_society_page_post_limit']);
		else
			return Post::join('post_categories', 'posts.id', '=', 'post_categories.post_id')->with(['tags'])->join('categories', 'post_categories.categorie_id', '=', 'categories.id')->where('division',$division)->whereIn('categorie_id',$categories)->select('posts.id','posts.image_name','posts.slug','posts.title','posts.datefor','posts.author','posts.short_message')->orderBy('datefor','desc')->orderBy('posts.id','desc')->paginate($this->configvalues['discoveries_innovations_applications_impacts_science_society_page_post_limit']);
	}

	

	public function getNewsAndFeaturePosts()
	{ 
		return  Post::with(['tags'])->join('post_categories', 'posts.id', '=', 'post_categories.post_id')->join('categories', 'post_categories.categorie_id', '=', 'categories.id')->groupBy('posts.id')->select('posts.id','posts.slug','posts.image_name','posts.title','posts.datefor','posts.author','posts.short_message')->orderBy('datefor','desc')->orderBy('posts.id','desc')->paginate($this->configvalues['news_and_feature_page_post_limit']);
	}
}