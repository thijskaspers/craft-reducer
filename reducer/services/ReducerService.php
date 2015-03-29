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
	 * Get asset sources
	 * @return array
	 */
	public function getAssetSources()
	{
		return craft()->assetSources->getAllSources();
	}

	/**
	 * Get Reducer settings
	 * @return array
	 */
	public function getSettings()
	{
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
	 * Get Reducer settings
	 * @return array
	 */
	public function getSettingsBySourceId($id)
	{
		$settings = craft()->db->createCommand()
			->select('*')
			->from('reducer_settings')
			->where('sourceId = :source', array(':source' => $id))
			->queryAll();

		return $settings;
	}

	/**
	 * Save Reducer settings
	 * @return boolean
	 */
	public function saveSettings($data)
	{
		//$settingsrow = Reducer_SettingsModel::populateModel($data);
		return true;
	}

}
