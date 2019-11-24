<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatable_response_builder {
   var $ci;
	var $fields;
   var $table;
   var $join;
   var $like;
   var $where;
   var $limit;
   var $order_by;
   var $distinct = FALSE;
   
   public function __construct() {
      $this->ci = &get_instance();
      
      $this->join = array();
      $this->where = array('request' => array(), 'base' => array());
      $this->like = array('request' => array(), 'base' => array());
      $this->limit = array();
      $this->order_by = array();
   }
   
   public function distinct() {
      $this->distinct = TRUE;
      return $this;
   }
   
   public function set_fields($fields) {
      $this->fields = $fields;
      return $this;
   }
   
   public function set_table($table) {
      $this->table = $table;
      return $this;
   }
   
   /**
    * Add a where clause to be applied to final query
    * 
    * @param mixed $where An associative array with 'field' and 'value' fields or a string
    */
   public function add_where_clauses($field, $value = '<NOT>') {
      $this->where['base'][] = ($value != '<NOT>') 
         //? array('field' => $field, 'value' => $value) 
         ? array($field => $value) 
         : $field;
      return $this;
   }
   
   private function add_request_where_clauses($field, $value = '<NOT>') {
      $this->where['request'][] = ($value != '<NOT>') 
         ? array('field' => $field, 'value' => $value) 
         : $field;
   }
   
   /**
    * Add a like clause to be applied to final query
    * 
    * @param mixed $where An associative array with 'field' and 'value' fields or a string
    */
   public function add_like_clauses($field, $value, $type = 'both') {
      $this->where['base'][] = array('field' => $field, 'value' => $value, 'type' => $type);
      return $this;
   }
   
   private function add_request_like_clauses($field, $value, $type = 'both') {
      $this->where['request'][] = array('field' => $field, 'value' => $value, 'type' => $type);
   }
   
   /**
    * Add a join clause to apply to final query
    * 
    * @param array $join An associative array with 'table' and 'on' fields
    */
   public function add_join_clauses($table, $on, $type = 'inner') {
      $this->join[] = array('table' => $table, 'on' => $on, 'type' => $type);
      return $this;
   }
   
   /**
    * Add a limit clause to apply to final query
    * 
    * @param array $limit An associative array with 'start' and 'length' fields
    */
   public function add_limit_clauses($start, $length) {
      $this->limit[] = array('start' => $start, 'length' => $length);
      return $this;
   }
   
   /**
    * Add a limit clause to apply to final query
    * 
    * @param array $order_by An associative array with 'field' and 'type' fields
    */
   public function add_order_by_clauses($field, $type) {
      $this->order_by[] = array('field' => $field, 'type' => $type);
      return $this;
   }
   
   public function build_response() {
      $this->gather_data_from_request();
      
      $recordsTotal = $this->get_total_records();
      $recordsFiltered = ($recordsTotal != 0) ? $this->get_filtered_total_records() : 0;
      $data = ($recordsFiltered != 0) ? $this->get_datatable_rows() : array();
      $sql = $this->ci->db->last_query();
      return array(
			"draw"            => intval( $this->ci->input->get_post('draw') ),
			"recordsTotal"    => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data"            => $data
		);
   }
   
   private function gather_data_from_request() {
      $this->gather_filter_from_request();
      $this->gather_limit_from_request();
      $this->gather_order_from_request();
   }
   
   private function get_total_records() {
      $db = $this->ci->db;
      
      if($this->distinct) $db->distinct();
      $db->select('COUNT(*) n');
      $db->from($this->table);
      
      foreach ($this->join as $j) {
         $db->join($j['table'], $j['on'], $j['type']);
      }
      
      foreach ($this->where['base'] as $w) {
         $db->where($w);
      }
      
      foreach ($this->like['base'] as $l) {
         $db->like($l['field'], $l['value'], $l['type']);
      }
      
      $query = $db->get();
      
      $total = 0;
		if($query->num_rows() > 0) {
			$row = $query->row_array();
         $total = $row['n'];
		}

		return intval($total);
   }
   
   private function get_filtered_total_records() {
      $db = $this->ci->db;
      
      if($this->distinct) $db->distinct();
      $db->select('COUNT(*) n')->from($this->table);
      
      foreach ($this->join as $j) {
         $db->join($j['table'], $j['on'], $j['type']);
      }
      
      $where = array_merge($this->where['base'], $this->where['request']);
      foreach ($where as $w) {
         $db->where($w);
      }
      
      $like = array_merge($this->like['base'], $this->like['request']);
      foreach ($like as $l) {
         $db->like($l['field'], $l['value'], $l['type']);
      }
      
      $query = $db->get();
      
      $total = 0;
		if($query->num_rows() > 0) {
			$row = $query->row_array();
         $total = $row['n'];
		}

		return intval($total);
   }
   
   private function get_datatable_rows() {
      $db = $this->ci->db;
      
      if($this->distinct) $db->distinct();
      $db->select($this->get_db_fields())->from($this->table);
      
      foreach ($this->join as $j) {
         $db->join($j['table'], $j['on'], $j['type']);
      }
      
      $where = array_merge($this->where['base'], $this->where['request']);
      foreach ($where as $w) {
         $db->where($w);
      }
      
      $like = array_merge($this->like['base'], $this->like['request']);
      foreach ($like as $l) {
         $db->like($l['field'], $l['value'], $l['type']);
      }
      
      foreach ($this->order_by as $order_by) {
         $db->order_by($order_by['field'], $order_by['type']);
      }
      
      foreach ($this->limit as $limit_clausola) {
         $db->limit($limit_clausola['length'], $limit_clausola['start']);
      }
      
      $query = $db->get();
      $sql = $db->last_query();
      $data = array();
      foreach ($query->result_array() as $row) {
         $data[] = $this->parse_table_row($row);
      }

		return $data;
   }
   
   private function parse_table_row ( $row )
	{
		$out = array();

      for ( $j=0, $jen=count($this->fields) ; $j<$jen ; $j++ ) {
         $column = $this->fields[$j];

         $db_field_name = $this->extract_db_field_name($column['db']);
         // Is there a formatter?
         if ( isset( $column['formatter'] ) ) {
            $out[ $column['dt'] ] = $column['formatter']( $row[ $db_field_name ], $row );
         }
         else {
            $out[ $column['dt'] ] = $row[ $db_field_name ];
         }
      }

		return $out;
	}

   private function extract_db_field_name($f) {
      if(strpos($f, ' ') !== FALSE) {
         $exploded = explode(' ', $f);
         return array_pop($exploded);
      }
      else if(strpos($f, '.') !== FALSE) {
         $exploded = explode('.', $f);
         return array_pop($exploded);
      }
      else {
         return $f;
      }
   }

	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 */
	private function gather_limit_from_request ()
	{
            $start = $this->ci->input->get('start');
            $length = $this->ci->input->get('length');
            $test = isset($start) && $length != -1 ;
		if ($test) {
   		$this->add_limit_clauses(intval($start), intval($length));
		}
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 */
	private function gather_order_from_request () {
		$request_order = $this->ci->input->get_post('order');
      if ( isset($request_order) && count($request_order) ) {
         $columns = $this->ci->input->get_post('columns');
         $dtColumns = $this->get_dt_fields();

			for ( $i=0, $ien=count($request_order) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request_order[$i]['column']);
				$requestColumn = $columns[$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $this->fields[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$type = $request_order[$i]['dir'] === 'asc' 
                  ? 'ASC' 
                  : 'DESC';

					$this->add_order_by_clauses($column['db'], $type);
				}
			}
		}
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	private function gather_filter_from_request ()
	{
		$globalSearch = array();
		$dtColumns = $this->get_dt_fields();

      $search = $this->ci->input->get_post('search');
		if ( $search !== FALSE && $search['value'] != '' ) {
			$str = $search['value'];
         
         $columns = $this->ci->input->get_post('columns');
			for ( $i=0, $ien=count($columns) ; $i<$ien ; $i++ ) {
				$requestColumn = $columns[$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $this->fields[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
//               $globalSearch[] = "`".$column['db']."` LIKE ".$this->ci->db->escape("%$str%");
					$globalSearch[] = ($this->ci->db->_protect_identifiers($column['db'], FALSE, TRUE))." LIKE ".$this->ci->db->escape("%$str%");
				}
			}
         if ( count( $globalSearch ) ) {
            $this->add_request_where_clauses('('.implode(' OR ', $globalSearch).')');
         }
		}

		// Individual column filtering
      $columns = $this->ci->input->get_post('columns');
		for ( $i=0, $ien=count($columns) ; $i<$ien ; $i++ ) {
			$requestColumn = $columns[$i];
			$columnIdx = array_search( $requestColumn['data'], $dtColumns );
			$column = $this->fields[ $columnIdx ];

			$str = $requestColumn['search']['value'];

			if ( $requestColumn['searchable'] == 'true' && $str != '' ) {
            $this->add_request_like_clauses($column['db'], $str, 'both');
			}
		}
	}

   /**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	private function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}

		return $out;
	}
   
   private function get_dt_fields ()
	{
		return $this->pluck($this->fields, 'dt');
	}
   
   private function get_db_fields ()
	{
		return $this->pluck($this->fields, 'db');
	}
}