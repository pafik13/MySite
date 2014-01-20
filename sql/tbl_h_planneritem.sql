USE a7548780_sbl;
CREATE TABLE a7548780_sbl.tbl_h_planneritem (
  IMEI varchar(15) NOT NULL COMMENT 'Идентификатор устройства',
  HOSPITAL_ID int(11) NOT NULL COMMENT 'Идентификатор ЛПУ уникальный для конкретного устройства',
  WEEKNUM int(2) NOT NULL COMMENT 'Номер недели',
  DAY_OF_WEEK varchar(9) NOT NULL COMMENT 'День недели',
  FILE_ID int(11) NOT NULL COMMENT 'Ссылка на загруженный файл из которого была взята информация по ЛПУ',
  INDEX IDX_tbl_h_planneritem (HOSPITAL_ID, IMEI),
  UNIQUE INDEX UK_tbl_h_planneritem (HOSPITAL_ID, IMEI, DAY_OF_WEEK, WEEKNUM),
  CONSTRAINT FK_tbl_h_planneritem_tbl_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES a7548780_sbl.tbl_upload_files (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Значения в планнировщике';