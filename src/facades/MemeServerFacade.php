<?php 
namespace Pokeface\MemeServer\Facades;


use Illuminate\Support\Facades\Facade;

class MemeServer extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'MemeServer';
    }

}