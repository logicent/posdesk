<?php
use Orm\Model_Soft;

class Model_User_Metadata extends Model_Soft
{
    protected static $_properties = array(
        'id',				// primary key
        'parent_id',		// owner
        'key',				// attribute column
        'value',			// value column
        'user_id',			// foreign key
		'deleted_at',
    );

    protected static $_table_name = 'users_metadata';
}
