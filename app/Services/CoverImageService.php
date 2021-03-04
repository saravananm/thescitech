<?php
namespace App\Services;

use App\Coverimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ConfigService;

class CoverImageService
{
	public function getCoverImage($id)
	{
		return Coverimage::where('id',$id)->first();
	}
	public function coverImagesList()
	{
		$configvalues = new ConfigService();
		$configvalues = $configvalues->configsListArray();
		return Coverimage::orderBy('year','desc')->orderBy('month','desc')->paginate($configvalues['admin_panel_list_limit']);
	}

	public function saveValidation($req)
	{
		return Validator::make($req->all(), [
            'month' 		=> 'required|size:2',
    		'year' 			=> 'required|size:4',
    		'image_name' 	=> 'required|mimes:jpeg,png', 
    		'status' 		=> 'required',
        ]);
	}

	public function updateValidation($req)
	{
		return Validator::make($req->all(), [
            'month' 		=> 'required|size:2',
    		'year' 			=> 'required|size:4',
    		'image_name' 	=> 'mimes:jpeg,png', 
    		'status' 		=> 'required',
        ]);
	}

	public function saveCoverImage($req)
	{
		$cover 				= new Coverimage;
		if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/coverimage');
			$file_path = $req->image_name->hashName();
			$cover->image_name 	= $file_path;
		}
		if($req->hasFile('file_name'))
		{
			$req->file_name->store('public/images/coverimage');
			$coverimage_file_path = $req->file_name->hashName();
			$cover->file_name 	= $coverimage_file_path;
		}
        $cover->month 		= $req->month;
        $cover->year 		= $req->year;
        $cover->status 		= $req->status;

        $cover->save();
	}

	public function updateCoverImage($req)
	{
		$cover 				= Coverimage::find($req->id);
        if($req->hasFile('image_name'))
		{
			$req->image_name->store('public/images/coverimage');
			$file_path = $req->image_name->hashName();
			$cover->image_name 	= $file_path;
		}
		if($req->hasFile('file_name'))
		{
			$req->file_name->store('public/images/coverimage');
			$coverimage_file_path = $req->file_name->hashName();
			$cover->file_name 	= $coverimage_file_path;
		}
        $cover->month 		= $req->month;
        $cover->year 		= $req->year;
        $cover->status 		= $req->status;
        $cover->save();
	}

	public function getLatestCoverImage()
	{
		return Coverimage::orderBy('year','desc')->where('status','1')->orderBy('month','desc')->first();
	}

	public function getCoverImageByFilter($my)
	{
		$my_array = explode("-",$my);
		return Coverimage::where('year',$my_array[1])->where('status','1')->where('month',$my_array[0])->first();
	}

	public function allCoverImages()
	{
		return Coverimage::orderBy('year','desc')->where('status','1')->orderBy('month','desc')->get();
	}

	public function getCoverImageYearsMonths()
	{
		$YearsMonths =  Coverimage::where('status','1')->orderBy('year','desc')->orderBy('month','desc')->get();
		$arr = [];
		foreach($YearsMonths as $ym)
		{
			$arr[$ym->year][$ym->month] = 1;
		}
		return $arr;
	}
}