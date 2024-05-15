<?php

namespace App\Lazada;



use Illuminate\Support\Facades\Auth;



use Lazada\LazopClient;

use Lazada\LazopRequest;



use Helper;



class LazadaPlatformAPI{ 

	private $config;

	private $d;

	private $func;

	private $com;

	private $setting;

	private $c;

	private $url, $apiKey, $apiSecret, $config_lazada, $lazadaUrl_callback, $lazadaUrlAuth;

	public $active_lazada;



	/*

    |--------------------------------------------------------------------------

    | khởi tạo

    |--------------------------------------------------------------------------

    */

	public function __construct() {

		$this->config_lazada = config('lazada');

		$this->active_lazada = $this->config_lazada['active'];



		$this->lazadaUrl = $this->config_lazada['url'];

		$this->lazadaUrlAuth = $this->config_lazada['url_auth'];

		$this->lazadaUrl_callback = $this->config_lazada['url_callback'];

        $this->apiKey = $this->config_lazada['apiKey'];

        $this->apiSecret = $this->config_lazada['apiSecret'];       



        //### tạo mới / cập nhật access token

        //### access token: hết hạn trong 7 ngày

        //### refresh token: hết hạn trong 30 ngày (test) và 180 ngày (online)

        //### sử dụng refresh token để lấy access token mới

        //### nếu refresh token hết hạn thì ko thể lấy access token khác ==> thời hạn refresh token lưu trong data sẽ giảm đi 30' so với thời gian hết hạn thực tế nhận từ lazada

        if(Auth::guard('admin')->check()){

        	//$this->checkAccessToken();

        }

	}







	/*

    |--------------------------------------------------------------------------

    | kiểm tra access token

    |--------------------------------------------------------------------------

    */

	public function checkAccessToken() {

		//### lấy thông tin setting website

		$model = Helper::Get_model('setting');

		$this->setting = $model->GetItem(['type'=>'setting']);



		//### kiểm tra dữ liệu để lấy access token

		if($this->setting['authorCode_lazada']=='' || ($this->setting['expiryDateToken_lazada']>0 && time()>$this->setting['expiryDateToken_lazada']) ){ //### nếu chưa có code author ==> chạy link đăng nhập để lấy code author

			$url = "https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=".$this->lazadaUrl_callback."&client_id=".$this->apiKey;

			

			header('Location:'.Helper::GetConfigBase().'admin/inform/expireToken');

			exit();



		}else{ //### nếu đã có code author ==> có thể thực hiện phương thức lấy access token			

			// nếu chưa có access token HOẶC đã có access token nhưng bị hết hạn ==> cập nhật lại access token mới

			$this->c = new LazopClient($this->lazadaUrlAuth, $this->apiKey, $this->apiSecret);

			if(($this->setting['accessToken_lazada']=='' && $this->setting['refreshKey_lazada']=='') || ($this->setting['accessToken_lazada']!='' && time()>$this->setting['expiryDateToken_lazada']) ){

				$this->create_accessToken_Lazada($this->setting['authorCode_lazada']);



			}else if($this->setting['refreshKey_lazada']!='' && time()>$this->setting['expiryDaterefreshKey_lazada']){				

				$this->refresh_accessToken_Lazada($this->setting['refreshKey_lazada']);

			}

		}



		$this->c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);

		$this->setting = $model->GetItem(['type'=>'setting']);

	}







	/*

    |--------------------------------------------------------------------------

    | tạo 1 access token

    |--------------------------------------------------------------------------

    */

	public function create_accessToken_Lazada($code){

		$request = new LazopRequest('/auth/token/create');

		$request->addApiParam('code',$code);

		$result=$this->c->execute($request);

		

		if($result){

			$data_result=json_decode($result,true);



			$data['accessToken_lazada']=$data_result['access_token'];

			$data['refreshKey_lazada']=$data_result['refresh_token'];

			$data['expiryDaterefreshKey_lazada']=time()+$data_result['refresh_expires_in']-180;

			$data['expiryDateToken_lazada']=time()+$data_result['expires_in'];



			//### gọi repo thao tác

			$model = Helper::Get_model('setting');

			$model->SaveItem($data,$this->setting['id']);

		}

	}





	/*

    |--------------------------------------------------------------------------

    | làm mới 1 access token

    |--------------------------------------------------------------------------

    */

	public function refresh_accessToken_Lazada($refreshToken){

		$request = new LazopRequest('/auth/token/refresh');

		$request->addApiParam('refresh_token',$refreshToken);

		$result=$this->c->execute($request);

		

		if($result){

			$data_result=json_decode($result,true);



			$data['accessToken_lazada']=$data_result['access_token'];

			$data['refreshKey_lazada']=$data_result['refresh_token'];

			$data['expiryDaterefreshKey_lazada']=time()+$data_result['refresh_expires_in']-180;

			$data['expiryDateToken_lazada']=time()+$data_result['expires_in'];



			//### gọi repo thao tác

			$model = Helper::Get_model('setting');

			$model->SaveItem($data,$this->setting['id']);

		}

	}







	/*

    |--------------------------------------------------------------------------

    | Lấy ds sản phẩm

    |--------------------------------------------------------------------------

    */

	public function getListProduct_Lazada($sellerSKU = null, $offset=0){

		/*Lấy danh sách sản phẩm Lazada*/

		$request = new LazopRequest('/products/get','GET');

		$request->addApiParam('filter','all');

		$request->addApiParam('offset',$offset);

		$request->addApiParam('limit','20');

		if($sellerSKU){

			$request->addApiParam('sku_seller_list',json_encode($sellerSKU));

		}



		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		} 

		return $data_result;

	}







	/*

    |--------------------------------------------------------------------------

    | Chi tiết sản phẩm

    |--------------------------------------------------------------------------

    */

	public function getDetailProduct_Lazada($masp=''){

		/*Lấy danh sách sản phẩm Lazada*/

		 

		$request = new LazopRequest('/product/item/get','GET');

		//$request->addApiParam('item_id','692345699');

		$request->addApiParam('seller_sku',$masp);

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}

		return $data_result;

	}





	/*

    |--------------------------------------------------------------------------

    | Cập nhật sản phẩm

    |--------------------------------------------------------------------------

    */

	public function updateQCProduct_Lazada($arr_products=null){

		/*Lấy danh sách sản phẩm Lazada*/

		$str='';

		$str.='<Request>';

			$str.='<Product>';

				$str.='<Skus>';

					foreach ($arr_products as $k => $v) {

					    $str.='<Sku>';

					    	$str.='<ItemId>'.$v['item_id_lazada'].'</ItemId>';

					        $str.='<SellerSku>'.$v['masp'].'</SellerSku>';

					        $str.='<Quantity>'.$v['soluong_lazada'].'</Quantity>';

					    $str.='</Sku>';

				    }

				$str.='</Skus>';

			$str.='</Product>';

		$str.='</Request>';



		$request = new LazopRequest('/product/price_quantity/update');

		$request->addApiParam('payload',$str);



		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

			//dd($data_result);

		}

		return $data_result;

	}



	

	public function updateProduct_Lazada($id=0){

		/*Cập nhật sản phẩm Lazada*/

		 

		$product = $this->d->rawQueryOne("select * from #_product where id=".$id." limit 0,1");

		if($product){

			$brand = $this->d->rawQueryOne("select tenvi from #_product_brand where id=".$product['id_brand']." limit 0,1");

			$option = $this->d->rawQuery("select * from #_product_option where id_product=".$product['id']." hienthi=1 ");

			$str='';

			$str.='<\?xml version=\"1.0\" encoding=\"UTF-8\" \?>';

			$str.='<Request>';	 

				$str.='<Product>';		 

					$str.='<PrimaryCategory>6614</PrimaryCategory>';		 

					$str.='<SPUId></SPUId>';		 

					$str.='<AssociatedSku></AssociatedSku>';		

					$str.='<Attributes>';			 

						$str.='<name>api create product test sample</name>';

						$str.='<short_description>This is a nice product</short_description>';

						$str.='<brand>Remark</brand>';

						$str.='<model>asdf</model>';

						$str.='<kid_years>Kids (6-10yrs)</kid_years>';

						$str.='<delivery_option_sof>Yes</delivery_option_sof>';

						/*should be set as \u2018Yes\u2019 only for products to be delivered by seller*/

					$str.='</Attributes> ';		

					$str.='<Skus>';			 

						$str.='<Sku>';				 

							$str.='<SellerSku>api-create-test-1</SellerSku>';

							$str.='<color_family>Green</color_family>';

							$str.='<size>40</size>';

							$str.='<quantity>1</quantity>';

							$str.='<price>388.50</price>';

							$str.='<package_length>11</package_length>';

							$str.='<package_height>22</package_height>';

							$str.='<package_weight>33</package_weight>';

							$str.='<package_width>44</package_width>';

							$str.='<package_content>this is what\'s in the box</package_content>';

							$str.='<Images>';

								$str.='<Image>http://sg.s.alibaba.lzd.co/original/59046bec4d53e74f8ad38d19399205e6.jpg</Image>';

								$str.='<Image>http://sg.s.alibaba.lzd.co/original/179715d3de39a1918b19eec3279dd482.jpg</Image>';

							$str.='</Images>';

						$str.='</Sku>';

					$str.='</Skus>';

				$str.='</Product>';

			$str.='</Request>';



			$request = new LazopRequest('/product/update');

			$request->addApiParam('payload',$str);



			$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

			if($result){

				$data_result= json_decode($result,true);

			}

			return $data_result;

		}

	}

	public function createProduct_Lazada($id=0){

		/*Lấy danh sách sản phẩm Lazada*/

		 

		$product = $this->d->rawQueryOne("select * from #_product where id=".$id." limit 0,1");

		if($product){

			$brand = $this->d->rawQueryOne("select tenvi from #_product_brand where id=".$product['id_brand']." limit 0,1");

			$option = $this->d->rawQuery("select * from #_product_option where id_product=".$product['id']." hienthi=1 ");

			$str='';

			$str.='<\?xml version=\"1.0\" encoding=\"UTF-8\" \?>';

			$str.='<Request>';	 

				$str.='<Product>';		 

					$str.='<PrimaryCategory>6614</PrimaryCategory>';		 

					$str.='<SPUId></SPUId>';		 

					$str.='<AssociatedSku></AssociatedSku>';		

					$str.='<Attributes>';			 

						$str.='<name>api create product test sample</name>';

						$str.='<short_description>This is a nice product</short_description>';

						$str.='<brand>Remark</brand>';

						$str.='<model>asdf</model>';

						$str.='<kid_years>Kids (6-10yrs)</kid_years>';

						$str.='<delivery_option_sof>Yes</delivery_option_sof>';

						/*should be set as \u2018Yes\u2019 only for products to be delivered by seller*/

					$str.='</Attributes> ';		

					$str.='<Skus>';			 

						$str.='<Sku>';				 

							$str.='<SellerSku>api-create-test-1</SellerSku>';

							$str.='<color_family>Green</color_family>';

							$str.='<size>40</size>';

							$str.='<quantity>1</quantity>';

							$str.='<price>388.50</price>';

							$str.='<package_length>11</package_length>';

							$str.='<package_height>22</package_height>';

							$str.='<package_weight>33</package_weight>';

							$str.='<package_width>44</package_width>';

							$str.='<package_content>this is what\'s in the box</package_content>';

							$str.='<Images>';

								$str.='<Image>http://sg.s.alibaba.lzd.co/original/59046bec4d53e74f8ad38d19399205e6.jpg</Image>';

								$str.='<Image>http://sg.s.alibaba.lzd.co/original/179715d3de39a1918b19eec3279dd482.jpg</Image>';

							$str.='</Images>';

						$str.='</Sku>';

					$str.='</Skus>';

				$str.='</Product>';

			$str.='</Request>';



			$request = new LazopRequest('/product/create');

			$request->addApiParam('payload',$str);



			$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

			if($result){

				$data_result= json_decode($result,true);

			}

			return $data_result;

		}

	}

	public function getListcatalog_Lazada(){

		/*Lấy danh sách danh mục sản phẩm Lazada*/

		 

		$request = new LazopRequest('/category/tree/get','GET');

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}  

		return $data_result;

	}

	public function getListAttribute_Lazada($id=0){

		/*Lấy danh sách danh mục sản phẩm Lazada*/

		

		$c = new LazopClient(url,appkey,appSecret);

		$request = new LazopRequest('/category/attributes/get','GET');

		$request->addApiParam('primary_category_id',$id);

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}  

		

		return $data_result;

	}



	/*=============================================================================

	|

	| Các hàm xử lý đơn hàng

	|

	/*=============================================================================*/



  	public function getOrder_Lazada($id=0){

  		/*Lấy thông tin đơn hàng Lazada*/		 

		$request = new LazopRequest('/order/get','GET');

		$request->addApiParam('order_id',$id);

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}

		return $data_result;

	}

	

  	public function getOrderItems_Lazada($id=0){

  		/*Lấy thông tin chi tiết đơn hàng Lazada*/  

		$request = new LazopRequest('/order/items/get','GET');

		$request->addApiParam('order_id',$id);

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}

		return $data_result;

	}

	

	public function getAllOrder_Lazada($update_before=0,$update_after=0,$created_before=0,$created_after=0,$sort_direction='DESC',$limit=0,$status='',$sort_by='created_at'){

   		/*Lấy danh sách đơn hàng Lazada*/



   		if($update_before==0){

   			$update_before=time();

   		}

   		if($created_before==0){

   			$created_before=time();

   		}

   		if($update_after==0){

   			$update_after=time();

   		}

   		if($created_after==0){

   			$created_after=time();

   		}



		$request = new LazopRequest('/orders/get','GET');



		/*Đơn hàng cập nhật trước ngày*/

		$request->addApiParam('update_before',date(DateTime::ISO8601,$update_before));



		/*Đơn hàng cập nhật từ ngày*/

		$request->addApiParam('update_after',date(DateTime::ISO8601,$update_after));



		/*Đơn hàng trước ngày*/

		$request->addApiParam('created_before',date(DateTime::ISO8601,$created_before));



		/*Đơn hàng từ ngày*/

		$request->addApiParam('created_after',date(DateTime::ISO8601,$created_after));



		/*Sắp xếp theo 

			DESC => Giảm dần

			ASC => Tăng dần

		*/

		$request->addApiParam('sort_direction',$sort_direction);



		/*

		Lấy từ đơn hàng thứ n

		$request->addApiParam('offset','0');

		*/



		if($limit>0){ /* Giới hạn số lượng đơn hàng lấy ra */

			$request->addApiParam('limit',$limit);

		}		

		if($sort_by==''){ 

			/*Lọc theo 

				created_at => ngày tạo

				updated_at => ngày cập nhật

			*/

			$request->addApiParam('sort_by',$sort_by);

		}

		if($status==''){

			/* Trạng thái đơn hàng

			unpaid => chưa thanh toán

			pending => đang xử lý

			ready_to_ship => Chuẩn bị hàng

			shipped => Đang giao

			canceled => đã hủy

			delivered => Đã giao

			returned => Chuyển hoàn

			failed => thất bại

			 */

			$request->addApiParam('status',$status);

		}

		

		

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);



		if($result){

			$data_result= json_decode($result,true);

			 	

		}

	}

	public function getMultiOrderItems_Lazada($id=''){

		/*Lấy thông tin chi tiết nhiều đơn hàng Lazada*/

		/* $id=[IDorder1,IDorder2,IDorder3,IDorder3]*/



		$request = new LazopRequest('/orders/items/get','GET');

		$request->addApiParam('order_ids',$id);

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}

		return $data_result;

	}

  	public function getOVOOrder_Lazada($id=''){

		/*Lấy thông tin chi tiết nhiều đơn hàng Lazada*/

		/* $id=[IDorder1,IDorder2,IDorder3,IDorder3]*/

		

		$request = new LazopRequest('/orders/ovo/get');

		$request->addApiParam('tradeOrderIds',$id);

		$result=$this->c->execute($request, $this->setting['accessToken_lazada']);

		if($result){

			$data_result= json_decode($result,true);

		}

		return $data_result;

	}

}