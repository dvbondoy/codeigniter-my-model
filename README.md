# my_model
Super simple Codeigniter MY_Model for generic database operations

# Why?
We want our models to be slim. Commonly used database operations should be inside MY_Model where every model file can extend and use.

# How to Use
1. Copy MY_Model.php to application/core

2. Extend MY_Model instead of CI_Model
	
	class Some_model extends MY_Model { }

3. Set table name to use inside your models
	
	protected $TABLE = "mytable";

4. Set custom primary key
	
	protected $PKEY = "custom_pkey";

5. Call MY_Model functions from model like this. Make sure your model extends MY_Model.
	
	$result = $this->get(1)->row();

6. Call MY_Model functions from controller like this. Make sure your model is loaded and extends MY_Model.

	$result = $this->some_model->get(1)->row();

>**Note**
>If you don't specify a table name, MY_Model will guess table name by pluralizing model class name.
>See _get_table()

>**Note**
>If you don't set custom primary key, "id" will be used as primary key.

#To Do's
- Option to record date time stamps to database write, update and delete operations
- Option to enable soft delete of data (data are tagged as deleted but not entirely deleted)