<?php
namespace Craft;

class Reducer_SettingsModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'sourceId'  => array(AttributeType::Number),
			'maxSize'  => array(AttributeType::Number),
			'quality'  => array(AttributeType::Number),
			'enabled'  => array(AttributeType::Bool),
		);
	}
}
