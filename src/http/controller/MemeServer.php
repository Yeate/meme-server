<?php
namespace Pokeface\MemeServer\Http\Controller;

use Pokeface\MemeServer\Http\MemesChannelInterface;
use Pokeface\MemeServer\Http\Service\MemeService;


class MemeServer extends Base
{

    public function get()
    {
    	$channel=config('memeserver.channel');
    	if(request()->has('channel') && isset($channel[request()->input('channel')])){
    		$channel = $channel[request()->input('channel')];
    	}else{
    		$channel = 'Sougou';
    	}
    	$memeService = new MemeService(app()->make($channel));
    	return $this->sendResponse($memeService->getMemes(),'返回成功');
    }



}