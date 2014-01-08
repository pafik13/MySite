﻿USE one;
CREATE TABLE one.o_hospital (
  IMEI int(11) NOT NULL,
  HOSPITAL_ID int(11) NOT NULL,
  NAME varchar(255) DEFAULT NULL,
  ADRESS varchar(255) DEFAULT NULL,
  FILE_ID int(11) NOT NULL,
  PRIMARY KEY (IMEI, HOSPITAL_ID),
  CONSTRAINT FK_o_hospital_o_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES one.o_upload_files (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'ЛПУ';