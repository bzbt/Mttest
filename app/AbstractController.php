<?php


namespace App;


use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{

    /**
     * @return mixed
     */
    protected function view(string $template, array $data = [])
    {
        extract($data);

        return require __DIR__."/Templates/{$template}.php";
    }

    protected function csrfToken(): string
    {
        $this->runSession();
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

        return $_SESSION['token'];
    }

    private function runSession(): void
    {
        if ( ! isset($_SESSION)) {
            session_start();
        }
    }

    protected function validateCsrfToken(string $token): void
    {
        $this->runSession();

        if (empty($_SESSION['token']) || $_SESSION['token'] !== $token) {
            http_response_code(403);
            die;
        }
    }

    protected function request(): Request
    {
        return Request::createFromGlobals();
    }
}
