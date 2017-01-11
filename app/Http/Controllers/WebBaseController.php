<?php
/**
 * 需要调用微信JSSDK时的基类
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class WebBaseController extends Controller
{
    protected $temporary;//临时素材操作

    public function __construct()
    {
        $wechat = app('wechat');
        $js = $wechat->js;
        $this->temporary = $wechat->material_temporary;
        View::share('js', $js);
    }
}
