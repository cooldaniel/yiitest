<?php

/**
 * This is the model class for table "task_log".
 *
 * The followings are the available columns in table 'task_log':
 * @property string $id
 * @property string $task_name
 * @property string $task_sn
 * @property string $parent_id
 * @property string $params
 * @property integer $status
 * @property string $message
 * @property string $child_count
 * @property string $child_finished_count
 * @property string $create_time
 * @property string $start_time
 * @property string $end_time
 * @property string $time_used
 */
class TaskLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'task_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('task_name, task_sn', 'length', 'max'=>200),
			array('parent_id', 'length', 'max'=>20),
			array('child_count, child_finished_count, time_used', 'length', 'max'=>10),
			array('params, message, create_time, start_time, end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, task_name, task_sn, parent_id, params, status, message, child_count, child_finished_count, create_time, start_time, end_time, time_used', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'task_name' => 'Task Name',
			'task_sn' => 'Task Sn',
			'parent_id' => 'Parent',
			'params' => 'Params',
			'status' => 'Status',
			'message' => 'Message',
			'child_count' => 'Child Count',
			'child_finished_count' => 'Child Finished Count',
			'create_time' => 'Create Time',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'time_used' => 'Time Used',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('task_name',$this->task_name,true);
		$criteria->compare('task_sn',$this->task_sn,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('child_count',$this->child_count,true);
		$criteria->compare('child_finished_count',$this->child_finished_count,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('time_used',$this->time_used,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_laraveltest;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
