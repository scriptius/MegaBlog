<?php

return 'SELECT DATE_FORMAT(`created_at`, \'%M %Y\') as `month`, COUNT(`claim`.`id`) as claim_count, SUM(`claim`.`sum`) claim_total_sum<br>
FROM `manager`<br>
LEFT JOIN `claim`<br>
ON `manager`.`id` = `claim`.`manager_id`<br>
GROUP BY `month`';