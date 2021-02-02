SELECT node_field_data.langcode AS node_field_data_langcode, node_field_data.created AS node_field_data_created, node_field_data.nid AS nid, TIMESTAMPDIFF(MINUTE,NOW(),node__field_date_range.field_date_range_value) AS time_left_field
FROM
{node_field_data} node_field_data
INNER JOIN {node__field_date_range} node__field_date_range ON node.nid = node__field_date_range.entity_id
INNER JOIN {node} node ON node_field_data.nid = node.nid
WHERE (node_field_data.type IN (:db_condition_placeholder_0)) AND ((DATE_FORMAT(FROM_UNIXTIME(***CURRENT_TIME***), '%Y-%m-%d %H:%i:%s') BETWEEN DATE_FORMAT(node__field_date_range.field_date_range_value, '%Y-%m-%d %H:%i:%s') AND DATE_FORMAT(node__field_date_range.field_date_range_end_value, '%Y-%m-%d %H:%i:%s')))
ORDER BY node_field_data_created DESC


SELECT node_field_data.langcode AS node_field_data_langcode, node_field_data.created AS node_field_data_created, node_field_data.nid AS nid, TIMESTAMPDIFF(MINUTE,NOW(),node__field_date_range.field_date_range_value) AS time_left_field
FROM
{node_field_data} node_field_data
INNER JOIN {node__field_date_range} node__field_date_range ON node.nid = node__field_date_range.entity_id
INNER JOIN {node} node ON node_field_data.nid = node.nid
WHERE (node_field_data.type IN (:db_condition_placeholder_0)) AND ((DATE_FORMAT(FROM_UNIXTIME(***CURRENT_TIME***), '%Y-%m-%d %H:%i:%s') BETWEEN DATE_FORMAT(node__field_date_range.field_date_range_value, '%Y-%m-%d %H:%i:%s') AND DATE_FORMAT(node__field_date_range.field_date_range_end_value, '%Y-%m-%d %H:%i:%s')))
ORDER BY node_field_data_created DESC
