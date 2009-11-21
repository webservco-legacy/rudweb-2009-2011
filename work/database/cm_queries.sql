-- $Id$
-- $URL$
-- $Revision$
-- Since: 2009-11-17 18:39:00

/* ADAUGARE NUMERE ZIUA CURENTA --- */
INSERT INTO app_cm_tnum (n_date, n_value, n_lucky) VALUES
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 1);

/* CAUTARE SERIE */
SELECT * FROM app_cm_tinfo WHERE t_sn REGEXP '';

/* CAUTARE NUMAR NOROCOS ZIUA CURENTA */
SELECT * FROM app_cm_tdata WHERE t_value = (SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 1);

/* BIFARE NUMERE ZIUA CURENTA */
UPDATE app_cm_tdata SET t_date = DATE(NOW()) WHERE t_value IN (SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 0);

/* AFISARE TOATE NUMERELE BIFATE */
SELECT * FROM app_cm_tdata WHERE t_value IN (SELECT n_value FROM app_cm_tnum WHERE n_lucky = 0);

/* AFISARE NUMERE BIFATE ZIUA CURENTA */
SELECT * FROM app_cm_tdata WHERE t_value IN (SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 0);

/* TOTAL NUMERE BIFATE ZIUA CURENTA */
SELECT COUNT(c_id) FROM app_cm_tdata WHERE t_value IN (SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 0);

/* TOTAL NUMERE BIFATE */
SELECT COUNT(c_id) FROM app_cm_tdata WHERE t_value IN (SELECT n_value FROM app_cm_tnum WHERE n_lucky = 0);

