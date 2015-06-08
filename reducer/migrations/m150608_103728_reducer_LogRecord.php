<?php
namespace Craft;

class m150608_103728_reducer_LogRecord extends BaseMigration
{
	/**
	 * Create Reducer_LogRecord table
	 *
	 * @return bool
	 */
	public function safeUp()
	{
		// Create the craft_reducer_log table
		craft()->db->createCommand()->createTable('reducer_log', array(
			'fileId'       => array('column' => 'integer', 'required' => false),
			'sizeBefore'   => array('maxLength' => 11, 'decimals' => 0, 'column' => 'integer', 'unsigned' => false),
			'widthBefore'  => array('maxLength' => 11, 'decimals' => 0, 'column' => 'integer', 'unsigned' => false),
			'heightBefore' => array('maxLength' => 11, 'decimals' => 0, 'column' => 'integer', 'unsigned' => false),
			'sizeAfter'    => array('maxLength' => 11, 'decimals' => 0, 'column' => 'integer', 'unsigned' => false),
			'widthAfter'   => array('maxLength' => 11, 'decimals' => 0, 'column' => 'integer', 'unsigned' => false),
			'heightAfter'  => array('maxLength' => 11, 'decimals' => 0, 'column' => 'integer', 'unsigned' => false),
		), null, true);

		// Add foreign keys to craft_reducer_log
		craft()->db->createCommand()->addForeignKey('reducer_log', 'fileId', 'assetfiles', 'id', 'CASCADE', null);
	}
}
