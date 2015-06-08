<?php
namespace Craft;

class Reducer_LogRecord extends BaseRecord
{
	public function getTableName()
	{
		return 'reducer_log';
	}

	protected function defineAttributes()
	{
		return array(
			'sizeBefore'  => array(AttributeType::Number, 'column' => ColumnType::Int),
			'widthBefore'  => array(AttributeType::Number, 'column' => ColumnType::Int),
			'heightBefore'  => array(AttributeType::Number, 'column' => ColumnType::Int),
			'sizeAfter'  => array(AttributeType::Number, 'column' => ColumnType::Int),
			'widthAfter'  => array(AttributeType::Number, 'column' => ColumnType::Int),
			'heightAfter'  => array(AttributeType::Number, 'column' => ColumnType::Int)
		);
	}

	public function defineRelations()
	{
		return array(
			'file' => array(static::BELONGS_TO, 'AssetFileRecord', 'onDelete' => static::CASCADE, 'required' => false),
		);
	}
}
