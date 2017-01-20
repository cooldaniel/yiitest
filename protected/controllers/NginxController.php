<?php
/**
 * 模拟nginx程序.
 * @copyright lsx 2017/01/06
 * @package application.controllers
 */

class NginxController extends Controller
{
    public function actionIndex()
	{
        D::pd('nginx');
	}

	public function actionEvent()
	{
        $runTaskList = GlobalHelper::getTaskList();

        \D::pd('begin...');

        // run
        foreach ($runTaskList as $task)
        {
            $task->handle();
        }

        $t = time();
        $stop = false;
        while (!$stop)
        {
            //\D::pd('while...');
            $eventList = GlobalHelper::getEventList();
            if (!empty($eventList))
            {
                //\D::pd('processing...');
                // wait task
                $waitTaskList = GlobalHelper::getWaitTaskList();

                // timeout handle
                $now = time();
                foreach ($waitTaskList as $task)
                {
                    //\D::pd($task->time,$now);
                    if ($task->time <= $now)
                    {
                        \D::pd('timeout...');
                        $task->timeout_handle();
                        GlobalHelper::timeout_handle($task);
                    }
                    else
                    {
                        break;
                    }
                }
            }
            //\D::pd('nothing...');
            $stop = (($now - $t) > 2);
        }
	}
}

class GlobalHelper
{
    private static $_eventList = [];
    private static $_taskList = [];

    public static function addEvent($event)
    {
        self::$_eventList[$event->owner->id] = $event;
    }

    public static function getEventList()
    {
        foreach (self::$_eventList as $index => $event)
        {
            if ($event->owner->time < time())
            {
                unset(self::$_eventList[$index]);
            }
        }
        return self::$_eventList;
    }

    public static function deleteEvent($event)
    {
        unset(self::$_eventList[$event->owner->id]);
    }

    public static function getTaskList()
    {
        if (empty(self::$_taskList))
        {
            for ($i=0; $i<5; $i++)
            {
                $task = new Task('task_' . $i);
                $task->time = time();
                if ($i%2 == 0)
                {
                    $task->type = System::SYS_EVENT_READ;
                }
                else
                {
                    $task->type = System::SYS_EVENT_WRITE;
                }
                self::$_taskList[$task->id] = $task;
            }
        }
        return self::$_taskList;
    }

    public static function getWaitTaskList()
    {
        $waitTaskList = [];
        foreach (self::$_taskList as $task)
        {
            if ($task->time > time())
            {
                $waitTaskList[$task->time] = $task;
            }
        }
        sort($waitTaskList);
        return $waitTaskList;
    }

    public static function timeout_handle($task)
    {
        D::pd("task $task->id: timeout for waiting $task->type and been removed");
        unset(self::$_eventList[$task->id]);
        unset(self::$_taskList[$task->id]);
    }
}

class System
{
    const SYS_EVENT_READ = 'READ';
    const SYS_EVENT_WRITE = 'WRITE';

    public static function handleRead($task)
    {
        \D::pd('r');
        $eventList = GlobalHelper::getEventList();
        if (!isset($eventList[$task->id]))
        {
            $task->time += 1;
            $event = new Event($task, self::SYS_EVENT_READ, 'can not read, must wait.');
            GlobalHelper::addEvent($event);
        }
    }

    public static function handleWrite($task)
    {
        \D::pd('w');
        $eventList = GlobalHelper::getEventList();
        if (!isset($eventList[$task->id]))
        {
            $task->time += 1;
            $event = new Event($task, self::SYS_EVENT_READ, 'can not write, must wait.');
            GlobalHelper::addEvent($event);
        }
    }

    public static function poll_function($eventList, $timeout)
    {
        foreach ($eventList as $event)
        {

        }
        return $eventList;
    }
}

class Task
{
    public $id;
    public $type;
    public $time;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $method = 'handle' . ucfirst((strtolower($this->type)));
        System::$method($this);
    }

    public function timeout_handle()
    {
        D::pd("task $this->id: timeout for waiting $this->type");
    }
}

class Event
{
    public $owner;
    public $type;
    public $message;
    public function __construct($owner, $type, $message)
    {
        $this->owner = $owner;
        $this->type = $type;
        $this->message = $message;
    }
}