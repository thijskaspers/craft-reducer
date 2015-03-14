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

}
