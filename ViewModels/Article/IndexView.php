<?php
namespace ViewModels\Article;

use Quark\IQuarkViewResource;

use Quark\QuarkModel;

use Models\Article;

use ViewModels\IView;
use ViewModels\ViewBehavior;

/**
 * Class IndexView
 *
 * @property QuarkModel|Article $article
 *
 * @package ViewModels\Article
 */
class IndexView implements IView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Article/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/article/index.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/article/index.js');
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
		return $this->TemplatedCurrentLocalizationOf('view.title.article.index', array(
			'article' => $this->article,
			'article_title' => $this->article->title->Current()
		));
	}

	/**
	 * @return string
	 */
	public function Side () {
		return $this->Nested(new SideView(), array('article' => $this->article))->Compile();
	}
}