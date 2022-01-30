<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Max_miner
{
	public $items = array();

	public $min_support;

	public $transactions = array();

	public function __construct($transactions = array(), $min_support = 0) {
		$this->set_min_support($min_support);
		$this->set_transactions($transactions);
	}

	public function set_transactions($transactions = array()) {
		foreach ($transactions as $items)
		{
			foreach ($items as $item)
			{
				if (!in_array($item, $this->items))
				{
					array_push($this->items, $item);
				}
			}
		}

		$this->transactions = $transactions;
		return $this;
	}

	public function set_items($items = array()) {
		$this->items = $items;
		return $this;
	}

	public function set_min_support($min_support) {
		$this->min_support = $min_support;
		return $this;
	}

	public function count_support(array $items, $min_support = NULL) {

		$data = array();

		$min_support = (empty($min_support))?$this->min_support:$min_support;
		$count_transactions = count($this->transactions);

		foreach ($items as $name => $count)
		{
			$data[$name] = $count/$count_transactions;
		}

		return $data;
	}

	public function item_count($transactions = array()) {

		$data = array();

		if (empty($transactions))
		{
			$transactions = $this->transactions;
		}

		for ($i = 0; $i < count($transactions); $i++)
		{
			$count = array_count_values($transactions[$i]);

			foreach ($count as $key => $value)
			{
				if (array_key_exists($key, $data))
				{
					$data[$key] += 1;
				}
				else
				{
					$data[$key] = 1;
				}
			}
		}

		return $data;
	}

	public function elimination($items, $min_support = NULL) {

		$data = array();

		$min_support = (empty($min_support))?$this->min_support:$min_support;

		foreach ($items as $key => $value)
		{
			if ($value >= $min_support)
			{
				$data[$key] = $value;
			}
		}

		return $data;
	}

	public function join_item($data_filter) {

		$n = 0;
		$data = array();
		$unique = array();

		foreach ($data_filter as $key_1 => $value_1)
		{
			$m = 1;

			foreach ($data_filter as $key_2 => $v2)
			{
				$str = explode('_', $key_2);

				for ($i = 0; $i < count($str); $i++)
				{

					if (!strstr($key_1, $str[$i]))
					{
						if ($m > $n + 1 && count($data_filter) > $n + 1)
						{
							$data[$key_1 . '_' . $str[$i]] = 0;
						}
					}
				}

				$m++;
			}

			$n++;

		}

		foreach ($this->unique_joined_items($data) as $value)
		{
			$unique[$value] = 0;
		}

		return $unique;
	}

	public function unique_joined_items($joined_items) {

		$items = array();

		foreach ($joined_items as $joined_item => $support)
		{
			$array_joined_items = explode('_', $joined_item);
			asort($array_joined_items);
			array_push($items, array_values($array_joined_items));
		}

		$serialized = array_map('serialize', $items);
		$unique = array_unique($serialized);
		$unique = array_intersect_key($items, $unique);

		return array_map(function($items) {
			return implode('_', $items);
		}, $unique);
	}

	public function item_joined_count($joined_items) {

		$data = array();

		$has_transaction = array();

		foreach (array_keys($joined_items) as $joined_items_key => $joined_item)
		{
			$has_transaction[$joined_item] = array();

			$joined_item_array = explode('_', $joined_item);

			foreach ($this->transactions as $transaction_key => $transaction)
			{
				$has_transaction[$joined_item][$transaction_key] = array();

				for ($i = 0; $i < count($joined_item_array); $i++)
				{
					if (in_array($joined_item_array[$i], $transaction))
					{
						array_push($has_transaction[$joined_item][$transaction_key], $joined_item_array[$i]);
					}

					if ($joined_item_array[$i] == end($joined_item_array))
					{
						if (count($has_transaction[$joined_item][$transaction_key]) !== count($joined_item_array))
						{
							unset($has_transaction[$joined_item][$transaction_key]);
						}
					}
				}
			}
		}

		foreach ($has_transaction as $key => $value)
		{
			$data[$key] = count(array_keys($value));
		}

		return $data;
	}
}


/* End of file Max_miner.php */
/* Location: ./application/libraries/Max_miner.php */
