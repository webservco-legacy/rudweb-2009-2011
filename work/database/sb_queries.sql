-- $Id$
-- $URL$
-- $Revision$
-- Since: 2009-11-24 10:09:00

/* CHECK NUMBERS */
SELECT n_value FROM app_sb_num WHERE n_date = '2009-11-29' AND n_value IN
-- (25,42,51,71,83,32,43,53,74,84,2,13,49,61,85)
-- (3,21,33,54,81,12,27,34,75,88,5,28,36,44,68)
-- (6,14,55,62,76,29,45,57,77,82,15,31,58,69,79)
ORDER BY n_value;
;