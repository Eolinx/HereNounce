<?php
namespace ViewModels\Admin;

use Quark\IQuarkViewResource;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class SideView
 *
 * @package ViewModels\Admin
 */
class SideView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Side';
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