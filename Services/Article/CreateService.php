<?php
namespace Services\Article;

use Models\Article;
use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkSignedPostService;

use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Article\CreateView;
use ViewModels\ErrorAccessDeniedView;
use ViewModels\ErrorCSRFView;
use ViewModels\LayoutView;

/**
 * Class CreateService
 *
 * @package Services\Article
 */
class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedPostService {
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
			User::ROLE_AUTHOR,
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
		 * @var QuarkModel|Article $article
		 */
		$article = new QuarkModel(new Article());

		return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
			'article' => $article
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
		 * @var QuarkModel|Article $article
		 */
		$article = new QuarkModel(new Article());

		unset(
			$request->id,
			$request->user_created,
			$request->user_updated,
			$request->date_created,
			$request->date_updated,
			$request->ratio_user_direct_value,
			$request->ratio_user_direct_count,
			$request->ratio_user_prove_value,
			$request->ratio_user_prove_count,
			$request->ratio_ai_value,
			$request->origin
		);
		$article->PopulateWith($request->Data());

		if (!$article->Create())
			return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
				'article' => $article
			));

		return QuarkDTO::ForRedirect('/article/' . $article->id . '?act=created');
	}
}