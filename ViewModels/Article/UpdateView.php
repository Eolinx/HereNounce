<?php
namespace ViewModels\Article;

use Quark\IQuarkViewResource;

use Quark\QuarkModel;

use Models\Article;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class UpdateView
 *
 * @property QuarkModel|Article $article
 *
 * @package ViewModels\Article
 */
class UpdateView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Article/Update';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/article/update.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/article/update.js');
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
		return $this->TemplatedCurrentLocalizationOf('view.title.article.update', array(
			'article' => $this->article,
			'article_title' => $this->article->title->Current()
		));
	}
}