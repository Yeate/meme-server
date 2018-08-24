<?php
namespace Pokeface\MemeServer\Http\Service;

use Pokeface\MemeServer\Http\MemesChannelInterface;



class MemeService 
{
	protected $memes;
	public function __construct(MemesChannelInterface $memes){
		$this->memes = $memes;
	}

	public function showChannel(){
		return $this->memes->showChannel();
	}

	public function getMemes(){
		return $this->memes->getMemes();
	}



}