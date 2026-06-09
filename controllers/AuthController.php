<?php

class AuthController extends BaseController
{
    public function loginForm(): void
    {
        if (Session::isLoggedIn()) {
            redirect(Session::isAdmin() ? 'admin' : 'user/dashboard');
        }
        view('auth.login', [], 'auth');
    }

    public function login(): void
    {
        if (!isPost()) {
            redirect('login');
        }
        $this->verifyCsrf();

        $config = config('app.rate_limit.login');
        if (!Security::checkRateLimit('login', $config['max'], $config['window'])) {
            Session::flash('error', 'Too many login attempts. Please try again later.');
            redirect('login');
        }

        $email = Security::sanitize(post('email', ''));
        $password = post('password', '');
        $remember = !empty(post('remember'));

        $user = User::findByEmail($email);
        if (!$user || !Security::verifyPassword($password, $user['password'])) {
            Session::flash('error', 'Invalid email or password.');
            setOld(['email' => $email]);
            redirect('login');
        }

        if ($user['status'] !== 'active') {
            Session::flash('error', 'Your account has been deactivated.');
            redirect('login');
        }

        Security::resetRateLimit('login');
        User::update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
        Session::login($user, $remember);

        redirect($user['role'] === 'admin' ? 'admin' : 'user/dashboard');
    }

    public function registerForm(): void
    {
        if (Session::isLoggedIn()) {
            redirect('user/dashboard');
        }
        view('auth.register', [], 'auth');
    }

    public function register(): void
    {
        if (!isPost()) {
            redirect('register');
        }
        $this->verifyCsrf();

        $config = config('app.rate_limit.register');
        if (!Security::checkRateLimit('register', $config['max'], $config['window'])) {
            Session::flash('error', 'Too many registration attempts. Please try again later.');
            redirect('register');
        }

        $name = Security::sanitize(post('full_name', ''));
        $email = Security::sanitize(post('email', ''));
        $phone = Security::sanitize(post('phone', ''));
        $password = post('password', '');
        $confirm = post('confirm_password', '');

        $errors = [];
        if (strlen($name) < 2) $errors[] = 'Full name is required.';
        if (!Security::validateEmail($email)) $errors[] = 'Valid email is required.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
        if ($password !== $confirm) $errors[] = 'Passwords do not match.';
        if (User::findByEmail($email)) $errors[] = 'Email already registered.';

        if ($errors) {
            Session::flash('error', implode(' ', $errors));
            setOld(['full_name' => $name, 'email' => $email, 'phone' => $phone]);
            redirect('register');
        }

        $token = Security::generateToken();
        $userId = User::create([
            'full_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Security::hashPassword($password),
            'verification_token' => $token,
            'email_verified' => 0,
        ]);

        $verifyLink = url("verify-email/{$token}");
        Mailer::sendWelcome($email, $name, $verifyLink);

        Session::flash('success', 'Registration successful! Please check your email to verify your account.');
        redirect('login');
    }

    public function logout(): void
    {
        Session::logout();
        redirect('');
    }

    public function verifyEmail(string $token): void
    {
        $user = Database::fetch('SELECT * FROM users WHERE verification_token = ?', [$token]);
        if (!$user) {
            Session::flash('error', 'Invalid verification link.');
            redirect('login');
        }
        User::update($user['id'], ['email_verified' => 1, 'verification_token' => null]);
        Session::flash('success', 'Email verified successfully! You can now login.');
        redirect('login');
    }

    public function forgotForm(): void
    {
        view('auth.forgot', [], 'auth');
    }

    public function forgot(): void
    {
        if (!isPost()) {
            redirect('forgot-password');
        }
        $this->verifyCsrf();

        $email = Security::sanitize(post('email', ''));
        $user = User::findByEmail($email);
        if ($user) {
            $token = Security::generateToken();
            User::update($user['id'], [
                'reset_token' => $token,
                'reset_token_expires' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            ]);
            Mailer::sendPasswordReset($email, $user['full_name'], url("reset-password/{$token}"));
        }
        Session::flash('success', 'If your email exists in our system, you will receive a reset link.');
        redirect('login');
    }

    public function resetForm(string $token): void
    {
        $user = Database::fetch(
            'SELECT * FROM users WHERE reset_token = ? AND reset_token_expires > NOW()',
            [$token]
        );
        if (!$user) {
            Session::flash('error', 'Invalid or expired reset link.');
            redirect('login');
        }
        view('auth.reset', ['token' => $token], 'auth');
    }

    public function reset(string $token): void
    {
        if (!isPost()) {
            redirect('login');
        }
        $this->verifyCsrf();

        $user = Database::fetch(
            'SELECT * FROM users WHERE reset_token = ? AND reset_token_expires > NOW()',
            [$token]
        );
        if (!$user) {
            Session::flash('error', 'Invalid or expired reset link.');
            redirect('login');
        }

        $password = post('password', '');
        $confirm = post('confirm_password', '');
        if (strlen($password) < 8 || $password !== $confirm) {
            Session::flash('error', 'Passwords must match and be at least 8 characters.');
            redirect("reset-password/{$token}");
        }

        User::update($user['id'], [
            'password' => Security::hashPassword($password),
            'reset_token' => null,
            'reset_token_expires' => null,
        ]);
        Session::flash('success', 'Password reset successfully!');
        redirect('login');
    }
}
