<?php /** @noinspection ALL */

/**
 * Prefills the login form with the ADMINER_DEFAULT_* environment variables. Password less login supported for default user.
 *
 * @link   https://www.adminer.org/plugins/#use
 * @author Jeremy Stepanek
 */
class LoginDefaultCredentials extends Adminer\Plugin
{
    private $adminer;
    private $fields;

    public function __construct()
    {
        $_ENV['ADMINER_DEFAULT_DRIVER'] ??= null;
        $_ENV['ADMINER_DEFAULT_SERVER'] ??= null;
        $_ENV['ADMINER_DEFAULT_USER'] ??= null;
        $_ENV['ADMINER_DEFAULT_PASSWORD'] ??= null;
        $_ENV['ADMINER_DEFAULT_DATABASE'] ??= null;

        $this->adminer = new Adminer\Adminer;
        $this->fields = [
            'server' => $_ENV['ADMINER_DEFAULT_SERVER'],
            'username' => $_ENV['ADMINER_DEFAULT_USER'],
            'db' => $_ENV['ADMINER_DEFAULT_DATABASE'],
        ];
    }

    public function credentials()
    {
        return [
            Adminer\SERVER,
            ($username = $_GET['username']) ? $username : $_ENV['ADMINER_DEFAULT_USER'],
            ($password = Adminer\get_password()) ? $password : ($username === $_ENV['ADMINER_DEFAULT_USER'] ? $_ENV['ADMINER_DEFAULT_PASSWORD'] : ''),
        ];
    }

    public function login($login, $password)
    {
        if ($login === $_ENV['ADMINER_DEFAULT_USER'] && $password === '') {
            return true;
        }
    }

    public function loginFormField(...$args)
    {
        $fields = $this->fields;

        return (function (...$args) use ($fields) {
            $field = $this->loginFormField(...$args);

            if ($args[0] === 'driver') {
                $field = str_replace('selected', '', $field);

                return preg_replace('/(option .*value="' . Adminer\h($_ENV['ADMINER_DEFAULT_DRIVER']) . '")/', '$1 selected', $field);
            }

            if (!array_key_exists($args[0], $fields)) {
                return $field;
            }

            return preg_replace('/(input .*name="auth\[' . $args[0] . '\]".*) value=""/', '$1 value="' . Adminer\h($fields[$args[0]]) . '"', $field);
        })->call($this->adminer, ...$args);
    }
}

return new LoginDefaultCredentials;
