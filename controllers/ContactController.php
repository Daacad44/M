<?php

class ContactController extends BaseController
{
    public function index(): void
    {
        $faqs = Faq::getActive();
        view('contact.index', compact('faqs'));
    }

    public function submit(): void
    {
        if (!isPost()) {
            redirect('contact');
        }
        $this->verifyCsrf();

        $config = config('app.rate_limit.contact');
        if (!Security::checkRateLimit('contact', $config['max'], $config['window'])) {
            Session::flash('error', 'Too many messages. Please try again later.');
            redirect('contact');
        }

        $name = Security::sanitize(post('name', ''));
        $email = Security::sanitize(post('email', ''));
        $subject = Security::sanitize(post('subject', ''));
        $message = Security::sanitize(post('message', ''));

        if (!Security::validateEmail($email) || strlen($message) < 10) {
            Session::flash('error', 'Please fill in all required fields.');
            redirect('contact');
        }

        Database::insert('contact_messages', compact('name', 'email', 'subject', 'message'));

        if (isAjax()) {
            $this->json(['success' => true, 'message' => 'Message sent successfully!']);
        }

        Session::flash('success', 'Your message has been sent. We will get back to you soon.');
        redirect('contact');
    }

    public function createTicket(): void
    {
        if (!isPost()) {
            redirect('contact');
        }
        $this->verifyCsrf();

        $name = Security::sanitize(post('name', ''));
        $email = Security::sanitize(post('email', ''));
        $subject = Security::sanitize(post('subject', ''));
        $message = Security::sanitize(post('message', ''));

        SupportTicket::create([
            'user_id' => Session::userId(),
            'ticket_number' => generateSupportTicketNumber(),
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'priority' => post('priority', 'medium'),
        ]);

        Session::flash('success', 'Support ticket created successfully.');
        redirect('contact');
    }
}
