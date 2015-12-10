# my_model
Super simple Codeigniter MY_Model for generic database operations

# Why?
We want our model to be slim. Commonly used database operations should be inside MY_Model where every model file can extend and use.

# How to Use
1. Copy MY_Model.php to application/core

2. Extend MY_Model instead of CI_Model
	
	class Some_model extends MY_Model { }

3. Set table to use
	
	$this->table = "mytable";

>**Note**
>If you don't specify a table name, MY_Model will guess table name by pluralizing model class name.
>See _get_table()

4. Set custom primary key
	
	$this->p_key = "custom_pkey";

>**Note**
>If you don't set custom primary key, "id" will be used as primary key.

5. Call MY_Model functions like this
	
	$result = $this->get(1);