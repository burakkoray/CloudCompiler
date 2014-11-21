<?php

class HomeController extends BaseController {
public function home()
{
	//Mail::send('emails.auth.test',array('name' => 'Burak'), function($message) {
	//	$message ->to('burak_koray@hotmail.com','Burak Koray')->subject('Test email');
	//});
	return View::make('home'); 
}
}
