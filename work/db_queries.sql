-- --------------------------------------------------------------------------------
-- PAGES
-- --------------------------------------------------------------------------------
SELECT * FROM rw_ws_pages;
SELECT pg_id, pg_parent, pg_level, pg_order, pg_title, pg_alias FROM rw_ws_pages ORDER BY pg_id DESC;