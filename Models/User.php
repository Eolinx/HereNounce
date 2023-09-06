<?php
namespace Models;

use Quark\IQuarkAuthorizableModel;
use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeSave;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModelWithRuntimeFields;

use Quark\QuarkDate;
use Quark\QuarkField;
use Quark\QuarkKeyValuePair;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

use Quark\Extensions\CDN\CDNResource;

/**
 * Class User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $name
 * @property CDNResource $avatar
 * @property QuarkDate $date_created
 * @property QuarkDate $date_updated
 * @property QuarkDate $date_signed
 *
 * @property bool $password_change
 * @property string $password_clear
 * @property string $password_confirm
 *
 * @package Models
 */
class User implements IQuarkModel, IQuarkStrongModelWithRuntimeFields, IQuarkModelWithDataProvider, IQuarkModelWithBeforeCreate, IQuarkModelWithBeforeSave, IQuarkAuthorizableModel, IQuarkLinkedModel, IQuarkNullableModel, ISelectableModel {
	const ROLE_ADMIN = 'admin';
	const ROLE_AUTHOR = 'author';
	const ROLE_USER = 'user';

	use QuarkModelBehavior;

	/**
	 * @return string
	 */
	public function DataProvider () {
		return APP_DB;
	}

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'email' => '',
			'password' => '',
			'role' => self::ROLE_USER,
			'local_admin' => false,
			'name' => '',
			'avatar' => new CDNResource(APP_CDN, __DIR__ . '/../Views/_themes/Default/static/img/placeholder-user-avatar.png'),
			'date_created' => QuarkDate::NowUTC(),
			'date_updated' => QuarkDate::NowUTC(),
			'date_signed' => QuarkDate::NowUTC()
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		return array(
			$this->LocalizedAssert($this->name != '', 'validation.user.name', 'name'),
			$this->LocalizedAssert(QuarkField::Email($this->email), 'validation.user.email', 'email'),
			$this->LocalizedAssert($this->password_change ? strlen($this->password_clear) >= 8 : true, 'validation.user.password_length', 'password'),
			$this->LocalizedAssert($this->password_change ? $this->password_clear == $this->password_confirm : true, 'validation.user.password_match', 'password_confirm')
		);
	}

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'password_change' => false,
			'password_clear' => '',
			'password_confirm' => ''
		);
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new User(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (int)$this->id;
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeCreate ($options) {
		$this->_passwordChange();
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeSave ($options) {
		$this->date_updated = QuarkDate::NowUTC();

		$this->_passwordChange();
	}

	/**
	 * @param string $name
	 * @param $session
	 *
	 * @return mixed
	 */
	public function Session ($name, $session) {
		return QuarkModel::FindOneById(new User(), $session->id);
	}

	/**
	 * @param string $name
	 * @param $criteria
	 * @param int $lifetime (seconds)
	 *
	 * @return QuarkModel|IQuarkAuthorizableModel
	 */
	public function Login ($name, $criteria, $lifetime) {
		$user = QuarkModel::FindOne(new User(), array(
			'email' => $criteria->email,
			'password' => self::Password($criteria->password)
		));

		if ($user == null) return null;

		$user->date_signed = QuarkDate::GMTNow();

		return $user->Save() ? $user : null;
	}

	/**
	 * @param string $name
	 * @param QuarkKeyValuePair $id
	 *
	 * @return bool
	 */
	public function Logout ($name, QuarkKeyValuePair $id) {
		// TODO: Implement Logout() method.
	}

	public function Avatar () {
		// https://i.pravatar.cc/150?u=$user->Avatar()
		return hash('sha256', $this->email . sha1($this->email) . 'HereNounce');
	}

	/**
	 * @param string $password = ''
	 *
	 * @return string
	 */
	public static function Password ($password = '') {
		return hash('sha256', $password . sha1($password) . 'HereNounce');
	}

	/**
	 * @param QuarkModel|User $user = null
	 * @param string[] $roles = []
	 *
	 * @return bool
	 */
	public static function HasRole (QuarkModel $user = null, $roles = []) {
		return $user != null && in_array($user->role, $roles);
	}

	/**
	 * Enable password checks
	 */
	private function _passwordChange () {
		if (!$this->password_change) return;

		$this->password_clear = $this->password;
		$this->password = self::Password($this->password);
	}

	/**
	 * @return QuarkKeyValuePair
	 */
	public function SelectControlOption () {
		return new QuarkKeyValuePair($this->id, $this->name);
	}
}