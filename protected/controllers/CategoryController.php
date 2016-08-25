<?php
/**
 * 分类算法分析.
 * @date 2016/05/18
 */
class CategoryController extends Controller
{
	private $_all = array();

	public function init()
	{
		parent::init();

		$this->_all = Category::model()->findAll();
		D::pd($this->_all);
	}

	public function actionIndex()
	{
		$id = 8;

		// find current record
		$model = $this->findCurrent($id);
		D::pd($model);

		// find parent record
		$parent = $this->findParent($model);
		D::pd($parent);

		// find all parent records
		$parentAll = $this->findAllParent($model);
		D::pd($parentAll);

		// find children records
		$children = $this->findChildren($model);
		D::pd($children);

		$childrenAll = $this->findChildrenRecurse(7, 1);
		D::pd($childrenAll);
	}

	public function findCurrent($id)
	{
		return Category::model()->findByPk(array('id'=>$id));
	}

	public function findParent($model, $returnIncludeSelf=true)
	{
		$parent = $this->findCurrent($model->parent_id);
		return $returnIncludeSelf ? array($parent, $model) : $parent;
	}

	public function findAllParent($model, $returnIncludeSelf=true)
	{
		$parentList = array();

		$parentId = $model->parent_id;
		while($parentId > 0)
		{
			$found = false;

			foreach ($this->_all as $row)
			{
				if ($row->id == $parentId)
				{
					$found = true;
					$parentList[] = $row;
					$parentId = $row->parent_id;

					// stop seeking
					break;
				}
			}

			// in case of that the root parent id is not 0.
			if (!$found)
				break;
		}

		$parentList = array_reverse($parentList);

		if ($returnIncludeSelf)
		{
			array_push($parentList, $model);
		}

		return $parentList;
	}

	public function findChildren($model, $returnIncludeSelf=true)
	{
		$children = array();

		$id = $model->id;
		foreach ($this->_all as $row)
		{
			if ($row->parent_id == $id)
			{
				$children[] = $row;
			}
		}

		$children = array_reverse($children);

		if ($returnIncludeSelf)
		{
			array_unshift($children, $model);
		}

		return $children;
	}

	public function findChildrenRecurse($parentId=0, $levelStop=0, $prefixString='', $level=0, $list=array())
	{
		foreach ($this->_all as $row)
		{
			if ($row->parent_id == $parentId)
			{
				if ($levelStop > 0 && $level < $levelStop)
				{
					$level++;
					$children = $this->findChildrenRecurse($row->id, $levelStop, $prefixString, $level);
					if ($children !== array())
					{
						$row->children = $children;
					}
				}
				$list[] = $row;
			}
		}
		return $list;
	}
}