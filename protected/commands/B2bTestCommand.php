<?php
/**
 * 测试Yii的命令行应用功能如何编写.
 */

Yii::import('application.commands.test.TestModel');

class B2bTestCommand extends CConsoleCommand
{
    protected $lineLimit=0;

	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic b2btest <name>
  yiic b2btest <name> [path]

DESCRIPTION
  Generate b2b test bat file with specific name and path.
  If no path specified, use 2468 as default.

PARAMETERS
  * name: required, the target bat file name.
  * path: optional, the path to save the bat file.

EXAMPLES
  * yiic b2btest testArrayHelp.php        	- Create bat file which name is testArrayHelp.php
  * yiic b2btest testArrayHelp.php 2468     - Create bat file which name is testArrayHelp.php in the 2468 dir.

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
			$this->usageError('the name of the bat file must be specified.');

		if(!is_dir($args[1]))
			$this->usageError("path {$args[0]} is not existed.");


	}
}
