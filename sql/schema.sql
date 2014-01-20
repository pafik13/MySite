-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.0.622.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 20.01.2014 7:31:51
-- Версия сервера: 5.5.25
-- Версия клиента: 4.1

USE one;

CREATE TABLE cross_project_user (
  PROJECT_ID int(11) NOT NULL,
  USER_ID int(11) NOT NULL,
  INDEX IDX_cross_project_user_PROJECT_ID (PROJECT_ID),
  INDEX IDX_cross_project_user_USER_ID (USER_ID),
  UNIQUE INDEX UK_cross_project_user (PROJECT_ID, USER_ID)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Связь между проектами и персонами';

CREATE TABLE o_book (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  author varchar(255) DEFAULT NULL,
  year int(11) DEFAULT NULL,
  description text DEFAULT NULL,
  link varchar(255) DEFAULT NULL,
  img varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 11
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE o_d_demo (
  DEMO_ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный ключ',
  SLIDE_KEY varchar(255) NOT NULL COMMENT 'Ключ слайда',
  DEMONSTRATION_ID int(11) NOT NULL COMMENT 'Ссылка на показ',
  PRIMARY KEY (DEMO_ID)
)
ENGINE = INNODB
AUTO_INCREMENT = 1588
AVG_ROW_LENGTH = 98
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE o_d_show (
  SHOW_ID int(11) NOT NULL AUTO_INCREMENT,
  NUMBER int(11) NOT NULL,
  TIME float NOT NULL,
  LATITUDE float NOT NULL,
  LONGTITUDE float NOT NULL,
  DEMO_ID int(11) NOT NULL,
  PRIMARY KEY (SHOW_ID)
)
ENGINE = INNODB
AUTO_INCREMENT = 1827
AVG_ROW_LENGTH = 57
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE o_demonstration (
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

CREATE TABLE o_page (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  text text NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Страницы';

CREATE TABLE o_project (
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

CREATE TABLE o_temo (
  id int(11) NOT NULL AUTO_INCREMENT,
  xml text DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 12
AVG_ROW_LENGTH = 47513
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE o_upload_file (
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
AUTO_INCREMENT = 64
AVG_ROW_LENGTH = 239802
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Загруженные файлы на сервер';

CREATE TABLE o_user (
  USER_ID int(11) NOT NULL AUTO_INCREMENT,
  SECOND_NAME varchar(50) DEFAULT NULL,
  FIRST_NAME varchar(50) DEFAULT NULL,
  THIRD_NAME varchar(50) DEFAULT NULL,
  IMEI varchar(15) DEFAULT NULL,
  LOGIN varchar(255) NOT NULL,
  BIRTH_DATE date NOT NULL,
  MANAGER_ID int(11) DEFAULT NULL,
  PRIMARY KEY (USER_ID),
  INDEX IDX_o_user_MANAGER_ID (MANAGER_ID),
  UNIQUE INDEX UK_o_users_LOGIN (LOGIN)
)
ENGINE = INNODB
AUTO_INCREMENT = 5
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE o_doctor (
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
  CONSTRAINT FK_o_doctor_o_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES o_upload_file (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 154
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Доктора и врачи';

CREATE TABLE o_h_planneritem (
  IMEI varchar(15) NOT NULL COMMENT 'Идентификатор устройства',
  HOSPITAL_ID int(11) NOT NULL COMMENT 'Идентификатор ЛПУ уникальный для конкретного устройства',
  WEEKNUM int(2) NOT NULL COMMENT 'Номер недели',
  DAY_OF_WEEK varchar(9) NOT NULL COMMENT 'День недели',
  FILE_ID int(11) NOT NULL COMMENT 'Ссылка на загруженный файл из которого была взята информация по ЛПУ',
  INDEX IDX_o_h_planneritem (HOSPITAL_ID, IMEI),
  UNIQUE INDEX UK_o_h_planneritem (HOSPITAL_ID, IMEI, DAY_OF_WEEK, WEEKNUM),
  CONSTRAINT FK_o_h_planneritem_o_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES o_upload_file (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 195
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Значения в планнировщике';

CREATE TABLE o_hospital (
  IMEI varchar(15) NOT NULL COMMENT 'Идентификатор устройства',
  HOSPITAL_ID int(11) NOT NULL COMMENT 'Идентификатор ЛПУ уникальный для конкретного устройства',
  NAME varchar(255) DEFAULT NULL COMMENT 'Наименование ЛПУ',
  ADRESS varchar(255) DEFAULT NULL COMMENT 'Адресс ЛПУ',
  FILE_ID int(11) NOT NULL COMMENT 'Ссылка на загруженный файл из которого была взята информация по ЛПУ',
  PRIMARY KEY (IMEI, HOSPITAL_ID),
  CONSTRAINT FK_o_hospital_o_upload_files_ID FOREIGN KEY (FILE_ID)
  REFERENCES o_upload_file (ID) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 372
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'ЛПУ';

DELIMITER $$

CREATE DEFINER = 'root'@'localhost'
PROCEDURE PRESENTERS (IN i_PROJECT_ID int)
READS SQL DATA
COMMENT 'Список медпредставителей в конктретном проекте'
BEGIN
  SELECT
    ou.*
  FROM cross_project_user crossPU
    LEFT JOIN o_user ou USING (USER_ID)
  WHERE crossPU.PROJECT_ID = i_PROJECT_ID
  AND ou.MANAGER_ID <> 0;
END
$$

CREATE DEFINER = 'root'@'localhost'
PROCEDURE proc (IN Param1 varchar(32))
READS SQL DATA
BEGIN
  DECLARE ufID int;
  SELECT
    ouf.ID INTO ufID
  FROM o_upload_file ouf
  WHERE ouf.HASH = Param1
  AND ouf.TYPE = 'Demonstration';

  SELECT
    od.DOCTOR_ID,
    dd.SLIDE_KEY
  FROM o_demonstration od,
       o_d_demo dd
  WHERE dd.DEMONSTRATION_ID = od.DEMONSTRATION_ID
  AND od.FILE_ID = ufID;
END
$$

CREATE DEFINER = 'root'@'localhost'
PROCEDURE PROJECTS (IN i_MANAGER_ID int)
READS SQL DATA
COMMENT 'Список проектов менеджера'
BEGIN
  SELECT
    op.*
  FROM cross_project_user crossPU
    LEFT JOIN o_project op USING (PROJECT_ID)
  WHERE crossPU.USER_ID = i_MANAGER_ID;
END
$$

CREATE DEFINER = 'root'@'localhost'
PROCEDURE REPORT (IN i_IMEI varchar(15), IN i_FIRST_DATE date, IN i_LAST_DATE date)
READS SQL DATA
BEGIN
  SELECT
    *
  FROM o_demonstration odem
    LEFT JOIN o_doctor od USING (IMEI, DOCTOR_ID)
    LEFT JOIN o_hospital oh USING (IMEI, HOSPITAL_ID)
  WHERE odem.IMEI = i_IMEI
  AND odem.VISIT_DATE BETWEEN i_FIRST_DATE AND i_LAST_DATE
  ORDER BY odem.VISIT_DATE, oh.NAME, od.SECOND_NAME;
END
$$

DELIMITER ;