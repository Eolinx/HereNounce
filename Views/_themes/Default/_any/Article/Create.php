<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Article $article
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\Article;

use ViewModels\Article\CreateView;
?>
<form class="quark-container" id="app-article-create" action="/article/create" method="POST">
	<div class="quark-column">
		<div class="quark-container">
			<div class="quark-column">
				<h1>Create article</h1>
				Fill in the fields below to create a new article
			</div>
		</div>
		<div class="quark-container form-group" id="app-article-create-main">
			<div class="quark-column">
				<?php
				echo '',
					$this->Input($article, 'title', 'article.title', true),
					$this->Textarea($article, 'content', 'article.content', true),
					$this->File($article, 'cover', 'article.cover', true);
				?>
			</div>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<?php echo $this->Signature(); ?>
				<button class="quark-button" type="submit">Create</button>
			</div>
		</div>
	</div>
</form>