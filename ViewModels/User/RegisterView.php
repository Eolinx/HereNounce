<?php
namespace ViewModels\User;

use Quark\IQuarkViewResource;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class RegisterView
 *
 * @package ViewModels\User
 */
class RegisterView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'User/Register';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/user/register.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/user/register.js');
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
		return $this->CurrentLocalizationOf('view.title.user.register');
	}
}