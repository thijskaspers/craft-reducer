<?php

namespace Craft;

class ReducerService extends BaseApplicationComponent
{

	/**
	 * Check if the given filepath contains a valid image
	 * @param $filepath
	 * @return boolean
	 */
	public function isImage($filepath)
	{
		// Variables
		$extension = IOHelper::getExtension($filepath);
		$filekind = IOHelper::getFileKind($extension);

		if ($filekind == 'image' && ImageHelper::isImageManipulatable($extension))
		{
			// Hooray: Manipulatable image found!
			return true;
		}
		else
		{
			// No image or non-manipulatable
			return false;
		}
	}

	/**
	 * Reduce the image
	 * @param $filepath
	 */
	public function reduceImage($filepath)
	{
		$imagine = new Image;
		$imagine->loadImage($filepath);
		$imagine->scaleAndCrop(200,200,false);
		$imagine->saveAs($filepath);
	}

	/**
	 * Get Craft asset sources
	 */
	public function getAssetSources()
	{
		return craft()->assetSources->getAllSources();
	}

	/**
	 * Get Craft asset source by ID
	 */
	public function getAssetSourceById($sourceId)
	{
		return craft()->assetSources->getSourceById($sourceId);
	}

	/**
	 * Get Reducer settings
	 * @return array
	 */
	public function getSettings()
	{
		// Query
		$settings = craft()->db->createCommand()
		                       ->select('*')
		                       ->from('reducer_settings')
		                       ->queryAll();

		// Set sourceId as key
		foreach($settings as $row) {
			$settingsArray[$row['sourceId']] = $row;
		}

		return $settingsArray;
	}

	/**
	 * Get Reducer settings by source ID
	 * @param integer $id
	 * @return array
	 */
	public function getSettingsBySourceId($id)
	{
		$settings = craft()->db->createCommand()
		                       ->select('*')
		                       ->from('reducer_settings')
		                       ->where('sourceId = :source', array(':source' => $id))
		                       ->queryRow();

		return $settings;
	}

	/**
	 * Save Reducer settings
	 * @param Reducer_SettingsModel $model
	 * @param boolean $update (TRUE = update, FALSE = create)
	 * @return boolean
	 */
	public function saveSettings(Reducer_SettingsModel $model, $update)
	{

		// Should we update an existing record or create a new one?
		if ($update)
		{
			// Find the record by primary key
			$record = Reducer_SettingsRecord::model()->findByPk($model->getAttribute('id'));
		}
		else
		{
			// Create a new record
			$record = new Reducer_SettingsRecord();
			$record->setAttribute('sourceId', $model->getAttribute('source'));
		}

		// Fill record attributes with (new) model attributes
		$record->setAttributes($model->getAttributes());

		if ($record->save())
		{
			return true;
		}
		else
		{
			$model->addErrors($record->getErrors());
			return false;
		}

	}

}
