<?php
namespace Craft;

class Reducer_SettingsController extends BaseController
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->requirePostRequest();
	}

	/**
	 * Save settings
	 */
	public function actionSave()
	{
		// Get postdata
		$postData = craft()->request()->getPost('settings');

		if(craft()->reducer->saveSettings())
		{
			craft()->userSession->setNotice(Craft::t('Settings saved.'));
		}
	}
}
