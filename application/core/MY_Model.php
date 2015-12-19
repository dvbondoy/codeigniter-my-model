<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $TABLE;			//table name

	protected $PKEY = 'id';	//primary key
	
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('inflector');

		//guess table name if not set
		if ($this->TABLE == null) {
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

		$this->db->where("$this->TABLE.$this->PKEY", $id);

		$q = $this->db->get($this->TABLE);

		return $q;
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

		$q = $this->db->get($this->TABLE);

		return $q;
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

		$this->db->where("$this->TABLE.$key", $val);

		$q = $this->db->get($this->TABLE);

		return $q;
	}

	/**
	 * Delete data from table
	 * @param  integer $id primary key to delete
	 * @return boolean      true/false
	 */
	public function delete($id = 0)
	{
		$this->db->where($this->PKEY, $id);

		$this->db->delete($this->TABLE);

        return $this->db->affected_rows() > 0 ? true : false;
	}

    public function save($data = [], $id = 0)
    {
        if ($id == 0) {
            //insert
            $r = $this->insert($data);
        } else {
            //update
            $r = $this->update($id, $data);
        }

        return $r;
    }

    public function insert($data)
    {
        $this->db->insert($this->TABLE, $data);

        $id = $this->db->insert_id();

        return $this->db->affected_rows() > 0 ? $id : false;
    }

    public function update($id, $data)
    {
        $this->db->where($this->PKEY, $id);

        $this->db->update($this->TABLE, $data);

        return $this->db->affected_rows() > 0 ? $id : false;
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
			$this->db->join($key, "$key.$value = $this->TABLE.$this->PKEY");
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

		$this->TABLE = $table;
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
		$this->db->order_by("$this->TABLE.$key", "$direction");

		return $this;
	}
}
