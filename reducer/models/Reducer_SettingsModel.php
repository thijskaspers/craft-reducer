<?php
namespace Craft;

class Reducer_SettingsModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'id'  => AttributeType::Number,
			'source'  => array(AttributeType::Number, 'required' => true),
			'maxSize'  => array(AttributeType::Number, 'label' => Craft::t('Max. size'), 'required' => true, 'min' => 0),
			'quality'  => array(AttributeType::Number, 'label' => Craft::t('Quality'), 'min' => 0, 'max' => 100),
			'enabled'  => array(AttributeType::Bool, 'label' => 'Enabled'),
		);
	}
}
