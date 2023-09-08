<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeSave;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModelWithRuntimeFields;

use Quark\QuarkDate;
use Quark\QuarkLazyLink;
use Quark\QuarkLocalizedString;
use Quark\QuarkModelBehavior;

/**
 * Class ArticleComment
 *
 * @property int $id
 * @property QuarkLocalizedString $comment
 * @property string[] $links
 * @property QuarkLazyLink|Article $article
 * @property int $ratio_article
 * @property int $ratio_comment
 * @property QuarkLazyLink|User $user_created
 * @property QuarkLazyLink|User $user_updated
 * @property QuarkDate $date_created
 * @property QuarkDate $date_updated
 *
 * @property string article_ratio_action
 *
 * @package Models
 */
class ArticleComment implements IQuarkModel, IQuarkStrongModelWithRuntimeFields, IQuarkModelWithDataProvider, IQuarkModelWithBeforeCreate, IQuarkModelWithBeforeSave, IQuarkNullableModel {
	const ARTICLE_RATIO_ACTION_UP = 'up';
	const ARTICLE_RATIO_ACTION_DOWN = 'down';
	const ARTICLE_RATIO_ACTION_ = '';

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
			'comment' => new QuarkLocalizedString(),
			'links' => array(),
			'article' => $this->LazyLink(new Article()),
			'ratio_article' => 0,
			'ratio_comment' => 0,
			// 'ai_created' => ...
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
			$this->LocalizedAssert($this->comment->Assert(function ($value) {}, function () { return false; }), 'validation.article_comment.comment', 'comment'),
			$this->LocalizedAssert(in_array($this->article_ratio_action, $this->Constants('#^ARTICLE_RATIO_ACTION_#is')), 'validation.model.article_comment.article_ratio_action', 'article_ratio_action')
		);
	}

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'article_ratio_action' => ''
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
	 * @return int
	 */
	public function ArticleRatioModifier () {
		if ($this->article_ratio_action == self::ARTICLE_RATIO_ACTION_UP) return 1;
		if ($this->article_ratio_action == self::ARTICLE_RATIO_ACTION_DOWN) return -1;

		return 0;
	}
}