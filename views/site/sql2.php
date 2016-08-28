<?php

return '<strong>SELECT</strong> `manager`.*, COUNT(`claim`.`id`) as claim_count, SUM(`claim`.`sum`) claim_total_sum <br>
<strong>FROM</strong> `manager`<br>
<strong>LEFT JOIN</strong> `claim`<br>
<strong>ON</strong> `manager`.`id` = `claim`.`manager_id`<br>
<strong>GROUP BY</strong> `manager`.`id`;';