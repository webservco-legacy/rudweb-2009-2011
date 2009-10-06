-- $Id$
-- $URL$
-- $Revision$

-- --------------------------------------------------------------------------------
-- USERS MAIN TEST DATA
-- --------------------------------------------------------------------------------
-- pass inghitzi
INSERT INTO app_usr_usr (grp_id, usr_name, usr_mail, usr_hash)
VALUES('1', 'Tester', 'app@rudisoft.net', 'REDACTED');

-- --------------------------------------------------------------------------------
-- GROUPS MAIN TEST DATA
-- --------------------------------------------------------------------------------
/* 1 */ INSERT INTO app_usr_grp(grp_lvl, grp_name) VALUES(1, 'Users');
/* 2 */ INSERT INTO app_usr_grp(grp_lvl, grp_name) VALUES(2, 'Editors');
/* 3 */ INSERT INTO app_usr_grp(grp_lvl, grp_name) VALUES(3, 'Administrators');
/* 4 */ INSERT INTO app_usr_grp(grp_lvl, grp_name) VALUES(4, 'Owners');
/* 5 */ INSERT INTO app_usr_grp(grp_lvl, grp_name) VALUES(5, 'Root');