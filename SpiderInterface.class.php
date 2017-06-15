<?php
/**
 * 蜘蛛订票选座
 * @Author esyy  
 * @version 1.7
 * @var data 2016/5/10
 */
class SpiderInterface
{
    /*************测试商户和密匙***********/
	  //private $key = '########';//授权码
	  //private $pwd = '#################';
	  //private $api_url = "http://#################eshi/";//API请求地址
    /****正式商户和密匙*****/
	//private $api_url = "http://#############################/";
	//授权码
	private $key = '####################';
	private $pwd = '#######################';
	private $api_url = "http://f######################vie/";
	private $filetype = 'json';
	/**
	 * ------------------------------------------------------
	 * 获取城市列表
	 * @param int cid 影院id
	 * @param int pid 合作伙伴id
	 * @return json array
	 * ------------------------------------------------------
	 */
	public function cityList($params=FALSE)
	{
		$method = 'cityList.html';
		$sign = md5($this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
		return $res;
	}
	
	/**
	 * ------------------------------------------------------
	 * 获取城市列表
	 * @param int cid 影院id
	 * @param int pid 合作伙伴id
	 * @return json array
	 * ------------------------------------------------------
	 */
	public function regionList($params=FALSE)
	{
		$method = 'regionList.html';
		//$params['cityId'] = 'shenzhen';
		$sign = md5($params['cityId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
	}
	
	public function cinemaList($params=FALSE){
		$method = 'cinemaList.html';
		//$params['cityId'] = 'shanghai';
		$sign = md5($params['cityId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
		
		//file_put_contents('ciname_list.txt',var_export($res,true));
		return $res;
		
	}
	
	public function hallList($params){
		$method = 'hallList.html';
		if(!$params['cinemaId']){
			return  'cinema_id不能为空';
		}
		$sign = md5($params['cinemaId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	
	public function seatList($params){
		$method = 'seatList.html';
		if(!$params['cinemaId'] || !$params['hallId']){
			return  '参数不完整';
		}
		//$params['cinemaId'] = '31020701';
		$sign = md5($params['cinemaId'].$params['hallId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	
	public function showList($params){
		$method = 'showList.html';
		if(!$params['cinemaId'] || !$params['showDate']){
			return  'cinema_id或者show_date不能为空';
		}
		//$params['cinemaId'] = '31020701';
		$sign = md5($params['cinemaId'].$params['filmId'].$params['showDate'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
		//file_put_contents('show.txt',var_export($res,true));	
		return $res;
		
	}
	
	public function filmList($params=FALSE){
		$method = 'filmList.html';
		//$params['cinemaId'] = '31020701';
		$sign = md5($params['cinemaId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	
	public function showseatList($params){
		$method = 'showSeatList.html';
		//$params['cinemaId'] = '31020701';
		if(!$params['showId']){
			return  'show_id不能为空';
		}
		$sign = md5($params['showId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	
	
	/*
	 * ------------------------------------------------------
	 * 请求锁定座位API并且换返回数据
	 * @param array 
	 * @return json array  蜘蛛订单号及座位信息
	 * ------------------------------------------------------
	 */
	public function lockSeat($params){
		$method = 'lockSeatList.html';
		//$params['cinemaId'] = '31020701';
		if(!$params['showId'] ||!$params['cinemaId'] || !$params['hallId'] ||!$params['filmId'] || !$params['seatId'] || !$params['merPrice'] || !$params['feePrice'] || !$params['parorderId'] || !$params['filmId'] || !$params['mobile']){
			return  '参数不能为空';
		}
		$str = $params['showId'].$params['cinemaId'].$params['hallId'].$params['filmId'].$params['seatId'].$params['merPrice'].$params['feePrice'].$params['parorderId'].$params['mobile'];
		$sign = md5($str.$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	
	/*
	 * ------------------------------------------------------
	 * 请求解锁座位API并且换返回数据
	 * 作用:用于付款确认订单返回失败时
	 * @param array 
	 * @return json array  蜘蛛订单号及座位信息
	 * ------------------------------------------------------
	 */
	public function unlockSeat($params){
		$method = 'unlockSeat.html';
		//$params['cinemaId'] = '31020701';
		if(!$params['orderId']){
			return  '参数不能为空';
		}
		
		$sign = md5($params['orderId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	
	/*
	 * ------------------------------------------------------
	 * 请求确认订单API并且换返回数据
	 * @param array        订单号码及手机号码
	 * @return json array  出票及取票信息
	 * ------------------------------------------------------
	 */
	public function confirmOrder($params){
		$method = 'confirmOrder.html';
		//$params['cinemaId'] = '31020701';
		if(!$params['orderId'] ||!$params['mobile']){
			return  '参数不完整';
		}
		$sign = md5($params['orderId'].$params['mobile'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
		return $res;
		
	}
	
	/*
	 * ------------------------------------------------------
	 * 请求订单查询API并且换返回数据
	 * @param array        订单号码
	 * @return json array  出票及取票信息
	 * ------------------------------------------------------
	 */
	public function orderStatus($params){
		$method = 'qryOrderStatus.html';
		//$params['cinemaId'] = '31020701';
		if(!$params['orderId']){
			return  '参数不完整';
		}
		
		$sign = md5($params['orderId'].$this->key.$this->pwd);
		$res = $this->request_api($sign,$method,$params);
	
		return $res;
		
	}
	/*
	 * ------------------------------------------------------
	 * 请求API并且换返回数据
	 * @param array or string $condition
	 * @return json array
	 * ------------------------------------------------------
	 */
	private function request_api($sign,$method,$params=FALSE)
	{
		//数据格式
		$params['key']  = $this->key;
		$params['filetype']  = $this->filetype;
		$params['sign']  = $sign;
		//post方式
		
		$rs_json = $this->curl_post($this->api_url.$method,$params);
		
		$rs_arr = json_decode($this->gzdecode($rs_json), true);
	
		//get方式
		//生成请求参数 cid=1&format=xml&pid=10000
		//$query = urldecode(http_build_query($params));
		//$api_url = $this->api_url.$method."?{$query}";
		//$rs_arr =json_decode(file_get_contents($api_url),true);
		//echo $api_url.'<br />';
		//print_r($rs_arr);
		//file_put_contents('spider_url.txt',$this->api_url.$method.var_export($params,true).var_export($rs_arr,true),FILE_APPEND);
		return $rs_arr;
	}
	
	
	/**
	 * ------------------------------------------------------
	 * curl post方式获取 
	 * @param array or string $condition
	 * @return json array
	 * ------------------------------------------------------
	 */
	public function curl_post($url,$params)
	{
		$header = array();
		$curlPost = $params;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($curlPost));
		$response = curl_exec($ch);
		if(curl_errno($ch)){
			print curl_error($ch);
		}
		curl_close($ch);
		return $response;
	}

	function gzdecode ($data) {
		$flags = ord(substr($data, 3, 1));
		$headerlen = 10;
		$extralen = 0;
		$filenamelen = 0;
		if ($flags & 4) {
			$extralen = unpack('v' ,substr($data, 10, 2));
			$extralen = $extralen[1];
			$headerlen += 2 + $extralen;
		}
		if ($flags & 8) // Filename
			$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 16) // Comment
			$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 2) // CRC at end of file
			$headerlen += 2;
		$unpacked = @gzinflate(substr($data, $headerlen));
		if ($unpacked === FALSE)
			$unpacked = $data;
		return $unpacked;
	}
}
