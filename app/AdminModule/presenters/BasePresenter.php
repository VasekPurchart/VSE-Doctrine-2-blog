<?php

namespace AdminModule;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

	public function startup()
	{
		parent::startup();
		$this->authorize();
	}

	protected function authorize()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Auth:');
		}
	}

}
