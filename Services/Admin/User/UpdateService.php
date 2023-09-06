<?php
namespace Services\Admin\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkSignedPostService;

use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;

use ViewModels\Admin\User\UpdateView;
use ViewModels\ErrorAccessDeniedView;
use ViewModels\ErrorCSRFView;
use ViewModels\ErrorNotFoundView;
use ViewModels\LayoutView;

/**
 * Class UpdateService
 *
 * @package Services\Admin\User
 */
class UpdateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedPostService {
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
		$user = QuarkModel::FindOneById(new User(), $request->URI()->Route(3));

		if ($user == null)
			return QuarkView::InLayout(new ErrorNotFoundView(), new LayoutView());

		return QuarkView::InLayout(new UpdateView(), new LayoutView(), array(
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
		$user = QuarkModel::FindOneById(new User(), $request->URI()->Route(3));

		if ($user == null)
			return QuarkView::InLayout(new ErrorNotFoundView(), new LayoutView());

		$password = $user->password;
		$user->PopulateWith($request->Data());
		$user->password_change = $request->password_change == 'on';

		if (!$user->password_change)
			$user->password = $password;

		if (!$user->Save())
			return QuarkView::InLayout(new UpdateView(), new LayoutView(), array(
				'user' => $user
			));

		return QuarkDTO::ForRedirect('/admin/user/' . $user->id . '?act=updated');
	}
}