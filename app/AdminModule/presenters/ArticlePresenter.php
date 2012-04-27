<?php

namespace AdminModule;

use Doctrine\ORM\EntityManager;

use MyBlog\Article;

use Nette\Application\UI\Form;

class ArticlePresenter extends \AdminModule\BasePresenter
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager;

	function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function renderDefault()
	{
		$this->template->articles = $this->entityManager->getRepository('MyBlog\Article')->findAll();
	}

	protected function createComponentArticleForm()
	{
		$form = new Form();

		$form->addText('title', 'Title');
		$form->addTextArea('content', 'Content');

		$form->addSubmit('save', 'Save');

		$form->onSuccess[] = callback($this, 'submitArticleForm');

		return $form;
	}

	public function submitArticleForm(Form $form)
	{
		$id = $this->getParam('id');
		$values = $form->getValues();
		if ($id !== NULL) {
			// edit
			$article = $this->entityManager->find('MyBlog\Article', (int) $id);
			if (!$article) throw new \Nette\Application\BadRequestException();
			$article->setTitle($values['title']);
			$article->setContent($values['content']);
			$this->entityManager->flush();
		} else {
			// create
			$article = new Article();
			$article->setTitle($values['title']);
			$article->setContent($values['content']);
			$article->setAuthor($this->entityManager->find('MyBlog\Author', $this->getUser()->getId()));
			$this->entityManager->persist($article);
			$this->entityManager->flush();
		}
		$this->redirect('default');
	}

	public function actionEdit($id)
	{
		$article = $this->entityManager->find('MyBlog\Article', (int) $id);
		if (!$article) throw new \Nette\Application\BadRequestException();
		$this['articleForm']->setDefaults(array(
			'title' => $article->getTitle(),
			'content' => $article->getContent(),
		));
	}

}
