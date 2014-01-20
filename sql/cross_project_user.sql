USE one;
CREATE TABLE one.cross_project_user (
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