<?php
namespace ViewModels\Admin\User;

use Quark\IQuarkViewResource;

use ViewModels\AdminViewBehavior;
use ViewModels\IAdminView;

/**
 * Class CreateView
 *
 * @package ViewModels\Admin\User
 */
class CreateView implements IAdminView {
	use AdminViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/User/Create';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/admin/user/create.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/admin/user/create.js');
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
		return $this->CurrentLocalizationOf('view.title.admin.user.create');
	}

	/**
	 * @return string
	 */
	public function AdminSection () {
		return self::SECTION_USERS;
	}
}