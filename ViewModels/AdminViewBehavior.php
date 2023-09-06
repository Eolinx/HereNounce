<?php
namespace ViewModels;

use ViewModels\Admin\SideView;

/**
 * Trait AdminViewBehavior
 *
 * @package ViewModels
 */
trait AdminViewBehavior {
	use ViewBehavior;

	/**
	 * @return string
	 */
	/*public function Section () {
		return IView::SECTION_ADMIN;
	}*/

	/**
	 * @return string
	 */
	public function Side () {
		return $this->Nested(new SideView())->Compile();
	}
}