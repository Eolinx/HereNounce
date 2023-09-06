<?php
namespace ViewModels\Article;

use Quark\IQuarkViewResource;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class ListView
 *
 * @property int $page
 *
 * @package ViewModels\Article
 */
class ListView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Article/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
	return $this->ThemeResource('/static/article/list.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/article/list.js');
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		// TODO: Implement ViewResources() method.
	}

	/**
	 * @return string
	 */
	public function Title () {
		return $this->TemplatedCurrentLocalizationOf('view.title.article.list', array(
			'page' => $this->page
		));
	}
}