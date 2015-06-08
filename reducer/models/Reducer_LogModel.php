<?php
namespace Craft;

class Reducer_LogModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'id'  => AttributeType::Number,
			'file'  => array(AttributeType::Number),
			'sizeBefore'  => array(AttributeType::Number),
			'widthBefore'  => array(AttributeType::Number),
			'heightBefore'  => array(AttributeType::Number),
			'sizeAfter'  => array(AttributeType::Number),
			'widthAfter'  => array(AttributeType::Number),
			'heightAfter'  => array(AttributeType::Number),
			'uid'  => array(AttributeType::String)
		);
	}
}
