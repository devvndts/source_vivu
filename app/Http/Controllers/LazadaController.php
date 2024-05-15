<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use Illuminate\Support\Facades\Log;

use Helper, CartHelper;

class LazadaController extends Controller
{
    use SupportTrait;

    public function CallBack(Request $request){
        //Log::channel('webhook_history')->info('webhook get');
        $code = $request->code;
        $data['authorCode_lazada'] = $code;
        $data['expiryDaterefreshKey_lazada'] = 0;
        $data['accessToken_lazada'] = '';
        $data['expiryDateToken_lazada'] = 0;
        $data['refreshKey_lazada'] = '';

        $row_setting = $this->settingRepo->GetItem(['type'=>'setting']);
        $this->settingRepo->SaveItem($data,$row_setting['id']);

        return redirect()->route('admin.dashboard');
    }

    public function WebHook(Request $request){
        Log::channel('webhook_history')->info('webhook post');
    }
}
