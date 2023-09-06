<?php
namespace ViewModels\Admin;

use Quark\IQuarkViewResource;

use ViewModels\IAdminView;
use ViewModels\AdminViewBehavior;

/**
 * Class LoginView
 *
 * @package ViewModels\Admin
 */
class IndexView implements IAdminView {
	use AdminViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/admin/index.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/admin/index.js');
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
		return $this->CurrentLocalizationOf('view.title.admin.index');
	}

	/**
	 * @return string
	 */
	public function AdminSection () {
		return self::SECTION_DASHBOARD;
	}
}