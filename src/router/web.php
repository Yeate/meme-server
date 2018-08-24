<?php 


	Route::group([ 'middleware' => 'throttle:30,1'], function () {
	    Route::get('get','MemeServer@get');
	});

















 ?>