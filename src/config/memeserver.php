<?php
return [
    'sougou_url' => env('SOUGOU_MEME_URL'),
    'doutula_url' => env('DOUTULA_MEME_URL'),
    'channel'=>[
    	'1'=>'Sougou', 
    	'2'=>'DouTuLa'
    ],
    'route'=>[
    	'prefix'=>'memes',
    	'as'=>'memes',
    ]

];