<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Services\AboutSubscribeAdvertiseContactService;

class AboutSubscribeAdvertiseContactController extends Controller
{
    protected $about_subscribe_advertise_contact;

	public function __construct(AboutSubscribeAdvertiseContactService $about_subscribe_advertise_contact)
	{
        $this->about_subscribe_advertise_contact = $about_subscribe_advertise_contact;
	}

    public function view()
    {
        $content           = $this->about_subscribe_advertise_contact->getContent();
    	return View('admin.about_subscribe_advertise_contact',['data'=> $content]);
    }

    public function add(Request $req)
    {
        $validator = $this->about_subscribe_advertise_contact->saveContent($req);
        return redirect('about_subscribe_advertise_contact')->with('message', 'Data successfully Updated');
    }
}
