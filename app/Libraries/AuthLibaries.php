<?php

namespace App\Libraries;

use \Firebase\JWT\JWT;
use App\Models\TokenModel;
use App\Models\UserModel;
use Exception;
use Kint\Parser\ToStringPlugin;

class AuthLibaries
{
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->TokenModel = new TokenModel();
    }

    public function authCek()
    {
        if (empty($_COOKIE['X-Sparum-Token'])) {
            session()->setFlashdata('gagal', 'Anda belum Login');
            return redirect()->to('/');
        }
        $jwt = $_COOKIE['X-Sparum-Token'];
        try {
            $key = $this->TokenModel->Key()['token'];
            $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (Exception $exception) {
            session()->setFlashdata('gagal', 'Login Dulu');
            return redirect()->to('/');
        }
        $key = $this->TokenModel->Key()['token'];
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $token = $decoded->Key;
        // dd($token);
        if (empty($this->TokenModel->cek($token))) {
            session()->setFlashdata('gagal', 'Anda sudah Logout, Silahkan Masuk lagi');
            return redirect()->to('/');
        }
        $nama = $decoded->nama;
        $akun = $this->UserModel->cek_login($nama);
        if (empty($akun)) {
            session()->setFlashdata('gagal', 'sesi login anda telah habis');
            setCookie("X-Sparum-Token", "Logout", time() + (86400 * 30), "/");
            return redirect()->to('/');
        }
        return $akun;
    }
    public function sendMqtt($topic, $message, $clientId)
    {
        $server   = 'spairum.my.id';
        $port     = 1883;
        $clientId =  $clientId;
        $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
            ->setUsername('mqttuntan')
            ->setPassword('mqttuntan');

        $mqtt = new \PhpMqtt\Client\MqttClient(
            $server,
            $port,
            $clientId
        );

        $mqtt->connect($connectionSettings, true);
        $mqtt->publish($topic, $message);
        $mqtt->disconnect();
        echo json_encode($message);
        return;
    }

    public function notif($masage, $pesan)
    {
        return;
    }
    public function sendWa($masage)
    {
        // $server   = 'ws.spairum.my.id';
        $server   = 'spairum.my.id';
        $port     = 1883;
        $clientId =  "wa_Sender";
        // $masage = [
        //     "message" => 'hai',
        //     "number" => "0895321701798"
        // ];
        $myJSON = json_encode($masage);
        $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
            ->setUsername('mqttuntan')
            ->setPassword('mqttuntan');

        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        $mqtt->connect($connectionSettings, true);
        $mqtt->publish("sendPesan",  $myJSON);
        $mqtt->disconnect();
        // echo json_encode($myJSON);
        return;
    }
    public function sendEmailOtp($email, $fullname, $token)
    {
        $this->email = \Config\Services::email();
        $this->email->setFrom('infospairum@gmail.com', 'noreply-spairum');
        $this->email->setTo($email);
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
        return $this->email->send();
        // dd($this->email->send());
    }
}
