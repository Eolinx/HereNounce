<?php
namespace ViewModels;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelInLocalizedTheme;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithResources;

/**
 * Interface IView
 *
 * @package ViewModels
 */
interface IView extends IQuarkViewModel, IQuarkViewModelInLocalizedTheme, IQuarkViewModelWithResources, IQuarkViewModelWithComponents {
	/**
	 * @return string
	 */
	public function Title();

	/**
	 * @return string
	 */
	public function Side();
}