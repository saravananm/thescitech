<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Services\ExtraImageService;

class ExtraImageController extends Controller
{
    protected $extraimageservice;

	public function __construct(ExtraImageService $extraimageservice)
	{
		$this->extraimageservice = $extraimageservice;
	}

    public function view()
    {
    	$extraimages = $this->extraimageservice->extraImagesList();
    	return View('admin.extraimage',['data'=> $extraimages]);
    }

    public function add(Request $req)
    {
    	//validation
    	if($req->id == ''){		
    		$validator = $this->extraimageservice->saveValidation($req);
    	}else{
    		$validator = $this->extraimageservice->updateValidation($req);
    	}
    	// error message return
        if ($validator->fails()) {
            return redirect('extraimages')->withErrors($validator)->withInput();
        }

        // insert or update the records
        if($req->id == ''){ 
    		$validator = $this->extraimageservice->saveExtraImage($req);
    		return redirect('extraimages')->with('message', 'Data successfully Created');
    	}else{
    		$validator = $this->extraimageservice->updateExtraImage($req);
    		return redirect('extraimages')->with('message', 'Data successfully Updated');
    	}
    }

    public function edit($id)
    {
    	$edit_data = $this->extraimageservice->getExtraImage($id);
    	$extraimages = $this->extraimageservice->extraImagesList();
    	return View('admin.extraimage',['data'=> $extraimages, 'edit_data' => $edit_data]);
    }
}
