<?php

return 'Данное задание выполнил с использованием пользовательской функции avg_manager, которая возвращает количество
 заявок, менеджера по переданному параметру. Сделано это, чтобы продемонстрировать знания по PL/SQL.<br>
<br><br>
DELIMITER $$<br>
CREATE FUNCTION avg_manager(id_arg INT(11)) RETURNS INT(11)<br>
BEGIN<br>
DECLARE q INT(11);<br>
<br>
SELECT COUNT(`claim`.`id`)<br>
FROM `manager`<br>
LEFT JOIN `claim`<br>
ON `manager`.`id` = `claim`.`manager_id` AND `manager`.`id` = id_arg<br>
ORDER BY `manager`.`id` DESC<br>
<br>
INTO @q;<br>
RETURN @q;<br>
END; $$<br>
DELIMITER ;<br>

<br><br><br>
SELECT `manager`.*, COUNT(`claim`.`id`) as claim_count<br>
FROM `manager`<br>
LEFT JOIN `claim`<br>
ON `manager`.`id` = `claim`.`manager_id`<br>
GROUP BY `manager`.`id`<br>
HAVING claim_count > (SELECT avg_manager(2))<br>
    AND `manager`.`chief_id` IS NOT NULL<br>';