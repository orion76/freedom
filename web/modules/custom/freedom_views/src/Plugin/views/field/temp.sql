SELECT COUNT(*) AS expression FROM (
SELECT 1 AS expression 
FROM {node_field_data} node_field_data 
LEFT JOIN {node__field_initiative} node__field_initiative ON node_field_data.nid = node__field_initiative.entity_id AND node__field_initiative.deleted = :views_join_condition_0 
INNER JOIN {node_field_data} node_field_data_node__field_initiative ON node__field_initiative.field_initiative_target_id = node_field_data_node__field_initiative.nid 
LEFT JOIN {node__field_date_range} node__field_date_range ON node_field_data.nid = node__field_date_range.entity_id 
    AND node__field_date_range.deleted = :views_join_condition_1 
    AND (node__field_date_range.langcode = node_field_data.langcode 
    OR node__field_date_range.bundle = :views_join_condition_3) 
WHERE (node_field_data.type IN (:db_condition_placeholder_0)) 
    AND ((DATE_FORMAT(FROM_UNIXTIME(1612127330), '%Y-%m-%d %H:%i:%s') < DATE_FORMAT(node__field_date_rangefield_date_range_value, '%Y-%m-%d %H:%i:%s')))) subquery; 
