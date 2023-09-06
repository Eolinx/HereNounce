<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

/**
 * Class ErrorNotFoundView
 *
 * @package ViewModels
 */
class ErrorNotFoundView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'ErrorNotFound';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/error-notFound.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/error-notFound.js');
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
		return $this->CurrentLocalizationOf('view.title.error_notFound');
	}

	/**
	 * @return string
	 */
	public function Section () {
		return self::SECTION_HOME;
	}
}