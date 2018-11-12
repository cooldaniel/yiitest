<?php
/**
 * 测试Yii的命令行应用功能如何编写.
 */

Yii::import('application.commands.test.TestModel');

class TestCommand extends CConsoleCommand
{
    protected $lineLimit=0;

	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic test <path> [-n]
  yiic test info

DESCRIPTION
  The test command is used to show how to create Yii console command.

PARAMETERS
  * path: required, the path to list.
  * -n: optional, the limit count of the list.

EXAMPLES
  * yiic test .        	- List the path.
  * yiic test . 10	    - List the path and limit 10.
  * yiic test info      - Info about the path.

EOD;
	}

	/**
	 * Execute the action.
	 * @param array $args line parameters specific for this command
     * @return void
	 */
	public function run($args)
	{
		if(!isset($args[0]))
			$this->usageError('the path to list must be specified.');

        if ($args[0] == "info") {
            echo 'info';
            exit();
        }

		if(!is_dir($args[0]))
			$this->usageError("path {$args[0]} is not existed.");
		
		if (isset($args[1]) && substr($args[1], 0, 1) == "-") {
			$this->lineLimit = (int)substr($args[1], 1);
		}

        echo "dir {$args[0]} -{$this->lineLimit}";
	}
}
