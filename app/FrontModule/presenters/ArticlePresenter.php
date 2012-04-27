<?php

namespace FrontModule;

use Doctrine\ORM\EntityManager;

class ArticlePresenter extends \FrontModule\BasePresenter
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

}
