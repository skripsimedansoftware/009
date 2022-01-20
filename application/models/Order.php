<?php
defined('BASEPATH') OR exit('No direct script access allowed');

namespace Angeli;

class Order extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('order');
	}
}

/* End of file Order.php */
/* Location: ./application/models/Order.php */
