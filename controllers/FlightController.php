<?php

class FlightController extends BaseController
{
    public function search(): void
    {
        $airports = Airport::getAll(true);
        $airlines = Airline::getAll(true);
        $filters = [
            'from' => get('from'),
            'to' => get('to'),
            'departure_date' => get('departure_date'),
            'return_date' => get('return_date'),
            'trip_type' => get('trip_type', 'one_way'),
            'passengers' => (int) get('passengers', 1),
            'cabin_class' => get('cabin_class', 'economy'),
            'airline' => get('airline'),
            'stops' => get('stops'),
            'min_price' => get('min_price'),
            'max_price' => get('max_price'),
            'departure_time' => get('departure_time'),
            'sort' => get('sort', 'price_asc'),
        ];

        $flights = [];
        $returnFlights = [];
        if ($filters['from'] && $filters['to'] && $filters['departure_date']) {
            $flights = Flight::search($filters);
            foreach ($flights as &$flight) {
                $flight['price'] = Flight::getPrice($flight, $filters['cabin_class']);
            }
            unset($flight);

            if ($filters['trip_type'] === 'round_trip' && $filters['return_date']) {
                $returnFilters = $filters;
                $returnFilters['from'] = $filters['to'];
                $returnFilters['to'] = $filters['from'];
                $returnFilters['departure_date'] = $filters['return_date'];
                $returnFlights = Flight::search($returnFilters);
                foreach ($returnFlights as &$rf) {
                    $rf['price'] = Flight::getPrice($rf, $filters['cabin_class']);
                }
                unset($rf);
            }
        }

        view('flights.search', compact('airports', 'airlines', 'filters', 'flights', 'returnFlights'));
    }

    public function details(string $id): void
    {
        $flight = Flight::findById((int) $id);
        if (!$flight) {
            Session::flash('error', 'Flight not found.');
            redirect('flights/search');
        }
        $cabinClass = get('cabin_class', 'economy');
        $price = Flight::getPrice($flight, $cabinClass);
        $seatMap = Seat::getSeatMap((int) $id);
        $reviews = Review::getByAirline((int) $flight['airline_id']);
        $avgRating = Review::getAverageRating((int) $flight['airline_id']);

        view('flights.details', compact('flight', 'cabinClass', 'price', 'seatMap', 'reviews', 'avgRating'));
    }

    public function airportSearch(): void
    {
        $query = Security::sanitize(get('q', ''));
        if (strlen($query) < 2) {
            $this->json(['results' => []]);
        }
        $results = Airport::search($query);
        $this->json(['results' => $results]);
    }
}
