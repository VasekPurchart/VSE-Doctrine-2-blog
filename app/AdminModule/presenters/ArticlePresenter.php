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
		} else {
			// create
			$article = new Article();
			$article->setTitle($values['title']);
			$article->setContent($values['content']);
			$this->entityManager->persist($article);
			$this->entityManager->flush();
		}
		$this->redirect('default');
	}

	public function actionEdit($id)
	{
		$this['articleForm']->setDefaults(array(
			'title' => 'Začínáme s Doctrine 2',
			'content' => 'Hned na úvod je potřeba si říct, co můžeme od Doctrine 2 očekávat a co už naopak tento systém neřeší.
Doctrine 2 je prostě a jednoduše ORM (Object-Relational Mapping).
Zajišťuje tedy mapování objektů na relační databázi. Nic víc a nic méně.

Více se dočtete v <a href="http://www.zdrojak.cz/serialy/doctrine-2/">seriálu o Doctrine na Zdrojáku</a>.',
		));
	}

}
