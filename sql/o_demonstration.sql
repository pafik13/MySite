USE one;
CREATE TABLE one.o_demonstration (
  DEMONSTRATION_ID int(11) NOT NULL AUTO_INCREMENT,
  IMEI varchar(15) NOT NULL,
  DOCTOR_ID int(11) NOT NULL,
  VISIT_DATE date NOT NULL,
  INSERT_TIME timestamp DEFAULT CURRENT_TIMESTAMP,
  FILE_ID int(11) NOT NULL COMMENT 'Ссылка на загруженный файл из которого была взята информация по врачу',
  PRIMARY KEY (DEMONSTRATION_ID),
  INDEX IDX_o_demonstration (IMEI, DOCTOR_ID),
  UNIQUE INDEX UK_o_demonstration (DOCTOR_ID, IMEI, VISIT_DATE)
)
ENGINE = INNODB
AUTO_INCREMENT = 51
AVG_ROW_LENGTH = 348
CHARACTER SET utf8
COLLATE utf8_general_ci;