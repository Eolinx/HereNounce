<?php
namespace Services\Article;

use Models\Article;
use Models\ArticleComment;
use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;

use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Article\IndexView;
use ViewModels\ErrorNotFoundView;
use ViewModels\LayoutView;

/**
 * Class IndexService
 *
 * @package Services\Article
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableService {
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
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(1));

		if ($article == null)
			return QuarkView::InLayout(new ErrorNotFoundView(), new LayoutView());

		/**
		 * @var QuarkCollection|ArticleComment[] $comments
		 */
		$comments = $article->Comments();

		return QuarkView::InLayout(new IndexView(), new LayoutView(), array(
			'article' => $article,
			'comments' => $comments,
			'act' => $request->act
		));
	}
}