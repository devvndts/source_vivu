<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

use App\Http\Traits\SupportTrait;
use App\Repositories\Repo\PhotoRepository;

use Helper;

class AddonController extends Controller
{
	use SupportTrait;
	private $model, $lang;
	private $setting_opt;
    public $relations = [];

    //Init define
    public function __construct(Request $request, PhotoRepository $photoRepo){
        //$this->model = new Photo();
        $this->model = $photoRepo;
        $this->model->setModel('man');

        $this->lang = (session('locale'))?session('locale'):'vi';
        $this->setting_opt = $this->GetSettingOption('setting');
    }

    //Video type fotorama
    public function VideoFotorama(Request $request){
    	$videos = $this->model->GetAllItems('video',['act'=>'photo_multi']);

    	//### Phản hồi
        $response = array(
            "videos" => $videos,
            "lang" => $this->lang
        );

    	return view('desktop.addon.videofotorama')->with($response);
    }

    //Video type select
    public function VideoSelect(Request $request){
    	$videos = $this->model->GetAllItems('video',['act'=>'photo_multi']);

    	//### Phản hồi
        $response = array(
            "videos" => $videos,
            "lang" => $this->lang
        );

    	return view('desktop.addon.videoselect')->with($response);
    }

    //Fanpage facebook
    public function FanpageFacebook(Request $request){
    	//### Phản hồi
        $response = array(
            "setting_opt" => $this->setting_opt,
            "lang" => $this->lang
        );
    	return view('desktop.addon.fanpage')->with($response);
    }

    //Messages Facebook
    public function MessagesFacebook(Request $request){
    	//### Phản hồi
        $response = array(
            "setting_opt" => $this->setting_opt,
            "lang" => $this->lang
        );
    	return view('desktop.addon.messages')->with($response);
    }
}
