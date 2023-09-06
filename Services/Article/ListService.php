<?php
namespace Services\Article;

use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;

use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\Article;

use ViewModels\Article\ListView;
use ViewModels\LayoutView;

/**
 * Class ListService
 *
 * @package Services\Article
 */
class ListService implements IQuarkGetService, IQuarkAuthorizableService {
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
		$page = (int)$request->URI()->Route(2);
		if ($page < 1) $page = 1;

		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::FindByPage(new Article(), $page, array(), array(
			QuarkModel::OPTION_SORT => array('date_created' => -1)
		));

		return QuarkView::InLayout(new ListView(), new LayoutView(), array(
			'articles' => $articles,
			'page' => $page
		));
	}
}