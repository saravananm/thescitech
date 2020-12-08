<?php
namespace App\Services;

use App\About_subscribe_advertise_contact;
use Illuminate\Http\Request;

class AboutSubscribeAdvertiseContactService
{
	public function getContent()
	{
		return About_subscribe_advertise_contact::first();
	}

	public function saveContent($req)
	{
		$this->clearContent();
		$content 				= new About_subscribe_advertise_contact;
        $content->about 		= $req->about;
        $content->subscribe 	= $req->subscribe;
        $content->advertise 	= $req->advertise;
        $content->contact 		= $req->contact;
		$content->save();
	}

	public function clearContent()
	{
		About_subscribe_advertise_contact::truncate();
	}
}