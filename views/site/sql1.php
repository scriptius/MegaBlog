<?php

return '<strong>CREATE TABLE</strong> IF NOT EXISTS `posts` ( <br>
  `post_id` int(11) unsigned AUTO_INCREMENT,<br>
  `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci, <br>
  `text` TEXT NOT NULL,<br>
  PRIMARY KEY (`post_id`)<br>
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;<br>
<br><br>
<strong>CREATE TABLE</strong> IF NOT EXISTS `authors` (<br>
  `author_id` int(11) unsigned AUTO_INCREMENT,<br>
  `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci, <br>
  <strong>PRIMARY KEY</strong> (`author_id`)<br>
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;<br>
<br><br>
<strong>CREATE TABLE</strong> IF NOT EXISTS `publish` (<br>
  `publish_id` int(11) unsigned AUTO_INCREMENT,<br>
  `post_id` int(11) unsigned,<br>
  `author_id` int(11) unsigned,<br>
  <strong>PRIMARY KEY</strong> (`publish_id`)<br>
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;<br>
<br><br>
<strong>ALTER TABLE</strong> `publish` ADD FOREIGN KEY `post_fk` (`post_id`)<br>
<strong>REFERENCES</strong> `posts` (`post_id`)<br>
<strong>ON</strong> DELETE CASCADE;<br>
<br><br>
<strong>ALTER TABLE</strong> `publish` ADD FOREIGN KEY `author_fk` (`author_id`)<br>
<strong>REFERENCES</strong> `authors` (`author_id`)<br>
<strong>ON</strong> DELETE CASCADE;';