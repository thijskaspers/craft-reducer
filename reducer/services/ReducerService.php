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
	 * @param string $filepath
	 * @param integer $sourceId
	 */
	public function reduceImage($filepath, $sourceId)
	{
		// Get Reducer settings
		$settings = $this->getSettingsBySourceId($sourceId);
		$quality = $settings['quality'] ?: craft()->config->get('defaultImageQuality');

		if ($settings['enabled'])
		{

			// Load image
			$imagine = new Image;
			$imagine->loadImage($filepath);

			// Size/dimensions before
			$fileBefore = array(
				'fileSize' => filesize($filepath),
				'fileWidth' => $imagine->getWidth(),
				'fileHeight' => $imagine->getHeight()
			);

			// Resize image to fit within given settings
			$imagine->scaleToFit($settings['maxSize'], $settings['maxSize'], false);
			$imagine->setQuality($quality);
			$imagine->saveAs($filepath);

			// Size/dimensions after
			clearstatcache(); // Clear php filesize cache
			$fileAfter = array(
				'fileSize' => filesize($filepath),
				'fileWidth' => $imagine->getWidth(),
				'fileHeight' => $imagine->getHeight()
			);

			// Add to log
			$uid = $this->insertLog($fileBefore, $fileAfter);

			// Return Unique ID
			return $uid;

		}

		return FALSE;
	}

	/**
	 * Log results into database
	 */
	public function insertLog($fileBefore, $fileAfter)
	{
		// Create log record
		$record = new Reducer_LogRecord();
		$record->setAttribute('sizeBefore', $fileBefore['fileSize']);
		$record->setAttribute('widthBefore', $fileBefore['fileWidth']);
		$record->setAttribute('heightBefore', $fileBefore['fileHeight']);
		$record->setAttribute('sizeAfter', $fileAfter['fileSize']);
		$record->setAttribute('widthAfter', $fileAfter['fileWidth']);
		$record->setAttribute('heightAfter', $fileAfter['fileHeight']);

		// Save to DB
		$record->save();

		// Get Unique ID
		$uid = $record->getAttribute('uid');

		return $uid;
	}

	/**
	 * Update Log (add fileId to row with matching uid)
	 */
	public function updateLog($uid, $fileId)
	{
		$record = Reducer_LogRecord::model()->findByAttributes(array('uid' => $uid));
		$record->setAttribute('fileId', $fileId);

		// Save to DB
		$record->save();
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
		$settingsArray = array();
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
