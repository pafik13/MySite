USE a7548780_sbl;
CREATE TABLE a7548780_sbl.tbl_hospital (
  IMEI varchar(15) NOT NULL COMMENT 'Идентификатор устройства',
  HOSPITAL_ID int(11) NOT NULL COMMENT 'Идентификатор ЛПУ уникальный для конкретного устройства',
  NAME varchar(255) DEFAULT NULL COMMENT 'Наименование ЛПУ',
  ADRESS varchar(255) DEFAULT NULL COMMENT 'Адресс ЛПУ',
  FILE_ID int(11) NOT NULL COMMENT 'Ссылка на загруженный файл из которого была взята информация по ЛПУ',
  PRIMARY KEY (IMEI, HOSPITAL_ID),
  CONSTRAINT FK_tbl_hospital_tbl_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES a7548780_sbl.tbl_upload_files (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'ЛПУ';