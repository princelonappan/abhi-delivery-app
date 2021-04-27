<?php

namespace App\Services;

use GuzzleHttp\Client as Http;
use App\Customer;
use App\User;
class AuthProxy
{
	public $http;

	public $baseUrl;

	public function __construct()
	{
		$this->http = new Http;
		$this->baseUrl = env('APP_URL');
	}

	public function getAccessToken($credentials)
	{
		$client = $this->getPasswordClient();
		$response = $this->http->post($this->baseUrl.'/oauth/token', [
			'form_params' => [
				'grant_type' => 'password',
        		'client_id' => $client->id,
        		'client_secret' => $client->secret,
        		'username' => $credentials['email'],
        		'password' => $credentials['password']
			]
		]);
		return json_decode((string) $response->getBody(), true);
	}

	public function refreshAccessToken()
	{
		$client = $this->getPasswordClient();
		$response = $this->http->post($this->baseUrl.'/oauth/token', [
			'form_params' => [
				'grant_type' => 'refresh_token',
        		'client_id' => $client->id,
        		'client_secret' => $client->secret,
        		'refresh_token' => request('refresh_token')
			]
		]);
		return json_decode((string) $response->getBody(), true);
	}

	public function getPasswordClient()
	{
    	return \DB::table('oauth_clients')->where('id', env('PASSWORD_GRANT_CLIENT'))->first();
	}

	public function identityUser()
	{
		switch (request('type')) {
			case 'facebook':
				$user = User::where('facebook_id', request('facebook_id'))->firstOrFail();
				break;
			case 'google':
				$user = User::where('google_id', request('google_id'))->firstOrFail();
				break;
			default:
				$customer = Customer::where('phone_number',request('phone_number'))->firstOrFail();
				$user = $customer->user;
				break;
		}
		return $user;
	}
}
