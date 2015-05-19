<?php
namespace Craft;

class ReducerVariable
{
	public function getSettings()
	{
		return craft()->reducer->getSettings();
	}

	public function getSettingsBySourceId($sourceId)
	{
		return craft()->reducer->getSettingsBySourceId($sourceId);
	}

	public function getAssetSources()
	{
		return craft()->reducer->getAssetSources();
	}

	public function getAssetSourceById($sourceId)
	{
		return craft()->reducer->getAssetSourceById($sourceId);
	}
}
