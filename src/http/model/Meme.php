<?php
namespace Pokeface\MemeServer\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Meme extends Model{
	protected $appends = ['tags','path','md5'];
}