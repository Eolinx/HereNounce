<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

/**
 * Class ErrorCSRFView
 *
 * @package ViewModels
 */
class ErrorCSRFView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'ErrorCSRF';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/error-csrf.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/error-csrf.js');
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
		return $this->CurrentLocalizationOf('view.title.error_csrf');
	}

	/**
	 * @return string
	 */
	public function Section () {
		return self::SECTION_HOME;
	}
}