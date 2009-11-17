-- $Id$
-- $URL$
-- $Revision$
-- Since: 2009-11-17 18:39:00

/* BIFARE */
UPDATE app_cm_tdata SET t_date = '2009-11-17' WHERE t_value = '';

/* CAUTARE NR. NOROCOS */
SELECT * FROM app_cm_tdata WHERE t_value = '';

/* CAUTARE SERIE */
SELECT * FROM app_cm_tinfo WHERE t_sn REGEXP '';