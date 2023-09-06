<?php
namespace Services\Admin\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\IQuarkSignedGetService;

use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

use Models\User;

/**
 * Class RemoveService
 *
 * @package Services\Admin\User
 */
class RemoveService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedGetService, IQuarkServiceWithCustomProcessor {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}

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
		return array('status' => 403);
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return mixed
	 */
	public function SignatureCheckFailedOnGet (QuarkDTO $request) {
		return array('status' => 403);
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return array('status' => 200);
		/**
		 * @var QuarkModel|User $user
		 */
		$user = QuarkModel::FindOneById(new User(), $request->URI()->Route(3));

		if ($user == null)
			return array('status' => 404);

		return array(
			'status' => $user->Remove() ? 200 : 500
		);
	}
}