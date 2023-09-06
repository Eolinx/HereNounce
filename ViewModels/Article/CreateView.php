<?php
namespace ViewModels\Article;

use Quark\IQuarkViewResource;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class CreateView
 *
 * @package ViewModels\Article
 */
class CreateView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Article/Create';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/article/create.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/article/create.js');
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
		return $this->CurrentLocalizationOf('view.title.article.create');
	}
}