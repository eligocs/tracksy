<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-02-02 10:30:45 --> Query error: Unknown column 'iti.iti_decline_approved_date' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary` as `iti`
INNER JOIN `iti_payment_details` as `pay` ON `iti`.`iti_id` = `pay`.`iti_id`
WHERE `iti`.`del_status` =0
AND `iti`.`iti_status` = 9
AND `pay`.`iti_booking_status` =0
AND  `iti`.`iti_decline_approved_date` LIKE '%2022-02%' ESCAPE '!'
ERROR - 2022-02-02 10:30:45 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 10:42:04 --> Severity: Notice --> Undefined variable: agent C:\xampp\htdocs\trackv2\application\views\customers\addcustomer.php 78
ERROR - 2022-02-02 10:42:28 --> Severity: Notice --> Undefined variable: agent C:\xampp\htdocs\trackv2\application\views\customers\addcustomer.php 78
ERROR - 2022-02-02 10:59:39 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 10:59:39 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 10:59:50 --> Severity: error --> Exception: Call to undefined function dd() C:\xampp\htdocs\trackv2\application\models\Global_model.php 258
ERROR - 2022-02-02 11:00:21 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:00:21 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:00:30 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:00:30 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:33 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:33 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:34 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:34 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:34 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:34 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:34 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:34 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:35 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:35 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:35 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:35 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:35 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:35 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:35 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:35 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:35 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:35 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:36 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:36 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:36 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:36 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:02:39 --> Query error: Unknown column 'lead_created' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `itinerary`
WHERE `parent_iti_id` =0
AND  `quotation_sent_date` LIKE '%2022-02-02%' ESCAPE '!'
AND  `lead_created` LIKE '%2022-02-02%' ESCAPE '!'
ERROR - 2022-02-02 11:02:39 --> Severity: error --> Exception: Call to a member function num_rows() on bool C:\xampp\htdocs\trackv2\system\database\DB_query_builder.php 1426
ERROR - 2022-02-02 11:41:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:41:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:41:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:41:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:41:29 --> Query error: Table 'trackv2.users' doesn't exist - Invalid query: SELECT *
FROM `users`
WHERE `del_status` =0
ORDER BY `user_id` DESC
ERROR - 2022-02-02 11:41:29 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:41:30 --> Query error: Table 'trackv2.users' doesn't exist - Invalid query: SELECT *
FROM `users`
WHERE `del_status` =0
ORDER BY `user_id` DESC
ERROR - 2022-02-02 11:41:30 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:41:59 --> Query error: Table 'trackv2.users' doesn't exist - Invalid query: SELECT *
FROM `users`
WHERE `del_status` =0
ORDER BY `user_id` DESC
ERROR - 2022-02-02 11:41:59 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:42:02 --> Query error: Table 'trackv2.settings' doesn't exist - Invalid query: SELECT `site_title`
FROM `settings`
 LIMIT 1
ERROR - 2022-02-02 11:42:02 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:42:04 --> Query error: Table 'trackv2.settings' doesn't exist - Invalid query: SELECT `site_title`
FROM `settings`
 LIMIT 1
ERROR - 2022-02-02 11:42:04 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:42:10 --> Query error: Table 'trackv2.users' doesn't exist - Invalid query: SELECT *
FROM `users`
WHERE `del_status` =0
ORDER BY `user_id` DESC
ERROR - 2022-02-02 11:42:10 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:42:17 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:42:17 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:42:20 --> Query error: Table 'trackv2.settings' doesn't exist - Invalid query: SELECT `site_title`
FROM `settings`
 LIMIT 1
ERROR - 2022-02-02 11:42:20 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:42:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:42:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:42:27 --> Query error: Table 'trackv2.settings' doesn't exist - Invalid query: SELECT `site_title`
FROM `settings`
 LIMIT 1
ERROR - 2022-02-02 11:42:27 --> Severity: error --> Exception: Call to a member function result() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 301
ERROR - 2022-02-02 11:43:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:43:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:44:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:44:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:45:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:45:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:46:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:46:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:47:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:47:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:48:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:48:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:49:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:49:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:50:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:50:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:51:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:51:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:52:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:52:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:53:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:53:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:54:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:54:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:55:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:55:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:56:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:56:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:57:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:57:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:58:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:58:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 11:59:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 11:59:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 12:00:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 12:00:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 12:01:24 --> Query error: Table 'trackv2.notifications' doesn't exist - Invalid query: SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = 99 order by id DESC
ERROR - 2022-02-02 12:01:24 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\trackv2\application\models\Global_model.php 698
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:14 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:24:26 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 12:47:17 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 12:48:38 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 12:59:02 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 13:11:07 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 14:33:52 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 14:34:37 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 14:39:17 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 14:39:25 --> Severity: Warning --> "continue" targeting switch is equivalent to "break". Did you mean to use "continue 2"? C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 17778
ERROR - 2022-02-02 14:39:26 --> Severity: Warning --> A non-numeric value encountered C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 6962
ERROR - 2022-02-02 14:39:26 --> Severity: Warning --> A non-numeric value encountered C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 6963
ERROR - 2022-02-02 14:39:26 --> Severity: Warning --> A non-numeric value encountered C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 6962
ERROR - 2022-02-02 14:39:26 --> Severity: Warning --> A non-numeric value encountered C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 6963
ERROR - 2022-02-02 14:39:26 --> Severity: Warning --> A non-numeric value encountered C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 6962
ERROR - 2022-02-02 14:39:26 --> Severity: Warning --> A non-numeric value encountered C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 6963
ERROR - 2022-02-02 14:39:26 --> Severity: 8192 --> The each() function is deprecated. This message will be suppressed on further calls C:\xampp\htdocs\trackv2\application\libraries\TCPDF\tcpdf.php 16542
ERROR - 2022-02-02 14:40:29 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 14:42:41 --> Severity: Warning --> mail(): Failed to connect to mailserver at &quot;localhost&quot; port 25, verify your &quot;SMTP&quot; and &quot;smtp_port&quot; setting in php.ini or use ini_set() C:\xampp\htdocs\trackv2\system\libraries\Email.php 1896
ERROR - 2022-02-02 16:12:28 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\accommodation\edit.php 219
ERROR - 2022-02-02 16:34:23 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\accommodation\edit.php 219
ERROR - 2022-02-02 16:36:46 --> Severity: Notice --> Undefined index: id C:\xampp\htdocs\trackv2\application\controllers\Search.php 457
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 16:41:41 --> Severity: Notice --> Undefined variable: selected C:\xampp\htdocs\trackv2\application\views\customers\leads_all_data.php 810
ERROR - 2022-02-02 17:05:55 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 715
ERROR - 2022-02-02 17:08:08 --> Severity: Notice --> Undefined index: id C:\xampp\htdocs\trackv2\application\controllers\Search.php 457
ERROR - 2022-02-02 17:08:30 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 715
ERROR - 2022-02-02 17:09:24 --> Severity: Warning --> Use of undefined constant continue22 - assumed 'continue22' (this will throw an Error in a future version of PHP) C:\xampp\htdocs\trackv2\application\models\Vehiclesbooking_model.php 91
ERROR - 2022-02-02 17:09:24 --> Severity: Warning --> Use of undefined constant continue22 - assumed 'continue22' (this will throw an Error in a future version of PHP) C:\xampp\htdocs\trackv2\application\models\Vehiclesbooking_model.php 91
ERROR - 2022-02-02 17:20:54 --> Severity: Warning --> "continue" targeting switch is equivalent to "break". Did you mean to use "continue 2"? C:\xampp\htdocs\trackv2\application\views\payments\itinerary\update.php 491
ERROR - 2022-02-02 17:29:42 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 715
ERROR - 2022-02-02 17:34:26 --> Severity: Notice --> Undefined index: id C:\xampp\htdocs\trackv2\application\controllers\Search.php 457
ERROR - 2022-02-02 17:53:31 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 715
ERROR - 2022-02-02 18:03:39 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 715
ERROR - 2022-02-02 18:08:04 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 715
ERROR - 2022-02-02 18:12:47 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 716
ERROR - 2022-02-02 18:14:48 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 717
ERROR - 2022-02-02 18:15:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 717
ERROR - 2022-02-02 18:15:45 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 716
ERROR - 2022-02-02 18:19:22 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\trackv2\application\views\itineraries\view_iti.php 716
