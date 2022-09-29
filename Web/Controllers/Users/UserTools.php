<?php

namespace Lc5\Web\Controllers\Users;

// use Lc5\Web\Controllers\UserMaster;
use App\Controllers\BaseController;

use CodeIgniter\I18n\Time;
use Lc5\Data\Models\SiteUsersModel;


class UserTools extends BaseController
{
	//--------------------------------------------------------------------
	public function user_id()
	{
		if ($userID = session()->get('user_id')) {
			return $userID;
		}
		return null;
	}

	
	
	//--------------------------------------------------------------------
	public function get_current_user($as_object = true)
	{
		if ($user_data = session()->get('user_data')) {
			return ($as_object) ? (object) $user_data : $user_data;
		}
		return null;
	}

	//--------------------------------------------------------------------
	public function is_logged_in()
	{
		if ($is_logged_in = session()->get('isUserLoggedIn')) {
			return $is_logged_in;
		}
		return FALSE;
	}

	//--------------------------------------------------------------------
	public function setUserSession($user)
	{
		$data = [
			'user_id' => $user->id,
			'user_data' => [
				'id' => $user->id,
				'email' => $user->email,
				'nome' => $user->name,
				'cognome' => $user->surname,
				'nome_completo' => $user->name . ' ' . $user->surname,
				'wellcome_mess' => 'Ciao ' . $user->name,

				'role' => $user->role,
				'permissions' =>  $user->permissions,
			],
			'isUserLoggedIn' => true,
			// 'curr_lc_lang' => $this->getDefaultLang(),
			// 'curr_lc_app' => $this->getDefaultApp(),
		];
		session()->set($data);
		return true;
	}



	//--------------------------------------------------------------------
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	public function profile_id()
	{
		if ($profile_id = session()->get('profile_id')) {
			return $profile_id;
		}
		return null;
	}

	

	//--------------------------------------------------------------------
	public function getCurrentUserFromDB($id, $email)
	{
		$users_model = new SiteUsersModel();
		if($user = $users_model->asObject()->orderBy('created_at', 'DESC')->where('email', $email)->where('id', $id)->where('status', 1)->first()){
			return $user;
		}
		return FALSE;

	}

	
	//--------------------------------------------------------------------
	public function destroyUserSession()
	{
		$data = [
			'user_id' => NULL,
			'user_data' => NULL,
			'isUserLoggedIn' => NULL,
			'profile_id' => NULL,
			'profile_data' => NULL,
		];
		session()->set($data);
		return true;
	}
}
