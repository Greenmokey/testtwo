<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WebDemoController extends WebBaseController
{

    public function index()
    {
        return view('webDemo');
    }

    public function saveImg(Request $request)
    {
        $imageArr = $request->input('images', []);

        $imagePath = $this->imagePath = public_path('images/');

        $resImages = [];
        foreach ($imageArr as $mediaId) {
            $fileName = date('YmdHis',time()).rand(1000, 9999);
            $res = $this->temporary->download($mediaId, $imagePath, $fileName);
            if($res){
                $resImages[] = 'public/images/'.$res;
            }
        }

        $strImages = implode(',', $resImages);

        return ['status' => 0, 'msg' => $strImages];
    }

}
