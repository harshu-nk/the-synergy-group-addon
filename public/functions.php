<?php

function get_history_by_context($key, $value, $limit = 5)
{
    global $wpdb;

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                h.*, 
                c.context_id, 
                c.key, 
                c.value 
            FROM 
                {$wpdb->prefix}simple_history AS h
            JOIN 
                {$wpdb->prefix}simple_history_contexts AS c 
            ON 
                h.id = c.history_id 
            WHERE 
                c.key = %s 
                AND c.value = %s
                LIMIT %d",
            $key,
            $value,
            $limit
        ),
        ARRAY_A
    );

    return $results;
}
