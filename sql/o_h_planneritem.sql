USE one;
CREATE TABLE one.o_h_planneritem (
  IMEI int(11) NOT NULL,
  HOSPITAL_ID int(11) NOT NULL,
  WEEKNUM int(2) NOT NULL,
  DAY_OF_WEEK varchar(9) NOT NULL,
  FILE_ID int(11) NOT NULL,
  INDEX IDX_o_h_planneritem (HOSPITAL_ID, IMEI),
  UNIQUE INDEX UK_o_h_planneritem (HOSPITAL_ID, IMEI, DAY_OF_WEEK),
  CONSTRAINT FK_o_h_planneritem_o_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES one.o_upload_files (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Значения в планнировщике';