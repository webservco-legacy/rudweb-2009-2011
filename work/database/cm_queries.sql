-- $Id$
-- $URL$
-- $Revision$
-- Since: 2009-11-17 18:39:00

/* DEPR - ADAUGARE NUMERE ZIUA CURENTA */
INSERT INTO app_cm_tnum (n_date, n_value, n_lucky) VALUES
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 0),
(DATE(NOW()), , 1);

/* DEPR - CAUTARE NUMAR NOROCOS ZIUA CURENTA */
SELECT * FROM app_cm_tdata WHERE t_value = (SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 1);

/* DEPR - BIFARE NUMERE ZIUA CURENTA */
UPDATE app_cm_tdata SET t_date = DATE(NOW()) WHERE t_value IN (SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 0);

/* CAUTARE SERIE */
SELECT * FROM app_cm_tinfo WHERE t_sn REGEXP '';

/* CAUTARE CELE 3 NUMERE DIN REVISTA */
SELECT tdata.t_sn AS sn, COUNT(tdata.t_sn) AS items FROM app_cm_tdata AS tdata
LEFT JOIN app_cm_tinfo AS tinfo ON (tdata.t_sn = tinfo.t_sn)
WHERE tinfo.t_week = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end)
AND tdata.t_value IN 
(0, 0, 0)
GROUP BY sn
-- HAVING items >= 3
ORDER BY items DESC;

/* ADAUGARE SAPTAMANA */
INSERT INTO app_cm_tweeks (w_id, w_start, w_end) VALUES (0, '0000-00-00', '0000-00-00');