<?php

class BaseController
{
    protected function requireAuth(): void
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Please login to continue.');
            redirect('login');
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (!Session::isAdmin()) {
            Session::flash('error', 'Access denied.');
            redirect('');
        }
    }

    protected function verifyCsrf(): void
    {
        if (!Security::verifyCsrf(post('csrf_token'))) {
            Session::flash('error', 'Invalid security token. Please try again.');
            redirect($_SERVER['HTTP_REFERER'] ?? '');
        }
    }

    protected function json(array $data, int $code = 200): void
    {
        jsonResponse($data, $code);
    }
}
