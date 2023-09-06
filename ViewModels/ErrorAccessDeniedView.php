<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

/**
 * Class ErrorAccessDeniedView
 *
 * @package ViewModels
 */
class ErrorAccessDeniedView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'ErrorAccessDenied';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/error-accessDenied.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/error-accessDenied.js');
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
		return $this->CurrentLocalizationOf('view.title.error_accessDenied');
	}

	/**
	 * @return string
	 */
	public function Section () {
		return self::SECTION_HOME;
	}
}