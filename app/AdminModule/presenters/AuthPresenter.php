<?php

namespace AdminModule;

use Nette\Application\UI\Form;

class AuthPresenter extends \AdminModule\BasePresenter
{

	protected function authorize()
	{
		// do nothing
	}

	protected function createComponentAuthForm()
	{
		$form = new Form();
		$form->addText('username', 'Username');
		$form->addPassword('password', 'Password');

		$form->addSubmit('send', 'Login');

		$form->onSuccess[] = callback($this, 'submitAuthForm');
		return $form;
	}

	public function submitAuthForm(Form $form)
	{
		try {
			$values = $form->getValues();
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Article:');
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}

	public function actionLogout()
	{
		$this->getUser()->logout();
		$this->redirect('default');
	}

}
