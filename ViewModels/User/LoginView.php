<?php
namespace ViewModels\User;

use Quark\IQuarkViewResource;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class LoginView
 *
 * @package ViewModels\User
 */
class LoginView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'User/Login';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/user/login.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/user/login.js');
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
		return $this->CurrentLocalizationOf('view.title.user.login');
	}

	/**
	 * @return string
	 */
	public function Section () {
		// TODO: Implement Section() method.
	}
}