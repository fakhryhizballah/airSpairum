<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\TokenModel;
use App\Models\HistoryModel;
use App\Models\VerifiedModel;
use CodeIgniter\I18n\Time;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use App\Libraries\AuthLibaries;
use App\Libraries\SetStatic;
use App\Controllers\Oauth;

use CodeIgniter\Cookie\Cookie;
use DateTime;


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
		$this->SetStatic = new SetStatic();
		$this->Oauth = new Oauth();
		helper('text');
		helper('cookie');
	}

	public static string $key = 'ss';
	public function index()
	{
		setCookie("theme-color", "blue-theme",  SetStatic::cookie_options());
		$urlOauth = $this->Oauth->redirect();
		// dd($urlOauth);

		try {
			$akun = $this->AuthLibaries->authCek();
			if ($akun == null) {
				$data = [
					'title' => 'Air Spairum',
					'validation' => \Config\Services::validation(),
					'urlOauth' => $urlOauth
				];
				return view('auth/masuk', $data);
			}
			// return redirect()->to('/user');
		} catch (\Exception $e) {
			$data = [
				'title' => 'Air Spairum',
				'validation' => \Config\Services::validation(),
				'urlOauth' => $urlOauth
				];
				return view('auth/masuk', $data);
			}
		return redirect()->to('/user');
	}
	public function welcome()
	{
		$data = [
			'title' => 'Air Spairum',
		];
		return view('onboarding', $data);
	}
	public function masuk()
	{
		if (empty($_COOKIE['theme-color'])) {
			setCookie("theme-color", "blue-theme",  SetStatic::cookie_options());
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

			// $key = $this->TokenModel->Key()['token'];
			$key = getenv('tokenkey');
			$payload = array(
				'Key' => $token,
				'id_user' => $cek['id_user'],
				'nama' => $cek['nama']
			);
			$jwt = JWT::encode($payload, $key, 'HS256');

			$this->TokenModel->save([
				'id_user' => $cek['id_user'],
				'token'    => $token,
				'status' => 'Login'
			]);

			setCookie("X-Sparum-Token", $jwt, SetStatic::cookie_options());

			if (empty($_COOKIE['theme-color'])) {
				setCookie("theme-color", "teal-theme", SetStatic::cookie_options());
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
		// $key = $this->TokenModel->Key()['token'];
		$key = getenv('tokenkey');
		// $decoded = JWT::decode($jwt, $key, array('HS256'));
		$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
		$token = $decoded->Key;
		$id = $this->TokenModel->cek($token)['id'];
		$this->TokenModel->update($id, [
			'token'    => "Keluar",
			'status' => 'logout'
		]);

		session()->setFlashdata('flash', 'Berhasil Logout');
		// setCookie("X-Sparum-Token", "Logout", time() + (86400 * 30), "/");
		setCookie("X-Sparum-Token", "Logout", SetStatic::cookie_options());
		return redirect()->to('/');
	}

	public function daftar()
	{
		$akun = $this->AuthLibaries->authCek();
		if ($akun == null) {
				$data = [
					'title' => 'Air Spairum',
					'validation' => \Config\Services::validation()
				];
				return view('auth/daftar', $data);
			}
		return redirect()->to('/user');
		// if (empty($_COOKIE['X-Sparum-Token'])) {
		// 	$data = [
		// 		'title' => 'Air Spairum',
		// 		'validation' => \Config\Services::validation()
		// 	];
		// 	return view('auth/daftar', $data);
		// } else {
		// 	if ($_COOKIE['X-Sparum-Token'] == 'Logout') {
		// 		$data = [
		// 			'title' => 'Air Spairum',
		// 			'validation' => \Config\Services::validation()
		// 		];
		// 		return view('auth/daftar', $data);
		// 	}
		// 	return redirect()->to('/user');
		// }
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

			return redirect()->to('/daftar')->withInput()->with('validation', $validation);
		}
	
		helper('text');
		$time = $this->Time::now('Asia/Jakarta');
		$id = $this->request->getVar('nama');
		$gen = random_string('alnum', 5);
		$id_usr = substr(sha1($id), 0, 10);
		$token = random_string('alnum', 28);
		$email = $this->request->getVar('email');
		$user = $this->request->getVar('nama');
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
		$message =
			[
				'message' => "$fullname mendaftar air.spairum.my.id",
				'grup' => "New User Spairum",
			];
		$this->AuthLibaries->sendMqtt("sendGrup", json_encode($message), $user);
		$PesanWA = array(
			[
				"message" => "Hallo kak $fullname, salam kenal aku admin spairum",
				"number" => "$telp"
			],
			[
				"message" => "Sebelumnya terimakasih ya telah membuat akun spairum, khusus untuk kak $fullname ada *Saldo air Gratis 1000*",
				"number" => "$telp"
			],
			[
				"message" => " untuk mendapatkan saldo isi ulang air 1000 secara gratis silahkan balas *Mau* untuk mengkatifkan link dan klik link berikut --> https://air.spairum.my.id/token_wa/$token$gen",
				"number" => "$telp"
			]

		);
		foreach ($PesanWA as $value) {
			$this->AuthLibaries->sendWa($value);
		}
		$pesanEmail = ([
			'email' => $email,
			'fullname' => $fullname,
			'token' => $token,
			'subject' => 'Konfirmasi Email akun Spairum Anda',
			'status' => 'otp',
			'id_user' => "$id_usr$gen"
		]);
		$this->AuthLibaries->sendMqtt('Email/sendEmailOtp', json_encode($pesanEmail), $user);
		$token = random_string('alnum', 28);
		// $key = $this->TokenModel->Key()['token'];
		$key = getenv('tokenkey');
		$payload = array(
			'Key' => $token,
			'id_user' => "$id_usr$gen",
			'nama' =>  $user
		);
		$jwt = JWT::encode($payload, $key, 'HS256');
		$this->TokenModel->save([
			'id_user' => "$id_usr$gen",
			'token'    => $token,
			'status' => 'Login'
		]);
		setCookie("X-Sparum-Token", $jwt, SetStatic::cookie_options());

		if (empty($_COOKIE['theme-color'])) {
			setCookie("theme-color", "lightblue-theme",  SetStatic::cookie_options());
		}
		return redirect()->to('/user');
	}

	public function verified_wa($link)
	{
		$cek = $this->VerifiedModel->cekWa($link);
		if (empty($cek)) {
			session()->setFlashdata('gagal', 'Akun sudah di verifikasi');
			return redirect()->to('/');
		}
		$time = $this->Time::now('Asia/Jakarta');
		$token = substr(sha1($cek['token_wa']), 0, 12);
		$user = $this->UserModel->cek_id($cek['id_user']);
		$cekotp = $this->OtpModel->cekid($user['id_user']);
		$debit = $user['debit'] + 1000;
		$data = [
			'debit' => $debit,
			'telp' => $cekotp['telp'],
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
			'Lokasi' => 'Bonus',
			'status' => 'Verifikasi nomor telpon',
			'isi' => 1000,
			'created_at' => $this->Time::now('Asia/Jakarta')
		];
		$this->HistoryModel->save($datavocer);
		$kontak = [
			"givenName" => $user['nama_depan'],
			"familyName" => $user['nama_belakang'],
			"emailAddresses" => $user['email'],
			"phoneNumbers" => $cekotp['telp'],
		];
		$this->AuthLibaries->sendMqtt('contact/createContact', json_encode($kontak), $user['nama_depan']);
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
		$cek_Verified = $this->VerifiedModel->cekid($cek['id_user']);
		$debit = $user['debit'] + 2000;
		$token = substr(sha1($cek['link']), 0, 10);
		$data = [
			'debit' => $debit,
			'email' => $user['email'],
		];
		$this->UserModel->updateprofile($data, $user['id']);
		$datavocer = [
			'id_master' => $cek['id_user'],
			'Id_slave' => 'Admin',
			'Lokasi' => 'Bonus',
			'status' => 'Verifikasi Email',
			'isi' => 2000,
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
			'title' => 'Lupa Password | Air Spairum',
			'validation' => \Config\Services::validation()
		];
		// return view('auth/lupa', $data);
		return view('auth/lupa_pas', $data);
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
		$pesanEmail = ([
			'email' => $email,
			'fullname' => "$nama_depan $nama_belakang",
			'token' => $token,
			'subject' => 'Konfirmasi Reset password akun Spairum Anda',
			'status' => 'forget',
			'id_user' => $id_user,
			'kode' => $kode

		]);
		$this->AuthLibaries->sendMqtt('Email/sendEmailOtp', json_encode($pesanEmail), $id_user);
		$PesanWA = array(
			[
				"message" =>
				"Hi kak $nama_depan $nama_belakang apakah anda lupa password akun Spairum anda ? klik link dibawah ini untuk mereset password anda https://air.spairum.my.id/auth/changepassword/$token",
				"number" => $cek['telp']
			],
			[
				"message" => "Atau bisa mengunakan kode OTP *$kode* untuk mereset password anda. Kode OTP jangan berikan kepada siapapun",
				"number" => $cek['telp']
			],
		);
		foreach ($PesanWA as $value) {
			$this->AuthLibaries->sendWa($value);
		}
		session()->setFlashdata('Berhasil', 'Silakan cek kotak masuk email atau spam untuk verifikasi ganti password akun.');
		return redirect()->to('/auth/otplupa');
	}
	public function otplupa()
	{
		$data = [
			'title' => 'Change Password | Spairum.com',
			'validation' => \Config\Services::validation()
		];
		// session()->setFlashdata('gagal', 'gagal tes flash');
		return view('/auth/otp', $data);
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
// validation Email
	public function verificationEmail()
	{
		$akun = $this->AuthLibaries->authCek();
		$cek_token = $this->VerifiedModel->cekid($akun['id_user']);
		if ($cek_token['email_status'] == 'verified') {
			return redirect()->to('/');
		}
		$data = [
			'title' => 'Email Validation | Spairum.com',
			'akun' => $akun,
			'validation' => \Config\Services::validation()
		];
		return view('auth/emailverification', $data);
	}
	public function emailtoken()
	{
		$akun = $this->AuthLibaries->authCek();

		$db      = \Config\Database::connect();
		$token = $this->request->getVar('token');
		$cek_token = $this->VerifiedModel->emailtoken($token, $akun['id_user']);
		if (empty($cek_token)) {
			session()->setFlashdata('gagal', 'Token Salah');
			return redirect()->to('/Auth/verificationEmail');
		}
		$cekotp = $this->OtpModel->cekid($akun['id_user']);
		$time = $this->Time::now('Asia/Jakarta');
		$user = $this->UserModel->cek_id($akun['id_user']);

		$db->transStart();
		$debit = $user['debit'] + 2000;

		$rand = substr(sha1($token), 0, 10);

		$data = [
			'debit' => $debit,
			'email' => $cekotp['email'],
		];
		$this->UserModel->updateprofile($data, $user['id']);
		$datavocer = [
			'id_master' => $akun['id_user'],
			'Id_slave' => 'Admin',
			'Lokasi' => 'Bonus',
			'status' => 'Verifikasi Email',
			'isi' => 2000,
			'created_at' => $this->Time::now('Asia/Jakarta')
		];
		$this->HistoryModel->save($datavocer);

		$this->OtpModel->save([
			'id' => $cekotp['id'],
			'link' => $rand,
			'status' => 'terverifikasi',
		]);
		$this->VerifiedModel->save([
			'id' => $cek_token['id'],
			'email_status' => "verified",
			'verified_email_date' => $time,
			'token_email' => $rand,
		]);
		$db->transComplete();
		session()->setFlashdata('flash', 'Selamat anda mendapatkan saldo air 2000');
		return redirect()->to('/user');
	}
	public function resedemail()
	{
		$akun = $this->AuthLibaries->authCek();
		// $email =  $this->request->getVar('email');
		$body = $this->request->getBody();
		$body = json_decode($body, true);
		$email = strval($body['email']);
		$verif = $this->VerifiedModel->cekid($akun['id_user']);
		$otp = $this->OtpModel->cekid($akun['id_user']);
		if ($akun['email'] != $email) {
			$cek_email = $this->UserModel->cek_login($email);
			if (!empty($cek_email)) {
				$data = [
					'status' => 409,
					'msg' => 'Email sudah terdaftar gunakan Email lain',
				];
				return json_encode($data);
			}
		}
		$token = random_string('numeric', 5);
		$this->OtpModel->save([
			'id' => $otp['id'],
			'email' => $email,
		]);
		$this->VerifiedModel->save([
			'id' => $verif['id'],
			'token_email' => $token,
		]);
		$pesanEmail = ([
			'email' => $email,
			'fullname' => $akun['nama_depan'],
			'token' => $otp['link'],
			'kode' => $token,
			'subject' => 'Konfirmasi Email akun Spairum Anda',
			'status' => 'otp',
			'id_user' => $akun['id_user']
		]);
		$this->AuthLibaries->sendMqtt('Email/sendEmailOtp', json_encode($pesanEmail), $akun['id_user']);

		$data = [
			'status' => 200,
			'msg' => 'akun dan input sama',
		];
		return json_encode($data);
	}
	// validation whatsapp
	public function verificationWa()
	{
		$akun = $this->AuthLibaries->authCek();
		$cek_token = $this->VerifiedModel->cekid($akun['id_user']);
		if ($cek_token['whatsapp_status'] == 'verified') {
			return redirect()->to('/');
		}
		$data = [
			'title' => 'Whatsapp Validation | Spairum.com',
			'akun' => $akun,
			'validation' => \Config\Services::validation()
		];
		return view('auth/waverification', $data);
	}
	public function watoken()
	{
		$akun = $this->AuthLibaries->authCek();

		$db      = \Config\Database::connect();
		$token = $this->request->getVar('token');
		$cek_token = $this->VerifiedModel->watoken($token, $akun['id_user']);
		if (empty($cek_token)) {
			session()->setFlashdata('gagal', 'Token Salah');
			return redirect()->to('/Auth/verificationWa');
		}
		$cekotp = $this->OtpModel->cekid($akun['id_user']);
		$time = $this->Time::now('Asia/Jakarta');

		$db->transStart();
		$debit = $akun['debit'] + 1000;

		$rand = substr(sha1($token), 0, 10);

		$data = [
			'debit' => $debit,
			'telp' => $cekotp['telp'],
		];
		$this->UserModel->updateprofile($data, $akun['id']);
		$datavocer = [
			'id_master' => $akun['id_user'],
			'Id_slave' => 'Admin',
			'Lokasi' => 'Bonus',
			'status' => 'Verifikasi whatsapp',
			'isi' => 1000,
			'created_at' => $this->Time::now('Asia/Jakarta')
		];
		$this->HistoryModel->save($datavocer);

		$this->VerifiedModel->save([
			'id' => $cek_token['id'],
			'whatsapp_status' => "verified",
			'verified_wa_date' => $time,
			'token_wa' => $rand,
		]);
		$db->transComplete();
		$kontak = [
			"givenName" => $akun['nama_depan'],
			"familyName" => $akun['nama_belakang'],
			"emailAddresses" => $akun['email'],
			"phoneNumbers" => $cekotp['telp'],
		];
		$this->AuthLibaries->sendMqtt('contact/createContact', json_encode($kontak), $akun['nama_depan']);
		session()->setFlashdata('flash', 'Selamat anda mendapatkan saldo air 1000');
		return redirect()->to('/user');
	}
	public function resewa()
	{
		$akun = $this->AuthLibaries->authCek();
		$fullname = $akun['nama_depan'] . ' ' . $akun['nama_belakang'];
		$verif = $this->VerifiedModel->cekid($akun['id_user']);
		$otp = $this->OtpModel->cekid($akun['id_user']);
		$body = $this->request->getBody();
		$body = json_decode($body, true);
		$nowa = strval($body['whatsapp']);
		$token = random_string('numeric', 5);
		if ($akun['telp'] != $nowa) {
			$cek_wa = $this->UserModel->cektelp($nowa);
			if (!empty($cek_wa)) {
				$data = [
					'status' => 409,
					'msg' => 'No Whatsapp sudah terdaftar gunakan no lain',
				];
				return json_encode($data);
			}
			// $data = [
			// 	'status' => 200,
			// 	'msg' => 'akun dan input beda',
			// ];
			// return json_encode($data);
		}

		$this->OtpModel->save([
			'id' => $otp['id'],
			'telp' => $nowa,
		]);
		$this->VerifiedModel->save([
			'id' => $verif['id'],
			'token_wa' => $token,
		]);
		$PesanWA = array(
			[
				"message" => "Hallo kak $fullname, salam kenal aku admin spairum",
				"number" => $nowa
			],
			[
				"message" => "Sebelumnya terimakasih ya telah membuat akun spairum, khusus untuk kak $fullname ada *Saldo air Gratis 1000* yang bisa digunakan untuk isi ulang air minum di stasiun spairum.",
				"number" => $nowa
			],
			[
				"message" => "Untuk mendapatkan saldo isi ulang air 1000 secara gratis silahkan balas *Mau* untuk mengkatifkan link dan klik link berikut --> https://air.spairum.my.id/token_wa/$token",
				"number" => $nowa
			],
			[
				"message" => "Atau masukan Token *$token* .",
				"number" => $nowa
			],
			[
				"message" => "Terimakasih telah menggunakan layanan spairum, jika ada kendala atau pertanyaan silahkan balas pesan ini",
				"number" => $nowa
			]

		);
		foreach ($PesanWA as $value) {
			$this->AuthLibaries->sendWa($value);
		}
		$data = [
			'status' => 200,
			'msg' => 'akun dan input sama',
		];
		return json_encode($data);
	}
	public function waSkip()
	{
		// $this->VerifikasiLibraries->skipWA();
		$akun = $this->AuthLibaries->authCek();
		setCookie("verification-token", "Whatsapp-Skip-verification", array(
			'expires' => time() + 60 * 3,
			'path' => '/',
			'domain' => "", // leading dot for compatibility or use subdomain
			'secure' => true,     // or false
		));
		return redirect()->to('/user');
	}
}
