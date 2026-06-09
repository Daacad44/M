<?php

class HomeController extends BaseController
{
    public function index(): void
    {
        $airports = Airport::getAll(true);
        $airlines = Airline::getAll(true);
        $destinations = Airport::getPopular(6);
        $faqs = Faq::getActive();
        $avgRating = Review::getAverageRating();

        view('home.index', compact('airports', 'airlines', 'destinations', 'faqs', 'avgRating'));
    }

    public function about(): void
    {
        view('home.about');
    }

    public function newsletter(): void
    {
        if (!isPost()) {
            redirect('');
        }
        $this->verifyCsrf();
        $email = Security::sanitize(post('email', ''));
        if (!Security::validateEmail($email)) {
            if (isAjax()) {
                $this->json(['success' => false, 'message' => 'Invalid email address.']);
            }
            Session::flash('error', 'Invalid email address.');
            redirect('');
        }
        Newsletter::subscribe($email);
        if (isAjax()) {
            $this->json(['success' => true, 'message' => 'Successfully subscribed!']);
        }
        Session::flash('success', 'Successfully subscribed to our newsletter!');
        redirect('');
    }
}
