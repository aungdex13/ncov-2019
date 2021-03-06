<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SessionToken;

class CreateSessionToken
{
	/**
	* Create the event listener.
	*
	* @return void
	*/
	public function __construct() {
		//
	}

	/**
	* Handle the event.
	*
	* @param  Login  $event
	* @return void
	*/
	public function handle(Login $event) {
		$token = new SessionToken;
		$token->user_id = $event->user->id;
		$token->token = str_random(16);
		$token->save();
		session(['token' => $token->token]);
	}
}
