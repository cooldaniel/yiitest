
### 绩效

# 所有数据 - 乱序
SELECT *
FROM yii_department_performance;

# 绩效降序 - 整个公司最大绩效
SELECT *
FROM yii_department_performance
ORDER BY performance DESC;

# 使用group by加排序 - 不行
SELECT *
FROM yii_department_performance
GROUP BY department_id
ORDER BY performance DESC;

# 使用group by加max - 可以
SELECT id, department_id, MAX(performance)
FROM yii_department_performance
GROUP BY department_id;



### 自增id

SELECT
    (@rowNo := @rowNo + 1) AS id,
    `name`
FROM 
(
    SELECT
        `name` 
    FROM yii_country
    WHERE population = 0
) a,
(SELECT @rowNo := 0) b





