USE a7548780_sbl;
CREATE TABLE a7548780_sbl.tbl_upload_files (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ файла',
  IMEI varchar(15) NOT NULL COMMENT 'Идентификатор устройства, с которого был прислан файл',
  TYPE varchar(255) NOT NULL COMMENT 'Тип записанного файла (прим. Тип передается с устройства)',
  HASH varchar(32) NOT NULL COMMENT 'md5 хэш файла, для быстрого определения изменений в файле',
  TIMESTAMP timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время загрузки файла',
  FILE mediumblob NOT NULL COMMENT 'Файл загруженный из устройства',
  ERR text DEFAULT NULL COMMENT 'Ошибки, которые возникли в процессе обработки файла',
  PRIMARY KEY (ID)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Загруженные файлы на сервер';