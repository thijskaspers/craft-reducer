<?php
namespace Craft;

class ReducerPlugin extends BasePlugin
{

	public $uid;

	public function getName()
	{
		return Craft::t('Reducer');
	}

	public function getVersion()
	{
		return '1.0.2';
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
			$this->uid = $this->reducer($event->params['path'], $event->params['folder']['sourceId']);
		});

		// Store fileId in log after upload -> Event onSaveAsset
		craft()->on('assets.onSaveAsset', function(Event $event) {
			// Is there a known uid for the last upload?
			if($this->uid) {
				// Update log
				craft()->reducer->updateLog($this->uid, $event->params['asset']->id);
			}
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
			return craft()->reducer->reduceImage($filepath, $sourceId);
		}

		return FALSE;
	}
}
