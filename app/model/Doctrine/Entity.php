<?php

namespace MyBlog;

/**
 * @MappedSuperClass
 */
abstract class Entity extends \Nette\Object
{

	/**
	 * @var int
	 *
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;

	function __construct()
	{

	}

	public function getId()
	{
		return $this->id;
	}

}


