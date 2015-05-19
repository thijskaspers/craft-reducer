<?php
namespace Craft;

class Reducer_SettingsModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'id'  => AttributeType::Number,
			'sourceId'  => array(AttributeType::Number, 'required' => true),
			'maxSize'  => array(AttributeType::Number, 'required' => true, 'min' => 0),
			'quality'  => array(AttributeType::Number, 'min' => 0, 'max' => 100),
			'enabled'  => array(AttributeType::Bool),
		);
	}
}
