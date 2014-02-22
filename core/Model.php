<?php
abstract class Model
{   
    function getrow( $db, $table, $fields, $where_str   = false )
    {  
       $where   = $where_str ? "WHERE {$where_str}" : "";
       $sql     = "SELECT {$fields} FROM {$table} $where ";
       return $db->get_row( $sql );
    }
    
    function getlist( $db, $table, $fields, $where_str  = false, $order_str = false, $count = false, $start = 0 )
    {
       $where   = $where_str ? "WHERE {$where_str}" : "";
       $order   = $order_str ? "ORDER BY {$order_str}" : "";
       $count   = $count ? "LIMIT {$start}, $count" : "";
       
       $sql     = "SELECT {$fields} FROM {$table} {$where} {$order} {$count}";
       //echo $sql;
       return $db->get_results( $sql );
    }
}

?>
