<?php
namespace Pokeface\MemeServer\Http\Controller;

use Pokeface\MemeServer\Http\Job\SaveMemes;
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

        $isCacheWyfc = config('cache_wyfc','false');
        if($isCache && count($memeService)){
            dispatch((new SaveMemes($memes))->onQueue('save_memes'));
        }
    	return $this->sendResponse($memeService->getMemes(),'返回成功');
    }



}