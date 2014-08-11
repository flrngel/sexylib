<?php
// 
// Usage -- 
//	$handler = new SessionHandlerCookie;
//	session_set_save_handler($handler, true);
//	session_start();

class SessionHandlerCookie implements SessionHandlerInterface {

  private $data      = array();
  private $save_path = null;

  const HASH_LEN    = 128;
  const HASH_ALGO   = 'sha512';
  const HASH_SECRET = "YOUR_SECRET_STRING";

  public function open($save_path, $name) {
    $this->save_path = $save_path;
    return true;
  }

  public function read($id) {
    if (! isset($_COOKIE[$id])) return '';

    $raw = base64_decode($_COOKIE[$id]);
    if (strlen($raw) < self::HASH_LEN) return '';

    $hash = substr($raw, strlen($raw)-self::HASH_LEN, self::HASH_LEN);
    $data = substr($raw, 0, -(self::HASH_LEN));

    $hash_calculated = hash_hmac(self::HASH_ALGO, $data, self::HASH_SECRET);

    if ($hash_calculated !== $hash) return '';

    return (string)$data;
  }

  public function write($id, $data) {
    $hash = hash_hmac(self::HASH_ALGO, $data, self::HASH_SECRET);
    $data .= $hash;

    setcookie($id, base64_encode($data), time()+3600);
  }

  public function destroy($id) {
    setcookie($id, '', time());
  }

  public function gc($maxlifetime) {}
  public function close() {}
}
?>
