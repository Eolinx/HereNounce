<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeSave;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModel;

use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkLazyLink;
use Quark\QuarkLocalizedString;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

use Quark\Extensions\CDN\CDNResource;
use Quark\QuarkSQL;

/**
 * Class Article
 *
 * @property int $id
 * @property QuarkLocalizedString $title
 * @property QuarkLocalizedString $content
 * @property CDNResource $cover
 * @property int $ratio_user
 * @property int $ratio_ai
 * @property string $origin
 * @property QuarkLazyLink|User $user_created
 * @property QuarkLazyLink|User $user_updated
 * @property QuarkDate $date_created
 * @property QuarkDate $date_updated
 *
 * @package Models
 */
class Article implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeCreate, IQuarkModelWithBeforeSave, IQuarkLinkedModel, IQuarkNullableModel {
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
			'title' => new QuarkLocalizedString(),
			'content' => new QuarkLocalizedString(),
			'cover' => new CDNResource(APP_CDN, __DIR__ . '/../Views/_themes/Default/static/img/placeholder-article-cover.jpg'),
			'ratio_user' => 0,
			'ratio_ai' => 0,
			/*'ratio_user_direct_value' => 0.0,
			'ratio_user_direct_count' => 0,
			'ratio_user_prove_value' => 0.0,
			'ratio_user_prove_count' => 0,
			'ratio_ai_value' => 0.0,*/
			'origin' => '',
			'user_created' => $this->LazyLink(new User()),
			'user_updated' => $this->LazyLink(new User()),
			'date_created' => QuarkDate::NowUTC(),
			'date_updated' => QuarkDate::NowUTC()
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		return array(
			$this->LocalizedAssert($this->title->Assert(function ($value) {}, function () { return false; }), 'validation.article.title', 'title'),
			$this->LocalizedAssert($this->content->Assert(function ($value) {}, function () { return false; }), 'validation.article.content', 'content')
		);
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeCreate ($options) {
		$this->user_created = $this->User();
		$this->user_updated = $this->User();
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeSave ($options) {
		$this->date_updated = QuarkDate::NowUTC();

		$this->user_updated = $this->User();
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new Article(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (int)$this->id;
	}

	/**
	 * @param int $page = 0
	 *
	 * @return QuarkCollection|ArticleComment[]
	 */
	public function Comments ($page = 0) {
		return QuarkModel::FindByPage(
			new ArticleComment(),
			$page,
			array(
				'article' => $this->id
			),
			array(
				QuarkModel::OPTION_SORT => array(
					'date_created' => -1
				)
			)
		);
	}

	/**
	 * @param QuarkModel|User $user = null
	 *
	 * @return bool
	 */
	public function CanBeEditedBy (QuarkModel $user = null) {
		return User::HasRole($user, array(User::ROLE_ADMIN)) || (
			User::HasRole($user, array(User::ROLE_AUTHOR)) &&
			$this->user_created->value == $user->id
		);
	}

	/**
	 * @return string
	 */
	public function Summary () {
		$content = $this->content->Current();

		return \mb_strlen($content) > 200 ? \mb_substr($content, 0, 200) . '...' : $content;
	}

	/**
	 * @return int
	 */
	public function Ratio () {
		return $this->ratio_user + $this->ratio_ai;
	}

	/**
	 * @param QuarkModel|User $user = null
	 *
	 * @return bool
	 */
	public function VotedBy (QuarkModel $user = null) {
		if ($user == null) return false;

		return QuarkModel::Exists(new ArticleComment(), array(
			'article' => $this->id,
			'user_created' => $user->id,
			'ratio_article' => array('$ne' => 0)
		));
	}

	/**
	 * @param QuarkDate $edge = null
	 *
	 * @return QuarkModel|Article
	 */
	public static function Top (QuarkDate $edge = null) {
		if ($edge == null)
			$edge = QuarkDate::NowUTC()->Offset('-1 day', true);

		return QuarkModel::FindOne(
			new Article(),
			array(
				'date_created' => array(
					'$gte' => $edge->Format('Y-m-d H:i:s')
				)
			),
			array(
				//QuarkSQL::OPTION_ALIAS => 'a',
				QuarkModel::OPTION_SORT => array(
					'ratio_user' => -1
				)
			)
		);
	}

	/**
	 * @param QuarkDate $edge = null
	 *
	 * @return QuarkCollection|Article[]
	 */
	public static function Featured (QuarkDate $edge = null) {
		if ($edge == null)
			$edge = QuarkDate::NowUTC()->Offset('-1 week', true);

		return QuarkModel::Find(
			new Article(),
			array(
				'date_created' => array(
					'$gte' => $edge->Format('Y-m-d H:i:s')
				)
			),
			array(
				QuarkModel::OPTION_LIMIT => 3
			)
		);
	}
}