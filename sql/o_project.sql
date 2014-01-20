﻿USE one;
CREATE TABLE one.o_project (
  PROJECT_ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный ключ проекта',
  NAME varchar(255) NOT NULL COMMENT 'Название проекта',
  PRIMARY KEY (PROJECT_ID)
)
ENGINE = INNODB
AUTO_INCREMENT = 2
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Проекты';