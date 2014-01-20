USE a7548780_sbl;
CREATE TABLE a7548780_sbl.tbl_doctor (
  IMEI varchar(15) NOT NULL COMMENT 'Идентификатор устройства',
  DOCTOR_ID int(11) NOT NULL COMMENT 'Идентификатор врача уникальный для конкретного устройства',
  SNCHAR char(1) DEFAULT NULL COMMENT 'Первая буква фамилии (прим. Для создания списков иди сортировки)',
  SECOND_NAME varchar(255) DEFAULT NULL COMMENT 'Фамилия врача',
  FIRST_NAME varchar(255) DEFAULT NULL COMMENT 'Имя врача',
  THIRD_NAME varchar(255) DEFAULT NULL COMMENT 'Отчество врача',
  HOSPITAL_ID int(11) DEFAULT NULL COMMENT 'Идентификатор ЛПУ уникальный для конкретного устройства',
  TEL varchar(50) DEFAULT NULL COMMENT 'Телефон',
  EMAIL varchar(50) DEFAULT NULL COMMENT 'Электронная почта',
  POSITION_ varchar(50) DEFAULT NULL COMMENT 'Должность',
  SPECIALITY varchar(50) DEFAULT NULL COMMENT 'Специальность',
  FILE_ID int(11) NOT NULL COMMENT 'Ссылка на загруженный файл из которого была взята информация по врачу',
  PRIMARY KEY (IMEI, DOCTOR_ID),
  CONSTRAINT FK_tbl_doctor_tbl_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES a7548780_sbl.tbl_upload_files (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Доктора и врачи';