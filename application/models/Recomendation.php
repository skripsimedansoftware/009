<?php
/**
 * @package Codeigniter
 * @subpackage Recomendation
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Recomendation extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('recomendation');
	}
}

/* End of file Recomendation.php */
/* Location : ./application/models/Recomendation.php */
