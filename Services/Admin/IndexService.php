<?php
namespace Services\Admin;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;

use Quark\QuarkDTO;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;

use ViewModels\Admin\IndexView;
use ViewModels\ErrorAccessDeniedView;
use ViewModels\LayoutView;

/**
 * Class IndexService
 *
 * @package Services\Admin
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
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
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new IndexView(), new LayoutView());
	}
}