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
		$postData = craft()->request->getPost();

		// Update an existing entry or create a new one?
		if (craft()->reducer->getSettingsBySourceId($postData['sourceId']))
		{
			// Update
			$update = TRUE;
			$model = Reducer_SettingsModel::populateModel(craft()->reducer->getSettingsBySourceId($postData['sourceId']));
		}
		else
		{
			// Create
			$update = FALSE;
			$model = new Reducer_SettingsModel();
		}

		// Insert model data
		$model->source = $postData['sourceId'];
		$model->maxSize = $postData['maxSize'];
		$model->quality = $postData['quality'];
		$model->enabled = $postData['enabled'];

		// Did we pass validation?
		if($model->validate())
		{
			if (craft()->reducer->saveSettings($model, $update))
			{
				// Success!
				craft()->userSession->setNotice(Craft::t('Settings saved.'));
				return $this->redirectToPostedUrl();
			}
			else
			{
				// Saving the entry failed..
				craft()->userSession->setError(Craft::t("Woops, unfortunately Reducer couldn't save the settings."));
				return $this->redirectToPostedUrl();
			}
		}
		else
		{
			// Validation failed
			craft()->userSession->setError(Craft::t('Incorrect data given, please check the form and try again!'));
			craft()->urlManager->setRouteVariables(array(
				'settings' => $postData,
				'errors' => $model->getErrors()
			));
		}

	}
}
