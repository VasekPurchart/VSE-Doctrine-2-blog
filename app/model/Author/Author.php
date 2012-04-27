<?php

namespace MyBlog;

/**
 * @Entity
 */
class Author extends \MyBlog\Entity
{

	/**
	 * @var string
	 *
	 * @Column(length=50)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @Column(length=100)
	 */
	private $passwordHash;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getPasswordHash()
	{
		return $this->passwordHash;
	}

	public function setPasswordHash($passwordHash)
	{
		$this->passwordHash = $passwordHash;
	}

}

