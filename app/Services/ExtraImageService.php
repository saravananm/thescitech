<?php
namespace App\Services;

use App\ExtraImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ConfigService;

class ExtraImageService
{
	public function getExtraImage($id)
	{
		return ExtraImage::where('id',$id)->first();
	}
	public function extraImagesList()
	{
		$configvalues = new ConfigService();
		$configvalues = $configvalues->configsListArray();
		return ExtraImage::orderBy('id','desc')->paginate($configvalues['admin_panel_list_limit']);
	}

	public function saveValidation($req)
	{
		return Validator::make($req->all(), [
            'image_name' 		=> 'required',
        ]);
	}

	public function updateValidation($req)
	{
		return Validator::make($req->all(), [
            'image_name' 		=> 'required',
        ]);
	}

	public function saveExtraImage($req)
	{
		$cover 				= new ExtraImage;
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/extraimage');
			$file_path = $req->image_name->hashName();
			$cover->name 	= $file_path;
		}
        $cover->save();
	}

	public function updateExtraImage($req)
	{
		$cover 				= ExtraImage::find($req->id);
        if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/extraimage');
			$file_path = $req->image_name->hashName();
			$cover->name 	= $file_path;
		}
        $cover->save();
	}

}