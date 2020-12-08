<?php
namespace App\Services;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ConfigService;

class TagService
{
	public function getTag($id)
	{
		return Tag::where('id',$id)->first();
	}
	public function tagsList()
	{
		$configvalues = new ConfigService();
		$configvalues = $configvalues->configsListArray();
		return Tag::paginate($configvalues['admin_panel_list_limit']);
	}

	public function allTags()
	{
		return Tag::select('id','name','background','color')->where('status',1)->get();
	}

	public function saveValidation($req)
	{
		return Validator::make($req->all(), [
            'name' 			=> 'required|unique:tags|min:2',
    		'color' 		=> 'required|size:6',
    		'background' 	=> 'required|size:6',
    		'status' 		=> 'required',
        ]);
	}

	public function updateValidation($req)
	{
		return Validator::make($req->all(), [
            'name' 			=> 'required|unique:tags,name,'.$req->id.'|min:2',
    		'color' 		=> 'required|size:6',
    		'background' 	=> 'required|size:6',
    		'status' 		=> 'required',
        ]);
	}

	public function saveTags($req)
	{
		$tag 				= new Tag;
        $tag->name 			= $req->name;
        $tag->color 		= $req->color;
        $tag->background 	= $req->background;
        $tag->status 		= $req->status;;
        $tag->save();
	}

	public function updateTags($req)
	{
		$tag 				= Tag::find($req->id);
        $tag->name 			= $req->name;
        $tag->color 		= $req->color;
        $tag->background 	= $req->background;
        $tag->status 		= $req->status;
        $tag->save();
	}
}