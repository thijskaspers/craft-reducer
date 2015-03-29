<?php
namespace Craft;

class ReducerVariable
{
	public function getSettings()
	{
		return craft()->reducer->getSettings();
	}

	public function getAssetSources()
	{
		return craft()->reducer->getAssetSources();
	}
}
