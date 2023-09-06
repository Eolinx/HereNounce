<?php
namespace Services\Admin\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkSignedPostService;
use Quark\IQuarkTask;

use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;

use ViewModels\Admin\User\CreateView;
use ViewModels\ErrorAccessDeniedView;
use ViewModels\ErrorCSRFView;
use ViewModels\LayoutView;

/**
 * Class CreateService
 *
 * @package Services\Admin\User
 */
class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedPostService, IQuarkTask {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return APP_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return bool|mixed
	 */
	public function AuthorizationCriteria (QuarkDTO $request, QuarkSession $session) {
		return User::HasRole($session->User(), array(
			User::ROLE_ADMIN
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return QuarkView::InLayout(new ErrorAccessDeniedView(), new LayoutView());
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return mixed
	 */
	public function SignatureCheckFailedOnPost (QuarkDTO $request) {
		return QuarkView::InLayout(new ErrorCSRFView(), new LayoutView());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|User $user
		 */
		$user = new QuarkModel(new User());

		return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
			'user' => $user
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|User $user
		 */
		$user = new QuarkModel(new User());

		$user->PopulateWith($request->Data());
		$user->password_change = true;

		if (!$user->Create())
			return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
				'user' => $user
			));

		return QuarkDTO::ForRedirect('/admin/user/' . $user->id . '?act=created');
	}

	/**
	 * @param int $argc
	 * @param array $argv
	 *
	 * @return mixed
	 */
	public function Task ($argc, $argv) {
		/**
		 * @var QuarkModel|User $user
		 */
		$user = new QuarkModel(new User());

		echo 'Name: ';
		$user->name = \readline();

		echo 'E-mail: ';
		$user->email = \readline();

		echo 'Password: ';
		$user->password = \readline();
		$user->password_confirm = $user->password;
		$user->password_change = true;

		echo
		'Role:', "\r\n",
		' 1 - admin', "\r\n",
		' 2 - author', "\r\n",
		' 3 - user (default)', "\r\n",
		'Your choice: ';

		switch (\readline()) {
			case '1': $user->role = User::ROLE_ADMIN; break;
			case '2': $user->role = User::ROLE_AUTHOR; break;
			default: break;
		}

		echo 'Create: ', ($user->Create() ? 'OK' : 'FAIL'), "\r\n";
	}
}