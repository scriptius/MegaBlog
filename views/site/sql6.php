<?php

return 'SELECT DATE_FORMAT(`created_at`, \'%M %Y\') as `month`, `manager`.*, COUNT(`claim`.`id`) as claim_count, AVG(`claim`.`sum`) as `srednee`<br>
FROM `manager`<br>
LEFT JOIN `claim`<br>
ON `manager`.`id` = `claim`.`manager_id` <br>
WHERE DATE_FORMAT(`created_at`, \'%M %Y\')  like \'July 2013\'<br>
GROUP BY `manager`.`id`<br>
ORDER BY `srednee` DESC;';