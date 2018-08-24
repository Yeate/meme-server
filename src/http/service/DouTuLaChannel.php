<?php
namespace Pokeface\MemeServer\Http\Service;

use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;
use Pokeface\MemeServer\Http\MemesChannelInterface;


class DouTuLaChannel implements MemesChannelInterface
{
	public function showChannel(){
		return 'DouTuLa';
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
		$url = config('memeserver.doutula_url');
		$param = request()->only('page','keyword','mime');

		foreach($param as $option_k => $option_v){
    		$url = str_replace('{'.strtoupper($option_k).'}',$option_v,$url);
    	}
    	try{
    	    $data = Curl::to($url)
		    	->withHeader('Pragma: no-cache')
		    	->withHeader('User-Agent: SogouComponentAgent')
		    	->asJson()
		    	->get();
		    if($data->status==1){
		    	$memes = $this->_memes_filter($data->data->list,['url'=>'image_url'],['keywords'=>$param['keyword']]);
		    	return $memes;
		    }else{
		    	return [];
		    }
    		
    	}catch(\Exception $e){
    		\Log::error($e->getMessage(), ['filepath' => $e->getFile().$e->getLine()]);
    		throw new \Exception("Error:curl request fail", 200);
    		
    	}
    	return $memes;
    }


    protected function _memes_filter($memes,$conditions,$appends){
    	$data=[];
    	if(count($memes)){
    		array_walk_recursive($memes,function($value,$key)use(&$data,$conditions,$appends){
    			foreach($conditions as $k=>$v){
    				$data[$key][$k]=trim($value->$v);
    			}	
    			$data[$key]=array_merge($data[$key],$appends);
    		});
		}
		return $data;
    }



}