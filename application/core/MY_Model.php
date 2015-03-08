<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $table;			//table name

	protected $p_key = 'id';	//primary key
	
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('inflector');

		//guess table name if not set
		if ($this->table == null) {
			$this->_get_table();
		}
	}

	/**
	 * Get a single record
	 * @param  integer $id value of id to search
	 * @param array $join key-value pairs of joined table(s)
	 * @return object      [description]
	 */
	public function get($id = 0, $join = array())
	{
		if (!empty($join)) {
			$this->_joins($join);
		}

		$this->db->where("$this->table.$this->p_key", $id);

		$q = $this->db->get($this->table);

		return $q->row();
	}

	/**
	 * Get all records of table
	 * @return object [description]
	 */
	public function get_all($join = array())
	{
		if (!empty($join)) {
			$this->_joins($join);
		}

		$q = $this->db->get($this->table);

		return $q->result();
	}

	/**
	 * Get by given field name
	 * @param  string $key fieldname
	 * @param  string $val value of field to search
	 * @param array $join table-column key value pair
	 * @return object      [description]
	 */
	public function get_by($key = '', $val = '', $join = array())
	{
		if (!empty($join)) {
			$this->_joins($_joins);
		}

		$this->db->where("$this->table.$key", $val);

		$q = $this->db->get($this->table);

		return $q->result();
	}

	/**
	 * Delete data from table
	 * @param  integer $id primary key to delete
	 * @return boolean      true/false
	 */
	public function delete($id = 0)
	{
		$this->db->where($this->p_key, $id);

		$this->db->delete($this->table);

        return $this->db->affected_rows() > 0 ? true : false;
	}

    public function insert($data)
    {
        $this->db->insert($this->table, $data);

        $id = $this->db->insert_id();

        return $this->db->affected_rows() > 0 ? $id : false;
    }

    public function update($id, $data)
    {
        $this->db->where($this->p_key, $id);

        $this->db->update($this->table, $data);

        return $this->db->affected_rows() > 0 ? true : false;
    }

	/*
	HELPER METHODS
	 */
	
	/**
	 * Create table joins
	 * @param  array  $tables table-column key-value pairs
	 * @return string         join statement
	 */
	private function _joins($tables = array())
	{
		foreach ($tables as $key => $value) {
			$this->db->join($key, "$key.$value = $this->table.$this->p_key");
		}
	}

	/**
	 * Guess table name by pluralizing model class
	 * @return string guessed table name
	 */
	protected function _get_table()
	{
		$model = strtolower(get_class($this));

		$table = plural(strstr($model, '_', true));

		$this->table = $table;
	}

	/*
	WRAPPERS
	 */
	
	public function limit($limit = 10, $offset = 20)
	{
		$this->db->limit($limit, $offset);

		return $this;
	}

	public function order_by($key = '', $direction = 'asc')
	{
		$this->db->order_by("$this->table.$key", "$direction");

		return $this;
	}
}
