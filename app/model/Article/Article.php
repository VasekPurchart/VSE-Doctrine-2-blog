<?php

namespace MyBlog;

use DateTime;

/**
 * @Entity
 */
class Article extends \MyBlog\Entity
{

	/**
	 * @var string
	 *
	 * @Column(length=100)
	 */
	private $title;

	/**
	 * @var DateTime
	 *
	 * @Column(type="date")
	 */
	private $date;

	/**
	 * @var string
	 *
	 * @Column(type="text")
	 */
	private $content;

	/**
	 * @var MyBlog\Author
	 *
	 * @ManyToOne(targetEntity="MyBlog\Author")
	 */
	private $author;

	function __construct()
	{
		$this->date = new DateTime();
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function setAuthor(Author $author)
	{
		$this->author = $author;
	}

}

