<?php
namespace ViewModels\Admin\User;

use Quark\IQuarkViewResource;

use Quark\QuarkModel;

use Models\User;

use ViewModels\AdminViewBehavior;
use ViewModels\IAdminView;

/**
 * Class UpdateView
 *
 * @property QuarkModel|User $user
 *
 * @package ViewModels\Admin\User
 */
class UpdateView implements IAdminView {
	use AdminViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/User/Update';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/admin/user/update.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/admin/user/update.js');
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
		return $this->TemplatedCurrentLocalizationOf('view.title.admin.user.update', array(
			'user' => $this->user
		));
	}

	/**
	 * @return string
	 */
	public function AdminSection () {
		return self::SECTION_USERS;
	}
}