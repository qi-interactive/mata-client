<?php

/*
 * This file is part of the mata project.
 *
 * (c) mata project <http://github.com/mata/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use yii\db\Schema;
use yii\db\Migration;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class m150317_174512 extends Migration {

	public function safeUp() {
		$this->createTable('{{%mata_client}}', [
			'Id'                   => Schema::TYPE_PK,
			'Name'             => Schema::TYPE_TEXT . ' NOT NULL',
			'URI'	=> Schema::TYPE_STRING . '(255) NOT NULL',
			'Grouping' => Schema::TYPE_STRING . '(255) NOT NULL'
			]);

		$this->createTable('{{%mata_clientitem}}', [
			'ClientId'      => Schema::TYPE_INTEGER . ' NOT NULL',
			'DocumentId'   => Schema::TYPE_STRING . '(64) NOT NULL',
			'Order' =>  Schema::TYPE_INTEGER . ' NOT NULL'
			]);

		$this->addForeignKey('fk_mataclientitem', '{{%mata_clientitem}}', 'ClientId', '{{%mata_client}}', 'Id', 'CASCADE', 'RESTRICT');

	}

	public function safeDown() {
		$this->dropTable('{{%mata_clientitem}}');
		$this->dropTable('{{%mata_client}}');
	}
	
}