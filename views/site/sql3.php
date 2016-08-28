<?php

return '<strong>SELECT</strong> GROUP_CONCAT(DISTINCT first_name, last_name ORDER BY first_name DESC SEPARATOR \' \') as `full_name`, COUNT(`claim`.`id`) as claim_count<br>
<strong>FROM</strong> `manager`<br>
<strong>LEFT JOIN</strong> `claim`<br>
<strong>ON</strong> `manager`.`id` = `claim`.`manager_id`<br>
<strong>GROUP BY</strong> `manager`.`id`<br>
<strong>ORDER BY</strong> `claim_count` ASC<br>
<strong>LIMIT</strong> 2;';