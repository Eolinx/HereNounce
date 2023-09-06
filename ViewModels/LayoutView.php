<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

use Quark\QuarkView;

use Quark\ViewResources\FontAwesome\FontAwesome;
use Quark\ViewResources\Google\GoogleFont;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\Quark\QuarkControls\QuarkControls;

/**
 * Class LayoutView
 *
 * @package ViewModels
 */
class LayoutView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Layout';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/layout.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/layout.js');
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new GoogleFont(GoogleFont::FAMILY_OPEN_SANS, GoogleFont::SizeRange()),
			new GoogleFont('Staatliches', GoogleFont::SizeRange()),
			new FontAwesome(),
			new jQueryCore(),
			new QuarkControls()
		);
	}

	/**
	 * @return string
	 */
	public function Title () {
		/**
		 * @var QuarkView|IView $child
		 */
		$child = $this->Child();

		return $child->Title();
	}
}