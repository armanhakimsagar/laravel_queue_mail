<?php

use App\Jobs\SendMailJob;
use Carbon\carbon;

Route::get('/', function () {
    return view('welcome');
});


Route::get('send_mail',function(){

	$job = (new SendMailJob)
			->delay(Carbon::now()->addSeconds(5));

	dispatch($job);

	return "email ok";
	
});
