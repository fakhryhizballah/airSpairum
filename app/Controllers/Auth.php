<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\TokenModel;
use App\Models\HistoryModel;
use App\Models\VerifiedModel;
use CodeIgniter\I18n\Time;
use \Firebase\JWT\JWT;
use App\Libraries\AuthLibaries;


class Auth extends BaseController
{
	protected $authModel;
	public function __construct()
	{
		$this->UserModel = new UserModel();
		$this->OtpModel = new OtpModel();
		$this->TokenModel = new TokenModel();
		$this->HistoryModel = new HistoryModel();
		$this->VerifiedModel = new VerifiedModel();
		$this->Time = new Time('Asia/Jakarta');
		$this->email = \Config\Services::email();
		$this->AuthLibaries = new AuthLibaries();
		helper('text');
		helper('cookie');
	}

	public static string $key = 'ss';
	public function index()
	{
		$arr_cookie_options = array(
			'expires' => time() + 60 * 60 * 24 * 30,
			'path' => '/',
			'domain' => "", // leading dot for compatibility or use subdomain
			'secure' => true,     // or false
			'httponly' => false,    // or false
			'samesite' => 'None' // None || Lax  || Strict
		);

		setCookie("theme-color", "blue-theme",  $arr_cookie_options);

		if (empty($_COOKIE['X-Sparum-Token'])) {
			$data = [
				'title' => 'Login - Spairum',
				'validation' => \Config\Services::validation()
			];
			return view('auth/masuk', $data);
		} else {
			if ($_COOKIE['X-Sparum-Token'] == 'Logout') {
				$data = [
					'title' => 'Login - Spairum',
					'validation' => \Config\Services::validation()
				];
				return view('auth/masuk', $data);
			}
			return redirect()->to('/user');
		}
	}
	public function masuk()
	{
		$arr_cookie_options = array(
			'expires' => time() + 60 * 60 * 24 * 30,
			'path' => '/',
			'domain' => "", // leading dot for compatibility or use subdomain
			'secure' => true,     // or false
			'httponly' => false,    // or false
			'samesite' => 'None' // None || Lax  || Strict
		);

		if (empty($_COOKIE['theme-color'])) {
			setCookie("theme-color", "blue-theme",  $arr_cookie_options);
		}
		$data = [
			'title' => 'Login - Air Spairum',
			'validation' => \Config\Services::validation()
		];
		// return view('layout/authLayout');
		return view('auth/masuk', $data);
	}

	//--------------------------------------------------------------------

	public function login()
	{
		// dd($this->request->getVar());
		$nama = $this->request->getVar('nama');
		// $password = password_verify($this->request->getVar('password'), PASSWORD_BCRYPT);
		$pas = ($this->request->getVar('password'));
		// $level = $this->request->getVar('level');
		//validasi	
		if (!$this->validate([
			'nama' => [
				'rules'  => 'required',
				'errors' => [
					'required' => '{field} wajid di isi'
				]
			],
		])) {
			$validation = \config\Services::validation();
			return redirect()->to('/')->withInput()->with('validation', $validation);
		}
		$data = [
			'title' => 'Registrasi',
			'validation' => \Config\Services::validation()
		];
		$cek = $this->UserModel->cek_login($nama);
		// dd($cek);
		if (empty($cek)) {
			session()->setFlashdata('gagal', 'Akun tidak terdaftar');
			return redirect()->to('/');
		}
		$password = password_verify($pas, ($cek['password']));
		//dd($password);

		if (($cek['password'] == $password)) {
			//dd($cek);
			// session()->set('nama', $cek['nama']);
			// session()->set('id_user', $cek['id_user']);

			$token = random_string('alnum', 28);
			$key = $this->TokenModel->Key()['token'];
			$payload = array(
				'Key' => $token,
				'id_user' => $cek['id_user'],
				'nama' => $cek['nama']
			);
			$jwt = JWT::encode($payload, $key,);

			$this->TokenModel->save([
				'id_user' => $cek['id_user'],
				'token'    => $token,
				'status' => 'Login'
			]);


			$arr_cookie_options = array(
				'expires' => time() + 60 * 60 * 24 * 60,
				'path' => '/',
				'domain' => "", // leading dot for compatibility or use subdomain
				'secure' => true,     // or false
				'httponly' => false,    // or false
				'samesite' => 'None' // None || Lax  || Strict
			);
			setCookie("X-Sparum-Token", $jwt, $arr_cookie_options);

			if (empty($_COOKIE['theme-color'])) {
				setCookie("theme-color", "teal-theme",  $arr_cookie_options);
			}

			return redirect()->to('/user');
		} else {
			session()->setFlashdata('gagal', 'Username atau Password salah');
			return redirect()->to('/');
		}
	}

	//--------------------------------------------------------------------

	public function logout()
	{
		$jwt = $_COOKIE['X-Sparum-Token'];
		$key = $this->TokenModel->Key()['token'];
		$decoded = JWT::decode($jwt, $key, array('HS256'));
		$token = $decoded->Key;
		$id = $this->TokenModel->cek($token)['id'];
		$this->TokenModel->update($id, [
			'token'    => "Keluar",
			'status' => 'logout'
		]);
		$arr_cookie_options = array(
			'expires' => time() + 60 * 60 * 24 * 30,
			'path' => '/',
			'domain' => "", // leading dot for compatibility or use subdomain
			'secure' => true,     // or false
			'httponly' => false,    // or false
			'samesite' => 'None' // None || Lax  || Strict
		);
		session()->setFlashdata('flash', 'Berhasil Logout');
		// setCookie("X-Sparum-Token", "Logout", time() + (86400 * 30), "/");
		setCookie("X-Sparum-Token", "Logout", time() + (86400 * 30), "/");
		return redirect()->to('/');
	}

	// public function regis()
	// {

	// 	$data = [
	// 		'title' => 'Registrasi',
	// 		'validation' => \Config\Services::validation()
	// 	];
	// 	return view('auth/regis', $data);
	// }
	public function daftar()
	{
		if (session()->get('id_user') == '') {
			$data = [
				'title' => 'Registrasi',
				'validation' => \Config\Services::validation()
			];
			return view('auth/daftar', $data);
		} else {
			return redirect()->to('/user');
		}
	}

	public function userSave()
	{
		//validasi
		if (!$this->validate([
			'nama' => [
				'rules'  => 'required|alpha_dash|is_unique[user.nama]',
				'errors' => [
					'required' => 'username wajid di isi',
					'alpha_dash' => 'Tidak boleh mengunakan spasi',
					'is_unique' => 'Nama Account sudah terdaftar'
				]
			],
			'fullname' => [
				'rules'  => 'required|alpha_space',
				'errors' => [
					'required' => '{field} wajid di isi',
				]
			],
			// 'nama_depan' => [
			// 	'rules'  => 'required|alpha_space', 
			// 	'errors' => [
			// 		'required' => '{field} wajid di isi',
			// 	]
			// ],
			// 'nama_belakang' => [
			// 	'rules'  => 'required',
			// 	'errors' => [
			// 		'required' => '{field} wajid di isi',
			// 	]
			// ],
			'email' => [
				'rules'  => 'required|valid_email|is_unique[user.email]',
				'errors' => [
					'required' => '{field} wajid di isi',
					'valid_email' => 'alamat email tidak benar',
					'is_unique' => '{field} sudah terdaftar'
				]
			],
			'telp' => [
				'rules'  => 'required|is_natural|min_length[10]|is_unique[user.telp]',
				'errors' => [
					'required' => 'nomor telpon wajid di isi',
					'is_natural' => 'nomor telpon tidak benar',
					'min_length' => 'nomor telpon tidak valid',
					'is_unique' => 'nomor telp sudah terdaftar'
				]
			],
			'password' => [
				'rules'  => 'required|min_length[8]',
				'errors' => [
					'required' => '{field} wajid di isi',
					'min_length[8]' => '{field} Minimal 8 karakter'
				]
			],
			'password2' => [
				'rules'  => 'required|matches[password]',
				'errors' => [
					'required' => 'password wajid di isi',
					'matches' => 'password tidak sama'
				]
			]

		])) {
			$validation = \config\Services::validation();

			// return redirect()->to('/daftar')->withInput()->with('validation', $validation);
		}
		$data = [
			'title' => 'Registrasi',
			'validation' => \Config\Services::validation()
		];
		//dd($this->request->getVar());
		$time = $this->Time::now('Asia/Jakarta');
		$id = $this->request->getVar('nama');
		$gen = random_string('alnum', 5);
		$id_usr = substr(sha1($id), 0, 10);
		helper('text');
		$token = random_string('alnum', 28);
		$email = $this->request->getVar('email');
		$user = $this->request->getVar('nama');
		// $nama_depan =  ucwords($this->request->getVar('nama_depan'));
		// $nama_belakang = ucwords($this->request->getVar('nama_belakang'));
		$fullname = ucwords($this->request->getVar('fullname'));
		$telp = $this->request->getVar('telp');
		$pars_nama = explode(" ", $fullname);
		$nama_belakang = "";
		for ($i = 1; $i < count($pars_nama); $i++) {
			$nama_belakang .= $pars_nama[$i] . " ";
		}
		$this->OtpModel->save([
			'id_user' => "$id_usr$gen",
			'nama' => $user,
			// 'nama_depan' => $nama_depan,
			// 'nama_belakang' => $nama_belakang,
			'nama_depan' => $pars_nama[0],
			'nama_belakang' => $nama_belakang,
			'email' => $email,
			'telp' => $telp,
			'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
			'link' => $token,
			'status' => 'belum verifikasi'
		]);
		$this->UserModel->save([
			'id_user' => "$id_usr$gen",
			'nama' => $user,
			// 'nama_depan' => $nama_depan,
			// 'nama_belakang' => $nama_belakang,
			'nama_depan' => $pars_nama[0],
			'nama_belakang' => $nama_belakang,
			'email' => $email,
			'telp' => $telp,
			'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
			'profil' => 'user.png',
			'debit' => '0',
			'kredit' => '0',
		]);
		$this->VerifiedModel->save([
			'id_user' => "$id_usr$gen",
			'email_status' => "unverified",
			'verified_email_date' => $time,
			'token_email' => $token,
			'whatsapp_status' => "unverified",
			'verified_wa_date' => $time,
			'token_wa' => "$token$gen",
		]);
		$masage = [
			"message" => "$fullname mendaftar air.spairum.my.id",
				"number" => "0895321701798"
			];
		$masage2 = [
				"message" => "$fullname mendaftar air.spairum.my.id",
				"number" => "082254894778"
			];
		$masage3 = [
				"message" => "Hallo kak $fullname, salam kenal aku admin spairum",
				"number" => "$telp"
			];
		$masage4 = [
				"message" => "Terimakasih telah membuat akun spairum silahkan melakukan untuk mendapatkan saldo isi ulang air 1000 secara gratis silahkan klik link berikut --> https://air.spairum.my.id/token_wa/$token$gen",
				"number" => "$telp"
			];
		$this->AuthLibaries->sendWa($masage3);
		$this->AuthLibaries->sendWa($masage);
		$this->AuthLibaries->sendWa($masage2);
		$this->AuthLibaries->sendWa($masage4);
		$this->email->setFrom('infospairum@gmail.com', 'noreply-spairum');
		$this->email->setTo($email);
		// $this->email->setBCC('falehry88@gmail.com');
		$this->email->setSubject('Verification Email Spairum');
		$this->email->setMessage("
		<table align='center' cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#f0f0f0'>
		<tr>
			<td style='padding: 30px 30px 20px 30px;'>
				<table cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#ffffff' style='max-width: 650px; margin: auto;'>
					<tr>
						<td colspan='2' align='center' style='background-color: #0d8eff; padding: 40px;'>
							<a href='https://spairum.my.id/' target='_blank'><img src='https://spairum.my.id/Asset/img/spairum.png' width='50%' border='0' /></a>
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center' style='padding: 50px 50px 0px 50px;'>
							<h2 style='padding-right: 0em; margin: 0; line-height: 40px; font-weight:300; font-family: ' Nunito Sans ', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 1em;'>
							Mari kita gunakan Botol minum untuk mengurangi sampah plastik. 
								<Br>Refill Your Tumbler</Br>
							</h2>
						</td>
					</tr>
					<tr>
						<td style='text-align: left; padding: 0px 50px;' valign='top'>
							<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: ' Nunito Sans ', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
								Hi $fullname,
							</p>
							<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: ' Nunito Sans ', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
								Terimakasih telah membuat akun spairum silahkan melakukan untuk mendapatkan saldo isi ulang air 2000 secara gratis silahkan klik tombol dibawah ini:
							</p>
							<br>
							<a href='https://air.spairum.my.id/otp/$token' style='display:block;width:115px;height:25px;background:#0008ff;padding:10px;text-align:center;border-radius:5px;color:white;font-weight:bold'>Mau dong</a>
							<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: ' Nunito Sans ', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'><br/>Jika ada masukan atau pertanyaan bisa langsung menghubungi :
								<br/>Technical Support Spairum
								<br/>Fakhry Hizballah : <a href='http://wa.me/+62895321701798'>+62895321701798</a></p>
						</td>
					</tr>
					<tr>
						<td style='text-align: left; padding: 30px 50px 50px 50px' valign='top'>
							<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: ' Nunito Sans ', Arial, Verdana, Helvetica, sans-serif; color: #505050; text-align: left;'>
								Thanks and best regards<br/>
							</p>
							<br> Spairum Team
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center' style='padding: 20px 40px 40px 40px;' bgcolor='#f0f0f0'>
							<p style='font-size: 12px; margin: 0; line-height: 24px; font-family: ' Nunito Sans ', Arial, Verdana, Helvetica, sans-serif; color: #777;'>
								&copy; 2021
								<a href='https://spairum.my.id/about' target='_blank' style='color: #777; text-decoration: none'>Spairum.my.id</a>
								<br> Jl.Merdeka, Pontianak - Kalimantan Barat
								<br> Indonesia
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>");
		// $this->email->send();
		if ($this->email->send()) {
			$token = random_string('alnum', 28);
			$key = $this->TokenModel->Key()['token'];
			$payload = array(
				'Key' => $token,
				'id_user' => "$id_usr$gen",
				'nama' =>  $user
			);
			$jwt = JWT::encode($payload, $key,);

			$this->TokenModel->save([
				'id_user' => "$id_usr$gen",
				'token'    => $token,
				'status' => 'Login'
			]);
			$arr_cookie_options = array(
				'expires' => time() + 60 * 60 * 24 * 30,
				'path' => '/',
				'domain' => "", // leading dot for compatibility or use subdomain
				'secure' => true,     // or false
				'httponly' => false,    // or false
				'samesite' => 'None' // None || Lax  || Strict
			);
			setCookie("X-Sparum-Token", $jwt, $arr_cookie_options);

			if (empty($_COOKIE['theme-color'])) {
				setCookie("theme-color", "lightblue-theme",  $arr_cookie_options);
			}
			return redirect()->to('/user');
		} else {
			$data = $email->printDebugger(['headers']);
			print_r($data);
		}

		session()->setFlashdata('flash', 'Silakan cek kotak masuk email atau spam untuk verifikasi.');
		return redirect()->to('/');
	}
	public function verified_wa($link)
	{
		$cek = $this->VerifiedModel->cekWa($link);
		if (empty($cek)) {
			session()->setFlashdata('gagal', 'Akun sudah di verifikasi');
			return redirect()->to('/');
		}
		$time = $this->Time::now('Asia/Jakarta');
		$token = substr(sha1($cek['token_wa']), 0, 10);
		$user = $this->UserModel->cek_id($cek['id_user']);
		$debit = $user['debit'] + 1000;
		$token = substr(sha1($cek['link']), 0, 10);
		$data = [
			'debit' => $debit,
		];
		$this->UserModel->updateprofile($data, $user['id']);

		$this->VerifiedModel->save([
			'id' => $cek['id'],
			'whatsapp_status' => "verified",
			'verified_wa_date' => $time,
			'token_wa' => $token
		]);
		$datavocer = [
			'id_master' => $cek['id_user'],
			'Id_slave' => 'Admin',
			'Lokasi' => 'Verifikasi',
			'status' => 'Verifikasi nomor telpon',
			'created_at' => $this->Time::now('Asia/Jakarta')
		];
		$this->HistoryModel->save($datavocer);
		session()->setFlashdata('flash', 'Terima kasih nomor telpon anda telah diverifikasi');
		return redirect()->to('/user');
	}

	public function otp($link)
	{
		$cek = $this->OtpModel->cek($link);
		if (empty($cek)) {
			session()->setFlashdata('gagal', 'Akun sudah di verifikasi');
			return redirect()->to('/');
		}
		$time = $this->Time::now('Asia/Jakarta');
		$user = $this->UserModel->cek_id($cek['id_user']);
		$cek_Verified = $this->VerifiedModel->cek_id($cek['id_user']);
		$debit = $user['debit'] + 2000;
		$token = substr(sha1($cek['link']), 0, 10);
		$data = [
			'debit' => $debit,
		];
		$this->UserModel->updateprofile($data, $user['id']);
		$datavocer = [
			'id_master' => $cek['id_user'],
			'Id_slave' => 'Admin',
			'Lokasi' => 'Bonus',
			'status' => 'Verifikasi Email',
			'isi' => $debit,
			'created_at' => $this->Time::now('Asia/Jakarta')
		];
		$this->HistoryModel->save($datavocer);
		$this->OtpModel->save([
			'id' => $cek['id'],
			'link' => $token,
			'status' => 'terverifikasi',
		]);
		$this->VerifiedModel->save([
			'id' => $cek_Verified['id'],
			'email_status' => "verified",
			'verified_email_date' => $time,
			'token_email' => $token,
		]);
		session()->setFlashdata('flash', 'Selamat anda mendapatkan saldo air 2000');
		return redirect()->to('/user');
	}
	public function lupa()
	{
		// if (!$this->AuthLibaries->authCek()) {

		// 	return redirect()->to('/user');
		// }
		$data = [
			'title' => 'Lupa Password',
			'validation' => \Config\Services::validation()
		];
		return view('auth/lupa', $data);
	}
	public function sendemail()
	{
		if (!$this->validate([
			'email' => [
				'rules'  => 'required|valid_email',
				'errors' => [
					'required' => '{field} wajid di isi',
					'valid_email' => 'alamat email tidak benar',
				]
			]
		])) {
			$validation = \config\Services::validation();
			// dd($this->request->getVar());
			return redirect()->to('/lupa')->withInput()->with('validation', $validation);
		}
		helper('text');
		$token = random_string('alnum', 28);
		$kode = substr(random_string('numerik', 4), 0, 4);
		$email = $this->request->getVar('email');
		$cek = $this->UserModel->cek_login($email);
		if (empty($cek)) {
			session()->setFlashdata('Pesan', 'Akun tidak terdaftar');
			return redirect()->to('/daftar');
		}
		$id_user = $cek['id_user'];
		$cekid = $this->OtpModel->cekid($id_user);
		$this->OtpModel->save([
			'id' => $cekid['id'],
			'link' =>  $token,
			'status' => 'Lupa Password',
		]);
		$nama_depan = $cek['nama_depan'];
		$nama_belakang = $cek['nama_belakang'];
		session()->set('token', $kode);
		session()->set('id', $id_user);

		$this->email->setFrom('infospairum@gmail.com', 'noreply-spairum');
		$this->email->setTo($email);
		$this->email->setSubject('Lupa Password Akun Spairum');
		$this->email->setMessage(
			"
			<table align='center' cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#f0f0f0'>
		    <tr>
		    <td style='padding: 30px 30px 20px 30px;'>
		        <table cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#ffffff' style='max-width: 650px; margin: auto;'>
		        <tr>
		            <td colspan='2' align='center' style='background-color: #0d8eff; padding: 40px;'>
		                <a href='http://spairum.my.id/' target='_blank'><img src='https://spairum.my.id/Asset/img/spairum.png' width='50%' border='0' /></a>
		            </td>
		        </tr>
		        <tr>
		            <td colspan='2' align='center' style='padding: 50px 50px 0px 50px;'>
		                <h1 style='padding-right: 0em; margin: 0; line-height: 40px; font-weight:300; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 1em;'>
		                    Email Spairum ini Untuk mengganti password akun
		                </h1>
		            </td>
		        </tr>
		        <tr>
		            <td style='text-align: left; padding: 0px 50px;' valign='top'>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
		                    Hi $nama_depan $nama_belakang,
		                </p>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
		                Untuk menganti password baru anda bisa klik tautan pada tautan dibawah :
		                </p>
		                <a href='https://air.spairum.my.id/auth/changepassword/$token' style='display:block;width:115px;height:25px;background:#0008ff;padding:10px;text-align:center;border-radius:5px;color:white;font-weight:bold'> Ganti Password sekarang</a>
						<br>
						<p>Atau Gunakan Kode </p>
						<h3>$kode</h3>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'><br/>*Jangan pernah memberitahukan kode tersebut ke orang lain.</p>

						</td>
		        </tr>
		        <tr>
		            <td style='text-align: left; padding: 30px 50px 50px 50px' valign='top'>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #505050; text-align: left;'>
		                    Thanks,<br/>
		                </p>
		            </td>
		        </tr>
		        <tr>
		            <td colspan='2' align='center' style='padding: 20px 40px 40px 40px;' bgcolor='#f0f0f0'>
		                <p style='font-size: 12px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #777;'>
		                    &copy; 2020
		                    <a href='https://spairum.my.id/about' target='_blank' style='color: #777; text-decoration: none'>Spairum-Pay</a>
		                    <br>
		                    Jl.Merdeka, Pontianak - Kalimantan Barat
		                    <br>
		                    Indonesia
		                </p>
		            </td>
		        </tr>
		        </table>
		    </td>
		    </tr>
		    </table>
		    "
		);
		$this->email->send();
		session()->setFlashdata('Berhasil', 'Silakan cek kotak masuk email atau spam untuk verifikasi ganti password akun.');
		return redirect()->to('/auth/otplupa');
	}
	public function otplupa()
	{
		$data = [
			'title' => 'Change Password | Spairum.com',
			'validation' => \Config\Services::validation()
		];
		return view('/auth/otplupa', $data);
	}

	public function changepassword($link = NULL)
	{

		$cek = $this->OtpModel->cek($link);
		if (!empty($cek)) {
			$id_user = $cek['id_user'];
			session()->set('id', $id_user);

			$this->OtpModel->save([
				'id' => $cek['id'],
				'link' => substr(sha1($cek['link']), 0, 10),
				'status' => 'Password di ganti (Link)',
			]);
			return redirect()->to('/auth/change_password');
		}

		$token = $this->request->getVar('otp');
		if (session()->get('token') == $token) {
			if (session()->get('token') == '') {
				session()->setFlashdata('gagal', 'Mau Kemana');
				return redirect()->to('/');
			}
			$id_user = session()->get('id');

			$cek = $this->OtpModel->cekid($id_user);

			$this->OtpModel->save([
				'id' => $cek['id'],
				'link' => substr(sha1($cek['link']), 0, 10),
				'status' => 'Password di ganti (OTP)',
			]);
			// return view('user/change_password', $data);
			return redirect()->to('/auth/change_password');
		}
		session()->setFlashdata('gagal', 'Kode OTP Salah');
		return redirect()->to('/auth/otplupa');
	}

	public function change_password()
	{
		if (session()->get('token') == '') {
			session()->setFlashdata('gagal', 'Mau Kemana');
			return redirect()->to('/');
		}

		$id_user = session()->get('id');

		$akun = $this->UserModel->cek_id($id_user);
		$data = [
			'title' => 'Change Password | Spairum.com',
			'akun' => $akun,
			'validation' => \Config\Services::validation()
		];
		return view('auth/change_password', $data);
	}

	public function passwordupdate()
	{
		if (session()->get('token') == '') {
			session()->setFlashdata('gagal', 'Mau Kemana');
			return redirect()->to('/');
		}

		$id_user = session()->get('id');
		$password = $this->request->getVar('password2');
		if (!$this->validate([
			'password' => [
				'rules'  => 'required|min_length[8]',
				'errors' => [
					'required' => '{field} wajid di isi',
					'min_length[8]' => '{field} Minimal 8 karakter'
				]
			],
			'password2' => [
				'rules'  => 'required|matches[password]',
				'errors' => [
					'required' => 'password wajid di isi',
					'matches' => 'password tidak sama'
				]
			]
		])) {
			$validation = \config\Services::validation();
			// dd($this->request->getVar());
			return redirect()->to('/auth/change_password')->withInput()->with('validation', $validation);
		}

		$user = $this->UserModel->cek_id($id_user);
		$cek = $this->OtpModel->cekid($id_user);
		$newPassword = password_hash($password, PASSWORD_BCRYPT);
		$this->OtpModel->save([
			'id' => $cek['id'],
			'link' => substr(sha1($cek['link']), 0, 20),
			'password' => $newPassword,
			'status' => 'Tercerivikasi Password Baru',
		]);
		$this->UserModel->save([
			'id' => $user['id'],
			'password' => $newPassword,
		]);
		$this->HistoryModel->save([
			'id_master' => $user['id_user'],
			'Id_slave' => "User",
			'Lokasi' => "Lupa Password",
			'status' => 'Password telah di perbahrui',
		]);
		session_destroy();
		session()->setFlashdata('Berhasil', 'Password anda telah diperbaharui.');
		return redirect()->to('/');
	}
	public function waOTP()
	{
		$curl = curl_init();
		$nama = ("nama");
		$data_pesan = array(
			'number' => '0895321701798',
			'message' => $nama
		);

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://10.8.0.3:8000/send-message',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data_pesan,
			// CURLOPT_POSTFIELDS => $masage['nama_depan'],
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// dd($response);
		echo $response;
		return;
	}

	public function tes()
	{
		$payload = array(
			"Key" => "Login Spairum",
			"User" => "password",
		);
		$jwt = JWT::encode($payload, self::$key,);
		$decoded = JWT::decode($jwt, self::$key, array('HS256'));

		print_r($decoded);
		print_r($jwt);
	}
	public function reMaill($email)
	{
		// dd($this->Time::now('Asia/Pontianak'));
		// dd($email);
		$this->email->setFrom('infospairum@gmail.com', 'noreply-spairum');
		$this->email->setTo($email);
		$this->email->setSubject('OTP Verification Test');
		$this->email->setMessage(
			"
			<table align='center' cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#f0f0f0'>
		    <tr>
		    <td style='padding: 30px 30px 20px 30px;'>
		        <table cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#ffffff' style='max-width: 650px; margin: auto;'>
		        <tr>
		            <td colspan='2' align='center' style='background-color: #0d8eff; padding: 40px;'>
		                <a href='http://spairum.my.id/' target='_blank'><img src='https://spairum.my.id/Asset/img/spairum.png' width='50%' border='0' /></a>
		            </td>
		        </tr>
		        <tr>
		            <td colspan='2' align='center' style='padding: 50px 50px 0px 50px;'>
		                <h1 style='padding-right: 0em; margin: 0; line-height: 40px; font-weight:300; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 1em;'>
		                    Email Spairum ini Untuk mengganti password akun
		                </h1>
		            </td>
		        </tr>
		        <tr>
		            <td style='text-align: left; padding: 0px 50px;' valign='top'>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
		                    Hi nama_depan nama_belakang,
		                </p>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
		                Untuk menganti password baru anda bisa klik tautan pada tautan dibawah :
		                </p>
		                <a href='https://air.spairum.my.id/auth/changepassword/token' style='display:block;width:115px;height:25px;background:#0008ff;padding:10px;text-align:center;border-radius:5px;color:white;font-weight:bold'> Ganti Password sekarang</a>
						<br>
						<p>Atau Gunakan Kode </p>
						<h3>kode</h3>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'><br/>*Jangan pernah memberitahukan kode tersebut ke orang lain.</p>

						</td>
		        </tr>
		        <tr>
		            <td style='text-align: left; padding: 30px 50px 50px 50px' valign='top'>
		                <p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #505050; text-align: left;'>
		                    Thanks,<br/>
		                </p>
		            </td>
		        </tr>
		        <tr>
		            <td colspan='2' align='center' style='padding: 20px 40px 40px 40px;' bgcolor='#f0f0f0'>
		                <p style='font-size: 12px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #777;'>
		                    &copy; 2020
		                    <a href='https://spairum.my.id/about' target='_blank' style='color: #777; text-decoration: none'>Spairum-Pay</a>
		                    <br>
		                    Jl.Merdeka, Pontianak - Kalimantan Barat
		                    <br>
		                    Indonesia
		                </p>
		            </td>
		        </tr>
		        </table>
		    </td>
		    </tr>
		    </table>
		    "
		);

		// d($this->email->send());
		d($this->email->printDebugger(['headers']));
		if ($this->email->send(true)) {
			echo "email_sent";
		} else {
			echo "email_not_sent";
		}
	}
}
