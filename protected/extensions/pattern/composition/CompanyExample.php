<?php
/**
 * 组合实例 -- 公司组合.
 * @version 2011.09.17
 * @author lsx
 */

/**
 * 对比聚合实例的割草机实例,可以看出聚合和合成的区别:
 * 聚合中的装配件使用的部件是标准件,也就是两个不同的装配件实例可以互换各自的零部件实例,
 * 虽然会导致最终的装配件实例呈现不同,但这与该示例的完整性无关,例如将割草机的蓝色挡板换成
 * 红色挡板.
 * 合成中的整体类依赖于单元类的存在,单元类也仅属于一个整体类,例如公司组合示例中,一个公司
 * 实例由若干分部实例组成,而每个分部实例同时只能属于一个公司.
 */

/**
 * 公司整体类.
 */
class Company
{
	
}

/**
 * 分部类.
 * 一个公司有多个分部,每个分部由始至终都至多属于一个公司.
 */
class Division
{
	
}

/**
 * 部门类.
 * 一个分部有多个部门,每个部门由始至终都至多属于一个分部,公司间接由部门组成.
 */
class Department
{
	
}

/**
 * 与公司是同等独立地位的员工类.
 */
class Person
{
	
}
?>