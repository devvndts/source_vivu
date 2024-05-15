<?php
namespace App\Transpost;

class DeliveryAPI{
	private $config;
	
	function __construct() {
		$this->config = config('delivery.transpost_method');
	}

	/* GHTK - Lấy phí ship */
	public function getShippingFeeGHTK($postData){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/fee?" . http_build_query($postData),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER => array(
				"Token: ".$this->config['GHTK']['Token'],
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* GHTK - Check dịch vụ XFast */
	public function getXFastGHTK($postData){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/x-team?" . http_build_query($postData),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER => array(
				"Token: ".$this->config['GHTK']['Token'],
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* GHTK - Lấy thông tin sản phẩm */
	public function getProductInformationGHTK($postData){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/kho-hang/thong-tin-san-pham?" . http_build_query($postData),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Token: ".$this->config['GHTK']['Token'],
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* GHTK - Tạo đơn hàng */
	public function createOrderGHTK($postData){
		global $func;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/order",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Token: ".$this->config['GHTK']['Token']
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* GHTK - Hủy đơn hàng */
	public function cancelOrderGHTK($postData){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/cancel/".$postData,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Token: ".$this->config['GHTK']['Token']
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* GHTK - Lấy trạng thái đơn hàng */
	public function getStatusOrderGHTK($idOrder){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/v2/".$idOrder,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Token: ".$this->config['GHTK']['Token'],
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy phí ship */
	public function getShippingFeeViettelPost($postData){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/order/getPrice",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy danh sách dịch vụ phù hợp */
	public function getPriceAllViettelPost($postData){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/order/getPriceAll",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Tạo đơn hàng */
	public function createOrderViettelPost($postData){
		$token = $this->loginViettelPost();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/order/createOrder",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"token: ".$token['data']['token'].""
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Update đơn hàng */
	public function updateOrderViettelPost($postData){
		$token = $this->loginViettelPost();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/order/UpdateOrder",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"token: ".$token['data']['token'].""
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy danh sách kho hàng */
	public function getListInventoryViettelPost(){
		$token = $this->loginViettelPost();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/user/listInventory",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"token: ".$token['data']['token'].""
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy danh sách Tỉnh/TP */
	public function getListProvinceViettelPost(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/categories/listProvince",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy danh sách Quận/Huyện */
	public function getListDistrictViettelPost($provinceId){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/categories/listDistrict?provinceId=".$provinceId,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy danh sách Phường/Xã */
	public function getListWardViettelPost($districtId){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/categories/listWards?districtId=".$districtId,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Lấy danh sách dịch vụ */
	public function getServiceViettelPost($id, $url) {
		$curl = curl_init();
		$data["TYPE"] = $id;
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* ViettelPost - Login */
	public function loginViettelPost(){
		$data = array(
			"USERNAME" => $this->config['ViettelPost']['USERNAME'],
			"PASSWORD" => $this->config['ViettelPost']['PASSWORD']
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://partner.viettelpost.vn/v2/user/Login",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Login */
	public function login247Express(){
		global $func;
		$data = array(
			"UserName" => $this->config['247Express']['UserName'],
			"Password" => $this->config['247Express']['Password']
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/api/Client/ClientLogin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Lấy danh sách dịch vụ chính */
	public function getService247Express() {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/GetServiceTypes",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Lấy danh sách dịch vụ GTGT */
	public function getServiceGTGT247Express() {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/api/MasterData/Services",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/*
	247Express - Lấy danh sách địa điểm lấy hàng
	GetFullAddress = True : Lấy tất cả địa chỉ bao gồm đã duyệt và chưa duyệt
	GetFullAddress = False : Chỉ lấy các địa chỉ đã duyệt
	*/
	public function getClientHubs247Express($GetFullAddress = false) {
		global $func;
		$resLogin = $this->login247Express();
		$data = array(
			"GetFullAddress" => $GetFullAddress
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/CustomerGetClientHubs",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Tính giá cước dịch vụ của 247Express */
	public function getPriceForCustomer247Express($postData) {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/GetPriceForCustomerAPI",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID']." ",
				"token: ".$resLogin['Token']." ",
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Tạo địa chỉ kho hàng */
	public function insertClientHub247Express($postData) {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/CustomerInsertClientHub",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Tạo đơn hàng */
	public function createOrder247Express($postData) {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/CustomerAPICreateOrder",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Cập nhật đơn hàng */
	public function updateOrder247Express($postData) {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/api/Customer/CustomerAPIUpdateOrder",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Lấy ảnh vận đơn */
	public function getOrderImages247Express($postData) {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/GetOrderImages",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Hủy đơn hàng */
	public function cancelOrder247Express($postData) {
		$resLogin = $this->login247Express();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config['247Express']['baseURL']."/Api/Customer/CancelOrder",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"ClientID: ".$resLogin['ClientID'],
				"token: ".$resLogin['Token']
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* 247Express - Tracking đơn hàng */
	public function tracking247Express($orderCode) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://tracking.247post.vn/api/Order/v1/Tracking?ordercode=".$orderCode."&apikey=CAC8BDFC-0C16-4B77-A80F-0438643F2195",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}

	/* EMS - Danh sách tỉnh/thành phố */
	public function getProvinceEMS($postData) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://ws.ems.com.vn/api/v1/address/province?merchant_token='.$this->config['EMS']['merchant_token'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		return $response;
	}
}
?>