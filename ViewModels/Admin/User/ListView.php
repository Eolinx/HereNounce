<?php
namespace ViewModels\Admin\User;

use Quark\IQuarkViewResource;

use ViewModels\AdminViewBehavior;
use ViewModels\IAdminView;

/**
 * Class ListView
 *
 * @package ViewModels\Admin\User
 */
class ListView implements IAdminView {
	use AdminViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/User/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/admin/user/list.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/admin/user/list.js');
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
		return $this->CurrentLocalizationOf('view.title.admin.user.list');
	}

	/**
	 * @return string
	 */
	public function AdminSection () {
		return self::SECTION_USERS;
	}
}