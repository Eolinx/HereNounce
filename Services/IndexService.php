<?php
namespace Services;

use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;

use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\Article;

use ViewModels\IndexView;
use ViewModels\LayoutView;

/**
 * Class IndexService
 *
 * @package Services
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
		 * @var QuarkModel|Article $top
		 */
		$top = Article::Top();

		/**
		 * @var QuarkCollection|Article[] $featured
		 */
		$featured = Article::Featured();

		/**
		 * @var QuarkCollection|Article[] $feed
		 */
		$feed = QuarkModel::Find(new Article(), array(), array(
			QuarkModel::OPTION_SORT => array(
				'date_created' => -1
			)
		));

		return QuarkView::InLayout(new IndexView(), new LayoutView(), array(
			'top' => $top,
			'featured' => $featured,
			'feed' => $feed
		));
	}
}