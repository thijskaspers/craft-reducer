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

	public function init()
	{
		craft()->on('assets.onBeforeUploadAsset', function(Event $event) {
			$this->reducer($event->params['path']);
		});
	}

	/*
	 * Work the magic
	 */
	public function reducer($filepath)
	{
		// Check if the given filepath contains a valid image
		if(craft()->reducer->isImage($filepath))
		{
			// Reduce the image
			craft()->reducer->reduceImage($filepath);
		}
	}
}
