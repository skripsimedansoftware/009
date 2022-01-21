<?php
defined('BASEPATH') OR exit('No direct script access allowed');

namespace Angeli;

class Cart_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('cart');
	}
}

/* End of file Cart_model.php */
/* Location: ./application/models/Cart_model.php */
