<?php
namespace Craft;

class Reducer_SettingsRecord extends BaseRecord
{
	public function getTableName()
	{
		return 'reducer_settings';
	}

	protected function defineAttributes()
	{
		return array(
			'maxSize'  => array(AttributeType::Number, 'column' => ColumnType::Int),
			'quality'  => array(AttributeType::Number, 'column' => ColumnType::TinyInt),
			'enabled'  => array(AttributeType::Bool, 'column' => ColumnType::TinyInt, 'default' => 0),
		);
	}

	public function defineRelations()
	{
		return array(
			'source' => array(static::BELONGS_TO, 'AssetSourceRecord', 'onDelete' => static::CASCADE, 'required' => false),
		);
	}
}
