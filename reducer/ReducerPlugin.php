<?php
namespace Craft;

class ReducerPlugin extends BasePlugin
{
	public function getName()
	{
		return Craft::t('Reducer');
	}

	public function getVersion()
	{
		return '1.0';
	}

	public function getDeveloper()
	{
		return 'Pixel&Code';
	}

	public function getDeveloperUrl()
	{
		return 'http://www.pixelcode.nl';
	}

	public function hasCpSection()
	{
		return true;
	}

	public function registerCpRoutes()
	{
		return array(
			'reducer\/(?P<sourceId>\d+)' => 'reducer/_source',
		);
	}

	public function init()
	{
		// Run Reducer -> Event onBeforeUploadAsset
		craft()->on('assets.onBeforeUploadAsset', function(Event $event) {
			$this->reducer($event->params['path'], $event->params['folder']['sourceId']);
		});
	}

	/**
	 * Work the magic
	 */
	public function reducer($filepath, $sourceId)
	{
		// Check if the given filepath contains a valid image
		if(craft()->reducer->isImage($filepath))
		{
			// Reduce the image
			craft()->reducer->reduceImage($filepath, $sourceId);
		}
	}
}
