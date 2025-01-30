<?php

namespace app\utils;
use flight\Engine;

class CheckUser{
    protected Engine $flight;

    public function __construct(Engine $flight) {
        $this->flight = $flight;
    }


    public function IsConnected()
    {
        if (!isset($_POST['userEmail'])) {
            $this->error( 'userEmail is required', 401);
            return false;
        }

        if (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
            $this->error( 'Invalid email format', 401);
            return false;
        }

        return true;
    }

    public function error403() {
        $this->error('Not allowed', 403);
    }

    public function error404() {
        $this->error('Page not found', 404);
    }
    
    public function error499($table, $id) {
        $this->error("Record $id not found in table $table", 499);
    }

    private function error(string $message, int $code) {
        echo '<h1>' . $_SERVER['REQUEST_URI'] . '</h1>';
        echo "<h2>Error $code</h2>: $message";
?>
<script>
    setTimeout(function() {
        window.location.href = '/';
    }, 1000);
</script>
<?php
    }
}
