<?php

namespace MyBlog;

use Doctrine\ORM\EntityManager;

use Nette\Security\Identity;

class Authenticator extends \Nette\Object implements \Nette\Security\IAuthenticator
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager;

	function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$result = $this->entityManager->createQuery('SELECT u FROM MyBlog\Author u WHERE u.name = ?1')
					->setParameter(1, $username)
					->getResult();

		if (!$result) {
			throw new \Nette\Security\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}

		$user = $result[0];

		if ($user->getPasswordHash() !== $this->calculateHash($password)) {
			throw new \Nette\Security\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		return new Identity($user->getId());
	}

	public static function calculateHash($password)
	{
		return md5($password . str_repeat('*random salt*', 10));
	}

}
