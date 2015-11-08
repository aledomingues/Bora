<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models;
//use LucaDegasperi\OAuth2Server\Facades\AuthorizerFacade;
use Authorizer;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return \Response::json('Forbiden Access',403);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \Response::json('Forbiden Access',403);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = \Input::all();
		$newUser = Models\User::newUser($data);
		return \Response::json($newUser, $newUser['return_code']);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $permalink
	 * @return Response
	 */
	public function show($permalink)
	{
		$user = Models\User::getUserByPermalink($permalink);
		return \Response::json($user);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $permalink
	 * @return Response
	 */
	public function getUserData()
	{	
		$idUser = Authorizer::getResourceOwnerId();
		$user = Models\User::getUser($idUser);
		return \Response::json($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return \Response::json('Forbiden Access',403);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//verificar se o usuario alterante e o mesmo a ser alterado (token)
		if(Authorizer::getResourceOwnerId() != $id){
			return \Response::json(['messages' => 'Acesso Negado'], 401);
		}

		$data = \Input::all();
		$data['id_users'] = $id;
		$updateUser = Models\User::updateUser($data);
		return \Response::json($updateUser, $updateUser['return_code']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(Authorizer::getResourceOwnerId() != $id){
			return \Response::json(['messages' => 'Acesso Negado'], 401);
		}

		return Response::json(Models\User::getuser($id));
	}

	public function loginWithLinkedin(Request $request)
	{
	    // get data from request
	    $code = $request->get('code');

	    $linkedinService = \OAuth::consumer('Linkedin');


	    if ( ! is_null($code))
	    {
	        // This was a callback request from linkedin, get the token
	        $token = $linkedinService->requestAccessToken($code);

	        // Send a request with it. Please note that XML is the default format.
	        $result = array();
	        //$result = json_decode($linkedinService->request('/people/?format=json'), true);
	        
	        $data = array('json' => array(
	        		'comment' => 'Comentario do teste',
	        		'content' => array(
		        		'title' => 'Teste de Compartilhamento',
		        		'description' => '1, 2, 3 testando',
		        		'submitted-url' => 'https://developer.linkedin.com',
		        		'submitted-image-url' => 'http://www.videojobs.com.br/html/images/img-master-institucional.png'
	        		),
	        		'visibility' => array('code' => 'anyone')
	        	));
	        $headers = array(
				'Content-Type' => 'application/json',
				'x-li-format' => 'json',
			);

	        $resultShare = array();
	        $resultShare[] = json_decode($linkedinService->request('/people/~/shares?format=json', 'POST', json_encode($data), $headers), true);
	        $resultShare[] = json_decode($linkedinService->request('/companies/2414183/shares?format=json', 'POST', json_encode($data), $headers), true);

	        // Show some of the resultant data
	        echo 'Your linkedin first name is ' . $result['firstName'] . ' and your last name is ' . $result['lastName'];

	        //Var_dump
	        //display whole array.
	        dd($result, $token, $resultShare);

	    }
	    // if not ask for permission first
	    else
	    {
	        // get linkedinService authorization
	        $url = $linkedinService->getAuthorizationUri(['state'=>'DCEEFWF45453sdffef424']);

	        // return to linkedin login url
	        return redirect((string)$url);
	    }
	}

}
