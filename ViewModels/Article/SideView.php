<?php
namespace ViewModels\Article;

use Quark\IQuarkViewResource;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class SideView
 *
 * @package ViewModels\Article
 */
class SideView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Article/Side';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		// TODO: Implement ViewStylesheet() method.
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		// TODO: Implement ViewController() method.
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
		// TODO: Implement Title() method.
	}
}