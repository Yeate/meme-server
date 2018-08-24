<?php
namespace Pokeface\MemeServer\Http\Service;

use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;
use Pokeface\MemeServer\Http\MemesChannelInterface;


class SougouChannel implements MemesChannelInterface
{
	public function showChannel(){
		return 'Sougou';
	}


    public function getMemes()
    {
        $validator = Validator::make(request()->all(), [
		      'page'   => 'required|integer|min:1',
		      'keyword'=> 'required'
		  ]);
		if ($validator->fails()) {
			throw new \Exception($validator->errors()->first(), 100);
		}
		$url = config('memeserver.sougou_url');
		$param = request()->only('page','keyword');

		$param['keyword'] = $this->_strToLowerHight(base64_encode($param['keyword']));

		foreach($param as $option_k => $option_v){
    		$url = str_replace('{'.strtoupper($option_k).'}',$option_v,$url);
    	}
    	try{
    	    $data = Curl::to($url)
		    	->withHeader('Pragma: no-cache')
		    	->withHeader('User-Agent: SogouComponentAgent')
		    	->asJson()
		    	->get();
    		$memes = $this->_memes_filter($data->imglist,['keywords','url']);
    	}catch(\Exception $e){
    		\Log::error($e->getMessage(), ['filepath' => $e->getFile().$e->getLine()]);
    		throw new \Exception("Error:curl request fail", 200);
    		
    	}
    	return $memes;
    }


    protected function _memes_filter($memes,$conditions){
    	$data=[];
    	if(count($memes)){
    		array_walk_recursive($memes,function($value,$key)use(&$data,$conditions){
    			foreach($conditions as $v){
    				$data[$key][$v]=trim($value->$v);
    			}	
    		});
		}
		return $data;
    }

    protected function _strToLowerHight($str){
    	$arr = str_split($str);
    	foreach($arr as $k=>$v){
    		if(preg_match('/^[a-z]+$/', $v)){
    			$arr[$k]=strtoupper($v);
    		}elseif(preg_match('/^[A-Z]+$/', $v)){
    			$arr[$k]=strtolower($v);
    		}
    	}
    	return implode('',$arr);
    }



}