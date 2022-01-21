<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Phpml\Association\Apriori;

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template', ['module' => strtolower($this->router->fetch_class())]);
		$this->load->library('cart');
		if (empty($this->session->userdata($this->router->fetch_class())))
		{
			if (!in_array($this->router->fetch_method(), ['login', 'register', 'forgot_password', 'reset_password']))
			{
				redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
			}
		}
	}

	/**
	 * User dashboard
	 */
	public function index()
	{
		$this->template->load('home');
	}

	/**
	 * User login
	 */
	public function login()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('identity', 'Email / Nama Pengguna', 'trim|required');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$user = $this->user->sign_in($this->input->post('identity'), $this->input->post('password'));
				if ($user->num_rows() >= 1)
				{
					$this->session->set_userdata(strtolower($this->router->fetch_class()), $user->row()->id);
					redirect(base_url($this->router->fetch_class()), 'refresh');
				}
				else
				{
					if ($this->user->search($this->input->post('identity'))->num_rows() >= 1)
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Kata sandi tidak sesuai'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Akun tidak ditemukan'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
				}
			}
			else
			{
				$this->load->view('admin/login');
			}
		}
		else
		{
			$this->load->view('admin/login');
		}
	}

	/**
	 * User profile
	 *
	 * @param      int     $id      user.id
	 * @param      string  $option  edit or view
	 */
	public function profile($id = NULL, $option = NULL)
	{
		$data['profile'] = $this->user->read(array('id' => (!empty($id))?$id:$this->session->userdata(strtolower($this->router->fetch_class()))))->row();
		switch ($option)
		{
			case 'edit':
				if ($this->input->method() == 'post')
				{
					if ($id !== $this->session->userdata($this->router->fetch_class()) OR $id > $this->session->userdata($this->router->fetch_class()))
					{
						$this->session->set_flashdata('edit_profile', array('status' => 'failed', 'message' => 'Anda tidak memiliki akses untuk mengubah profil orang lain!'));
						redirect(base_url($this->router->fetch_class().'/profile/'.$id) ,'refresh');
					}

					$this->form_validation->set_data($this->input->post());
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_owned_data[user.email.'.strtolower($this->session->userdata($this->router->fetch_class()).']'));
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required|callback_is_owned_data[user.username.'.strtolower($this->session->userdata($this->router->fetch_class()).']'));
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');

					if ($this->form_validation->run() == TRUE)
					{
						$update_data = array(
							'email' => $this->input->post('email'),
							'username' => $this->input->post('username'),
							'full_name' => $this->input->post('full_name')
						);

						if (!empty($this->input->post('password')))
						{
							$update_data['password'] = sha1($this->input->post('password'));
						}

						if (!empty($_FILES['photo']))
						{
							$config['upload_path'] = './uploads/';
							$config['allowed_types'] = 'png|jpg|jpeg';
							$config['file_name'] = url_title('user-profile-'.$id);
							$this->load->library('upload', $config);

							if (!$this->upload->do_upload('photo'))
							{
								$this->session->set_flashdata('upload_photo_error', $this->upload->display_errors());
							}
							else
							{
								// resize
								$config['image_library']	= 'gd2';
								$config['source_image']		= $this->upload->data()['full_path'];
								$config['maintain_ratio']	= TRUE;
								$config['width']			= 160;
								$config['height']			= 160;
								// watermark
								$config['wm_text'] 			= strtolower($this->router->fetch_class());
								$config['wm_type'] 			= 'text';
								$config['wm_font_color'] 	= 'ffffff';
								$config['wm_font_size'] 	= 12;
								$config['wm_vrt_alignment'] = 'middle';
								$config['wm_hor_alignment'] = 'center';
								$this->load->library('image_lib', $config);

								if ($this->image_lib->resize())
								{
									$this->image_lib->watermark();
								}

								$update_data['photo'] = $this->upload->data()['file_name'];
							}
						}

						$this->user->update($update_data, array('id' => $id));
						$this->session->set_flashdata('edit_profile', array('status' => 'success', 'message' => 'Profil berhasil diperbaharui!'));
						redirect(base_url($this->router->fetch_class().'/profile/'.$id) ,'refresh');
					}
					else
					{
						$this->template->load('profile_edit', $data);
					}
				}
				else
				{
					$this->template->load('profile_edit', $data);
				}
			break;

			default:
				$this->template->load('profile', $data);
			break;
		}
	}

	/**
	 * Daftar produk
	 */
	public function product()
	{
		$data['products'] = $this->product->read();
		$this->template->load('product/home', $data);
	}

	/**
	 * Tambah produk
	 */
	public function product_add()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('name', 'Nama Produk', 'trim|required');
			$this->form_validation->set_rules('price', 'Harga Produk', 'trim|numeric|required');

			if ($this->form_validation->run() == TRUE)
			{
				$image = NULL;

				if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
				{
					$config['upload_path'] = FCPATH.'uploads';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('image'))
					{
						$image = $this->upload->data('file_name');
					}
					else
					{
						$image = FALSE;
						$data['upload_error'] = $this->upload->display_errors('<span class="help-block error">', '</span>');
						$this->template->load('product/add', $data);
					}
				}

				if ($image !== FALSE)
				{
					$this->product->create(array(
						'name' => $this->input->post('name'),
						'image' => $image,
						'price' => $this->input->post('price')
					));

					$this->session->set_flashdata('message', 'Data produk telah ditambahkan');
					redirect(base_url($this->router->fetch_class().'/product'), 'refresh');
				}
			}
			else
			{
				$this->template->load('product/add');
			}
		}
		else
		{
			$this->template->load('product/add');
		}
	}

	/**
	 * Edit produk
	 *
	 * @param      integer  $id     product.id
	 */
	public function product_edit($id)
	{
		$product = $this->product->read(array('id' => $id));
		if ($product->num_rows() >= 1)
		{
			if ($this->input->method() == 'post')
			{
				$this->form_validation->set_rules('name', 'Nama Produk', 'trim|required');
				$this->form_validation->set_rules('price', 'Harga Produk', 'trim|numeric|required');

				if ($this->form_validation->run() == TRUE)
				{
					$image = $product->row()->image;

					if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
					{
						$config['upload_path'] = FCPATH.'uploads';
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('image'))
						{
							$image = $this->upload->data('file_name');
						}
						else
						{
							$image = FALSE;
							$data['upload_error'] = $this->upload->display_errors('<span class="help-block error">', '</span>');
							$this->template->load('product/add', $data);
						}
					}

					if ($image !== FALSE)
					{
						$this->product->update(array(
							'name' => $this->input->post('name'),
							'image' => $image,
							'price' => $this->input->post('price')
						), array('id' => $id));

						$this->session->set_flashdata('message', 'Data produk telah diperbaharui');
						redirect(base_url($this->router->fetch_class().'/product'), 'refresh');
					}
				}
				else
				{
					$this->template->load('product/add');
				}
			}
			else
			{
				$data['product'] = $product->row_array();
				$this->template->load('product/edit', $data);
			}
		}
		else
		{
			show_404();
		}
	}

	/**
	 * Hapus produk
	 *
	 * @param      integer  $id     product.id
	 */
	public function product_delete($id)
	{
		$this->product->delete(array('id' => $id));
		$this->session->set_flashdata('message', 'Data produk telah dihapus');
		redirect(base_url($this->router->fetch_class().'/product'), 'refresh');
	}

	/**
	 * Daftar Pesanan
	 */
	public function order()
	{
		$data['orders'] = $this->order->read();
		$this->template->load('order/home', $data);
	}

	/**
	 * Halaman tambah pesanan
	 */
	public function order_add()
	{
		$data['products'] = $this->product->read();
		$this->template->load('order/add', $data);
	}

	/**
	 * Tambah produk ke keranjang
	 */
	public function cart_add()
	{
		if (!empty($this->input->post('update')))
		{
			$data = array(
				'rowid'	=> $this->input->post('update'),
				'qty'	=> $this->input->post('quantity')
			);

			$this->session->set_flashdata('message', 'Produk dalam keranjang pesanan telah diperbaharui');
			$this->cart->update($data);
		}
		elseif (!empty($this->input->post('remove')))
		{
			$this->session->set_flashdata('message', 'Produk pesanan telah dihapus dari keranjang');
			$this->cart->remove($this->input->post('remove'));
		}
		else
		{
			$data = array(
				'id'		=> $this->input->post('id'),
				'qty'		=> $this->input->post('quantity'),
				'price'		=> $this->input->post('price'),
				'name'		=> $this->input->post('name')
			);

			$this->session->set_flashdata('message', 'Produk telah ditambahkan ke keranjang');
			$this->cart->insert($data);
		}

		redirect(base_url($this->router->fetch_class().'/order_add'), 'refresh');
	}

	/**
	 * Batalkan pesanan produk
	 */
	public function order_cancel()
	{
		$this->cart->destroy();
		$this->session->set_flashdata('message', 'Pesanan telah dibatalkan');
		redirect(base_url($this->router->fetch_class().'/order'), 'refresh');
	}

	/**
	 * Proses pesanan dalam keranjang
	 */
	public function order_next()
	{
		if ($this->input->method() == 'post')
		{
			$order = $this->order->create(array(
				'uid' => $this->input->post('order_uid'),
				'item' => $this->cart->total_items(),
				'total' => $this->cart->total(),
				'date' => nice_date(unix_to_human(now()), 'Y-m-d'),
				'time' => nice_date(unix_to_human(now()), 'H:i:s')
			), TRUE);

			foreach ($this->cart->contents() as $cart)
			{
				$this->cart_model->create(array(
					'order_id' => $order,
					'product_id' => $cart['id'],
					'name' => $cart['name'],
					'quantity' => $cart['qty'],
					'price' => $cart['price'],
					'subtotal' => $cart['subtotal']
				));
			}

			$this->cart->destroy();
			$this->session->set_flashdata('message', 'Pesanan telah dibuat <b>#'.$this->input->post('order_uid').'</b>');
			redirect(base_url($this->router->fetch_class().'/order'), 'refresh');
		}
		else
		{
			$data['code'] = random_string('alnum', 10);
			$data['order'] = $this->cart->contents();
			$this->template->load('order/next', $data);
		}
	}

	/**
	 * Detail pesanan
	 *
	 * @param      integer  $id     order.id
	 */
	public function order_detail($id)
	{
		$order = $this->order->read(array('id' => $id));
		if ($order->num_rows() >= 1)
		{
			$order = $order->row_array();
			$data['order'] = $order;
			$data['detail'] = $this->cart_model->read(array('order_id' => $order['id']))->result_array();
			$this->template->load('order/detail', $data);
		}
		else
		{
			show_404();
		}
	}

	/**
	 * Hapus pesanan
	 *
	 * @param      integer  $id     order.id
	 */
	public function order_delete($id)
	{
		$this->cart_model->delete(array('order_id' => $id));
		$this->order->delete(array('id' => $id));
		$this->session->set_flashdata('message', 'Data pesanan telah dihapus');
		redirect(base_url($this->router->fetch_class().'/order'), 'refresh');
	}

	/**
	 * Max Miner
	 */
	public function max_miner()
	{
		$orders = $this->order->read()->result_array();
		$cart = array();
		foreach ($orders as $key => $order)
		{
			$cart[$key] = array_map(function($cart) {
				return $cart['name'];
			}, $this->cart_model->read(array('order_id' => $order['id']))->result_array());
		}

		$associator = new Apriori($support = 0.3);
		$associator->train($cart, array());
		$data['associator'] = $associator;
		$this->template->load('max_miner/home', $data);
	}

	public function is_owned_data($val, $str)
	{
		$str = explode('.', $str);
		$data = $this->db->get('user', array($str[1] => $val));
		if ($data->num_rows() >= 1)
		{
			if ($data->row()->id == $str[2])
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('is_owned_data', lang('form_validation_is_unique'));
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}

		return FALSE;
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
	}

	public function register()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]|max_length[40]', array('is_unique' => 'Email sudah terdaftar!'));
			$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required|max_length[40]');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');

			if ($this->form_validation->run() == TRUE)
			{
				$this->user->create(array(
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password')),
					'full_name' => $this->input->post('full_name')
				));

				$this->session->set_flashdata('register', array('status' => 'success', 'message' => 'Pendaftaran berhasil!!'));
				redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
			}
			else
			{
				$this->load->view('admin/register');
			}
		}
		else
		{
			$this->load->view('admin/register');
		}
	}

	public function forgot_password()
	{
		if ($this->input->method() == 'post')
		{
			$search = $this->user->search($this->input->post('identity'));

			if ($search->num_rows() >= 1)
			{
				$code = random_string('numeric', 6);
				$this->load->library('email');
				$this->email->set_alt_message('Reset password');
				$this->email->to($search->row()->email);
				$this->email->from('no-reply@medansoftware.my.id', 'Medan Software');
				$this->email->subject('Ganti Kata Sandi');
				$data['link'] = base_url($this->router->fetch_class().'/reset_password/'.$code);
				$data['code'] = $code;
				$data['full_name'] = $search->row()->full_name;
				$this->email->message($this->load->view('email/reset_password', $data, TRUE));
				if (!$this->email->send())
				{
					$this->session->set_flashdata('forgot_password', array('status' => 'failed', 'message' => 'Sistem tidak bisa mengirim email!'));
					redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('forgot_password', array('status' => 'success', 'message' => 'Email permintaan atur ulang kata sandi sudah dikirim, silahkan verifikasi <a href="'.base_url($this->router->fetch_class().'/email_confirm').'">disini</a>'));
					redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('forgot_password', array('status' => 'failed', 'message' => 'Sistem tidak menemukan akun!'));
				redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
			}
		}
		else
		{
			$this->load->view('admin/forgot_password');
		}
	}

	public function email_confirm()
	{
		echo 'Confirm Code';
	}

	public function reset_password($code = NULL)
	{
		echo 'Reset Password';
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
