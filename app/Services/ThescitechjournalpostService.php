<?php
namespace App\Services;

use App\Thescitechjournalpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use App\Services\TagService;
use App\Services\ThescitechjournalCategoryService;
use App\Services\ConfigService;

class ThescitechjournalpostService
{
    protected $categoryservice;

    public function __construct()
    {
       // $this->categoryservice = $categoryservice;
	}

	public function getPosts($id)
	{
		return Thescitechjournalpost::where('id',$id)->first();
	}

	public function getPostBySlug($slug)
	{
		return Thescitechjournalpost::with(['tags'])->where('slug',$slug)->first();
	}

	public function postsList()
	{
		$configvalues = new ConfigService();
		$configvalues = $configvalues->configsListArray();
		return Thescitechjournalpost::join('coverimages', 'coverimages.id', '=', 'thescitechjournalposts.coverimages_id')
		->orderBy('id','desc')
		->select('thescitechjournalposts.*', 'coverimages.month', 'coverimages.year')
		->paginate($configvalues['admin_panel_list_limit']);
	}

	public function saveValidation($req)
	{
		return Validator::make($req->all(), [
			'categories' 	=> 'required',
            'title' 		=> 'required',
    		'message' 		=> 'required',
    		'datefor' 		=> 'required',
			'author' 		=> 'required',
			'tag' 			=> 'required',
    		'status' 		=> 'required',
        ]);
	}

	public function updateValidation($req)
	{
		return Validator::make($req->all(), [
			'categories' 	=> 'required',
            'title' 		=> 'required',
    		'message' 		=> 'required',
    		'datefor' 		=> 'required',
			'author' 		=> 'required',
			'tag' 			=> 'required',
    		'status' 		=> 'required',
        ]);
	}

	public function savePosts($req)
	{
		$post 				= new Thescitechjournalpost;
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/thescitechjournalposts');
			$file_path = $req->image_name->hashName();
			$post->image_name 	= $file_path;
		}
        $post->coverimages_id 	= $req->coverimages_id;
        $post->title 			= $req->title;
        $post->slug 			= $this->slugify($req->title);
        $post->short_message 	= ($req->short_message?$req->short_message:'');
		$post->message 			= $req->message;
		$post->image_content 	= ($req->image_content?$req->image_content:'');
        $post->datefor 			= $req->datefor;
        $post->author 			= $req->author;
        $post->status 			= $req->status;
        $post->side_panel 		= $req->side_panel;
		$insertedId 			= $post->save();
		$post->tags()->attach($req->tag);
		$post->categories()->attach($req->categories);
	}

	public function updatePosts($req)
	{
		$post 				= Thescitechjournalpost::find($req->id);
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/thescitechjournalposts');
			$file_path = $req->image_name->hashName();
			$post->image_name 	= $file_path;
		}
        $post->coverimages_id 	= $req->coverimages_id;
        $post->title 			= $req->title;
        $post->slug 			= $this->slugify($req->title);
        $post->short_message 	= ($req->short_message?$req->short_message:'');
		$post->message 			= $req->message;
		$post->image_content 	= ($req->image_content?$req->image_content:'');
        $post->datefor 			= $req->datefor;
        $post->author 			= $req->author;
        $post->status 			= $req->status;
        $post->side_panel 		= $req->side_panel;
		$post->save();
		$post->tags()->detach();
		$post->tags()->attach($req->tag);
		$post->categories()->detach();
		$post->categories()->attach($req->categories);
	}

	public function slugify($title)
	{
		return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
	}

	public function getThescitechPosts($my)
	{
		$thescitechjournalcategoryservice = new ThescitechjournalCategoryService;
		$thescitechjournalcategory = $thescitechjournalcategoryservice->allCategories();

		$return_arr = array();
		$my_array = explode("-",$my);

		foreach($thescitechjournalcategory as $categories)
		{
			$thescitechposts =  Thescitechjournalpost::join('coverimages', 'thescitechjournalposts.coverimages_id', '=', 'coverimages.id')->join('thescitechpost_categories','thescitechpost_categories.thescitechpost_id','=','thescitechjournalposts.id')->where('thescitechpost_categories.thescitechcategorie_id',$categories->id)->where('thescitechjournalposts.status','1')->where('coverimages.month',$my_array[0])->where('coverimages.year',$my_array[1])->orderBy('thescitechjournalposts.id','desc')->select('thescitechjournalposts.id','thescitechjournalposts.image_name','thescitechjournalposts.slug','thescitechjournalposts.title','thescitechjournalposts.datefor','thescitechjournalposts.author','thescitechjournalposts.short_message')->get();
			$post_arr = array();
			foreach($thescitechposts as $post)
			{
				$post['tags'] =  DB::select('select * from thescitechpost_tag join tags on tags.id = thescitechpost_tag.tag_id  where thescitechpost_id = :id', ['id' => $post->id]);
				array_push($post_arr, $post);
			}
			if(count($post_arr) != 0)
			$return_arr[$categories->category] = $post_arr;
		}
		return $return_arr;
	}

	public function getSidePanelTab()
	{
		$return_array = array();
		$configvalues = new ConfigService();
		$configvalues = $configvalues->configsListArray();
		$return_array = Thescitechjournalpost::select('thescitechjournalposts.id','title','slug')->where('side_panel','1')->where('thescitechjournalposts.status',1)->orderBy('datefor', 'desc')->take($configvalues['side_panel_post_limit'])->get();
		return $return_array->toArray();
	}
}