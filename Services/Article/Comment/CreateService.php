<?php
namespace Services\Article\Comment;

use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkSignedPostService;

use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\Article;
use Models\ArticleComment;

use ViewModels\ErrorAccessDeniedView;
use ViewModels\ErrorCSRFView;
use ViewModels\ErrorNotFoundView;
use ViewModels\LayoutView;

/**
 * Class CreateService
 *
 * @package Services\Article\Comment
 */
class CreateService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedPostService {
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
		return $session->User() != null;
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
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(3));

		if ($article == null)
			return QuarkView::InLayout(new ErrorNotFoundView(), new LayoutView());

		/**
		 * @var QuarkModel|User $user
		 */
		$user = $session->User();
		$voted = $article->VotedBy($user);

		/**
		 * @var QuarkModel|ArticleComment $comment
		 */
		$comment = new QuarkModel(new ArticleComment());

		unset(
			$request->article,
			$request->ratio_article,
			$request->ratio_comment,
			$request->user_created,
			$request->user_updated,
			$request->date_created,
			$request->date_updated
		);
		$comment->PopulateWith($request->Data());
		$comment->article = $article;

		$modifier = $comment->ArticleRatioModifier();
		$comment->ratio_article = $modifier;

		if (!$comment->Create())
			return QuarkDTO::ForRedirect('/article/' . $article->id . '?act=comment_failure');

		if (!$voted) {
			$article->ratio_user += $modifier;

			if (!$article->Save())
				return QuarkDTO::ForRedirect('/article/' . $article->id . '?act=comment_failure');
		}

		return QuarkDTO::ForRedirect('/article/' . $article->id . '?act=comment_created');
	}
}