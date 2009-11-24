-- $Id$
-- $URL$
-- $Revision$
-- Since: 2009-11-23 19:47:00

/* CATE NUMERE AVEM BIFATE PE FIECARE TICKET ASTAZI */
SELECT tdata.t_sn AS sn, COUNT(tdata.t_sn) AS items FROM app_cm_tdata AS tdata
LEFT JOIN app_cm_tinfo AS tinfo ON (tdata.t_sn = tinfo.t_sn)
WHERE tinfo.t_week = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end)
AND tdata.t_value IN 
(SELECT n_value FROM app_cm_tnum WHERE n_date = DATE(NOW()) AND n_lucky = 0)
GROUP BY sn ORDER BY items DESC;

/* CATE NUMERE AM BIFAT PE FIECARE TICKET SAPTAMANA CURENTA */
SELECT tdata.t_sn AS sn, COUNT(tdata.t_sn) AS items FROM app_cm_tdata AS tdata
LEFT JOIN app_cm_tinfo AS tinfo ON (tdata.t_sn = tinfo.t_sn)
WHERE tinfo.t_week = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end)
AND tdata.t_date != '0000-00-00'
GROUP BY sn ORDER BY items DESC;

/* LISTA NUMERE CASTIGATOARE SAPTAMANA CURENTA */
SELECT n_value FROM app_cm_tnum WHERE n_date BETWEEN
(SELECT w_start FROM app_cm_tweeks WHERE w_id = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end))
AND
(SELECT w_end FROM app_cm_tweeks WHERE w_id = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end))
AND n_lucky = 0 ORDER BY n_value;

/* LISTA NUMERE NOROCOASE SAPTAMANA CURENTA */
SELECT n_value FROM app_cm_tnum WHERE n_date BETWEEN
(SELECT w_start FROM app_cm_tweeks WHERE w_id = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end))
AND
(SELECT w_end FROM app_cm_tweeks WHERE w_id = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end))
AND n_lucky != 0 ORDER BY n_value;

/* LISTA NUMERE BIFATE ASTAZI */
SELECT DISTINCT(tdata.t_value) AS num FROM app_cm_tdata AS tdata
LEFT JOIN app_cm_tinfo AS tinfo ON (tdata.t_sn = tinfo.t_sn)
WHERE tinfo.t_week = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end)
AND t_date = DATE(NOW()) ORDER BY num ASC;

/* LISTA NUMERE BIFATE SAPTAMANA CURENTA */
SELECT DISTINCT(tdata.t_value) AS num FROM app_cm_tdata AS tdata
LEFT JOIN app_cm_tinfo AS tinfo ON (tdata.t_sn = tinfo.t_sn)
WHERE tinfo.t_week = (SELECT w_id FROM app_cm_tweeks WHERE DATE(NOW()) BETWEEN w_start AND w_end)
AND t_date != '0000-00-00' ORDER BY num ASC;