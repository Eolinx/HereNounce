<?php
namespace Services\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;

use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;

use ViewModels\LayoutView;
use ViewModels\User\RegisterView;

/**
 * Class RegisterService
 *
 * @package Services\User
 */
class RegisterService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
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
		return $session->User() == null;
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return QuarkDTO::ForRedirect('/');
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

		return QuarkView::InLayout(new RegisterView(), new LayoutView(), array(
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

		unset(
			$request->role,
			$request->avatar,
			$request->local_admin,
			$request->date_created,
			$request->date_updated
		);
		$user->PopulateWith($request->Data());
		$user->password_change = true;

		if (!$user->Create())
			return QuarkView::InLayout(new RegisterView(), new LayoutView(), array(
				'user' => $user
			));

		if (!$session->ForUser($user, null))
			return QuarkView::InLayout(new RegisterView(), new LayoutView(), array(
				'user' => $user,
				'error' => 'auth'
			));

		return QuarkDTO::ForRedirect('/');
	}
}