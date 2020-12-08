<?php
namespace App\Services;

use App\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use App\Services\ConfigService;

class AdvertisementService
{
	public function getAdvertisements($id)
	{
		return Advertisement::where('id',$id)->first();
	}

	public function advertisementsList()
	{
		$configvalues = new ConfigService();
		$configvalues = $configvalues->configsListArray();
		return Advertisement::paginate($configvalues['admin_panel_list_limit']);
	}

	public function saveValidation($req)
	{
		return Validator::make($req->all(), [
            'name' 			=> 'required|min:2',
            'image_name' 	=> 'required|mimes:jpeg,png',
    		'url' 			=> 'required|url',
    		'width' 		=> 'required|integer|max:1200',
    		'height' 		=> 'required|integer|max:1200',
    		'order' 		=> 'required|integer|max:10',
    		'position' 		=> 'required',
    		'status' 		=> 'required',
        ]);
	}

	public function updateValidation($req)
	{
		return Validator::make($req->all(), [
            'name' 			=> 'required|min:2',
            'image_name' 	=> 'mimes:jpeg,png',
    		'url' 			=> 'required|url',
    		'width' 		=> 'required|integer|max:1200',
    		'height' 		=> 'required|integer|max:1200',
    		'order' 		=> 'required|integer|max:10',
    		'position' 		=> 'required',
    		'status' 		=> 'required',
        ]);
	}

	public function saveAdvertisements($req)
	{
		$adv 				= new Advertisement;
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/advertisements');
			$file_path = $req->image_name->hashName();
			$adv->image_name 	= $file_path;
		}
        $adv->name 			= $req->name;
        $adv->url 			= $req->url;
        $adv->width 		= $req->width;
        $adv->height 		= $req->height;
        $adv->order 		= $req->order;
        $adv->position 		= $req->position;
        $adv->status 		= $req->status;
        $adv->save();
	}

	public function updateAdvertisements($req)
	{
		$adv 				= Advertisement::find($req->id);
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/advertisements');
			$file_path = $req->image_name->hashName();
			$adv->image_name 	= $file_path;
		}
        $adv->name 			= $req->name;
        $adv->url 			= $req->url;
        $adv->width 		= $req->width;
        $adv->height 		= $req->height;
        $adv->order 		= $req->order;
        $adv->position 		= $req->position;
        $adv->status 		= $req->status;
        $adv->save();
	}

	public function getAdvertisementsByPosition($position)
	{
		return Advertisement::where('position',$position)->where('status','1')->orderBy('order','asc')->get();
	}
}