<?php
namespace ViewModels;

/**
 * Interface IAdminView
 *
 * @package ViewModels
 */
interface IAdminView extends IView {
	const SECTION_DASHBOARD = 'dashboard';
	const SECTION_GAMES = 'games';
	const SECTION_MECHANISMS = 'mechanisms';
	const SECTION_QUESTS = 'quests';
	const SECTION_USERS = 'users';

	/**
	 * @return string
	 */
	public function AdminSection();
}