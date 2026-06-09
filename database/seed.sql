-- SkyWings Flight Booking System - Seed Data
USE `skywings_flights`;

-- Admin User (password: Admin@123)
INSERT INTO `users` (`full_name`, `email`, `phone`, `password`, `role`, `email_verified`, `status`) VALUES
('System Administrator', 'admin@skywings.com', '+1-800-555-0100', '$2b$12$GMFZsVUIvbOBtsgj3.DmEO9xeQgMdHlxOdHQ4HntdJny9WoCxrGoe', 'admin', 1, 'active');

-- Demo User (password: User@123)
INSERT INTO `users` (`full_name`, `email`, `phone`, `password`, `role`, `email_verified`, `status`) VALUES
('John Smith', 'user@skywings.com', '+1-555-123-4567', '$2b$12$O7eAXSWHNZkQqtHXY5PDM.XmqrZhbD18cgRJKoMU7x9ULAUSFvzO2', 'user', 1, 'active');

-- Airlines
INSERT INTO `airlines` (`name`, `code`, `contact_email`, `contact_phone`, `website`, `description`, `status`) VALUES
('SkyWings Airways', 'SW', 'contact@skywings.com', '+1-800-SKY-WING', 'https://skywings.com', 'Premium airline offering global connectivity.', 'active'),
('Global Air', 'GA', 'info@globalair.com', '+1-800-GLOBAL', 'https://globalair.com', 'World-class international airline.', 'active'),
('Pacific Express', 'PE', 'support@pacificexpress.com', '+1-800-PACIFIC', 'https://pacificexpress.com', 'Fast and reliable Pacific routes.', 'active'),
('EuroFly', 'EF', 'hello@eurofly.eu', '+44-20-7946-0958', 'https://eurofly.eu', 'Leading European carrier.', 'active'),
('Asia Connect', 'AC', 'service@asiaconnect.com', '+65-6123-4567', 'https://asiaconnect.com', 'Connecting Asia to the world.', 'active');

-- Airports
INSERT INTO `airports` (`name`, `code`, `city`, `country`, `timezone`) VALUES
('John F. Kennedy International Airport', 'JFK', 'New York', 'United States', 'America/New_York'),
('Los Angeles International Airport', 'LAX', 'Los Angeles', 'United States', 'America/Los_Angeles'),
('London Heathrow Airport', 'LHR', 'London', 'United Kingdom', 'Europe/London'),
('Charles de Gaulle Airport', 'CDG', 'Paris', 'France', 'Europe/Paris'),
('Dubai International Airport', 'DXB', 'Dubai', 'United Arab Emirates', 'Asia/Dubai'),
('Singapore Changi Airport', 'SIN', 'Singapore', 'Singapore', 'Asia/Singapore'),
('Tokyo Haneda Airport', 'HND', 'Tokyo', 'Japan', 'Asia/Tokyo'),
('Sydney Kingsford Smith Airport', 'SYD', 'Sydney', 'Australia', 'Australia/Sydney'),
('Frankfurt Airport', 'FRA', 'Frankfurt', 'Germany', 'Europe/Berlin'),
('Hong Kong International Airport', 'HKG', 'Hong Kong', 'Hong Kong', 'Asia/Hong_Kong'),
('Toronto Pearson International Airport', 'YYZ', 'Toronto', 'Canada', 'America/Toronto'),
('Miami International Airport', 'MIA', 'Miami', 'United States', 'America/New_York');

-- Sample Flights (departure times relative to current date)
INSERT INTO `flights` (`flight_number`, `airline_id`, `aircraft_type`, `departure_airport_id`, `arrival_airport_id`, `departure_time`, `arrival_time`, `duration_minutes`, `stops`, `economy_price`, `premium_economy_price`, `business_price`, `first_class_price`, `economy_seats`, `premium_economy_seats`, `business_seats`, `first_class_seats`, `status`) VALUES
('SW101', 1, 'Boeing 787-9', 1, 3, DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 8 HOUR, DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 20 HOUR, 720, 0, 450.00, 750.00, 1500.00, 3000.00, 180, 40, 24, 8, 'scheduled'),
('SW102', 1, 'Boeing 787-9', 3, 1, DATE_ADD(NOW(), INTERVAL 10 DAY) + INTERVAL 10 HOUR, DATE_ADD(NOW(), INTERVAL 10 DAY) + INTERVAL 22 HOUR, 720, 0, 480.00, 780.00, 1550.00, 3100.00, 180, 40, 24, 8, 'scheduled'),
('GA201', 2, 'Airbus A350', 1, 5, DATE_ADD(NOW(), INTERVAL 5 DAY) + INTERVAL 22 HOUR, DATE_ADD(NOW(), INTERVAL 6 DAY) + INTERVAL 18 HOUR, 1200, 0, 620.00, 980.00, 1800.00, 3500.00, 200, 50, 30, 10, 'scheduled'),
('GA202', 2, 'Airbus A350', 5, 1, DATE_ADD(NOW(), INTERVAL 12 DAY) + INTERVAL 9 HOUR, DATE_ADD(NOW(), INTERVAL 13 DAY) + INTERVAL 5 HOUR, 1200, 0, 650.00, 1000.00, 1850.00, 3600.00, 200, 50, 30, 10, 'scheduled'),
('PE301', 3, 'Boeing 777-300ER', 2, 6, DATE_ADD(NOW(), INTERVAL 4 DAY) + INTERVAL 11 HOUR, DATE_ADD(NOW(), INTERVAL 5 DAY) + INTERVAL 5 HOUR, 1080, 0, 580.00, 920.00, 1700.00, 3200.00, 220, 45, 28, 12, 'scheduled'),
('PE302', 3, 'Boeing 777-300ER', 6, 2, DATE_ADD(NOW(), INTERVAL 11 DAY) + INTERVAL 23 HOUR, DATE_ADD(NOW(), INTERVAL 12 DAY) + INTERVAL 17 HOUR, 1080, 0, 590.00, 940.00, 1750.00, 3300.00, 220, 45, 28, 12, 'scheduled'),
('EF401', 4, 'Airbus A320neo', 3, 4, DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 7 HOUR, DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 9 HOUR, 120, 0, 120.00, 220.00, 450.00, 800.00, 150, 20, 12, 4, 'scheduled'),
('EF402', 4, 'Airbus A320neo', 4, 9, DATE_ADD(NOW(), INTERVAL 6 DAY) + INTERVAL 14 HOUR, DATE_ADD(NOW(), INTERVAL 6 DAY) + INTERVAL 15 HOUR + INTERVAL 30 MINUTE, 90, 0, 95.00, 180.00, 380.00, 650.00, 150, 20, 12, 4, 'scheduled'),
('AC501', 5, 'Boeing 787-8', 6, 7, DATE_ADD(NOW(), INTERVAL 7 DAY) + INTERVAL 6 HOUR, DATE_ADD(NOW(), INTERVAL 7 DAY) + INTERVAL 13 HOUR, 420, 0, 350.00, 550.00, 1100.00, 2200.00, 160, 35, 20, 8, 'scheduled'),
('AC502', 5, 'Boeing 787-8', 7, 10, DATE_ADD(NOW(), INTERVAL 8 DAY) + INTERVAL 15 HOUR, DATE_ADD(NOW(), INTERVAL 8 DAY) + INTERVAL 19 HOUR, 240, 0, 280.00, 480.00, 950.00, 1800.00, 160, 35, 20, 8, 'scheduled'),
('SW103', 1, 'Boeing 737 MAX', 1, 12, DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 16 HOUR, DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 19 HOUR + INTERVAL 30 MINUTE, 210, 0, 180.00, 320.00, 600.00, 1100.00, 140, 25, 16, 6, 'scheduled'),
('GA203', 2, 'Airbus A330', 11, 8, DATE_ADD(NOW(), INTERVAL 9 DAY) + INTERVAL 20 HOUR, DATE_ADD(NOW(), INTERVAL 10 DAY) + INTERVAL 22 HOUR, 1560, 1, 890.00, 1200.00, 2100.00, 4000.00, 190, 40, 22, 8, 'scheduled');

-- Coupons
INSERT INTO `coupons` (`code`, `description`, `discount_type`, `discount_value`, `min_amount`, `max_uses`, `expires_at`, `status`) VALUES
('WELCOME10', '10% off your first booking', 'percentage', 10.00, 100.00, 1000, DATE_ADD(NOW(), INTERVAL 1 YEAR), 'active'),
('SAVE50', '$50 off bookings over $500', 'fixed', 50.00, 500.00, 500, DATE_ADD(NOW(), INTERVAL 6 MONTH), 'active'),
('SUMMER25', '25% summer sale discount', 'percentage', 25.00, 200.00, 200, DATE_ADD(NOW(), INTERVAL 3 MONTH), 'active');

-- FAQs
INSERT INTO `faqs` (`question`, `answer`, `category`, `sort_order`) VALUES
('How do I book a flight?', 'Search for flights using our search form, select your preferred flight, enter passenger details, and complete payment to confirm your booking.', 'Booking', 1),
('Can I cancel my booking?', 'Yes, you can cancel eligible bookings from your dashboard. Cancellation policies vary by fare type and airline.', 'Booking', 2),
('How do I check in online?', 'Online check-in opens 24 hours before departure. Access it from your booking details in the dashboard.', 'Travel', 3),
('What payment methods are accepted?', 'We accept Stripe, PayPal, and bank transfer. All online payments are secured with encryption.', 'Payment', 4),
('How do I receive my e-ticket?', 'After payment confirmation, your e-ticket is available for download from your dashboard and sent to your email.', 'Tickets', 5),
('Can I change my flight date?', 'Date changes depend on fare rules. Contact support or manage your booking from the dashboard.', 'Booking', 6),
('What is the baggage allowance?', 'Baggage allowance varies by airline and cabin class. Check flight details for specific limits.', 'Travel', 7),
('How do I contact customer support?', 'Use our contact form, submit a support ticket, or email support@skywings.com.', 'Support', 8);

-- Settings
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'SkyWings'),
('site_tagline', 'Your Journey Begins Here'),
('site_email', 'support@skywings.com'),
('site_phone', '+1-800-SKY-WING'),
('currency', 'USD'),
('currency_symbol', '$'),
('stripe_public_key', ''),
('stripe_secret_key', ''),
('paypal_client_id', ''),
('paypal_secret', ''),
('smtp_host', 'smtp.gmail.com'),
('smtp_port', '587'),
('smtp_username', ''),
('smtp_password', ''),
('smtp_encryption', 'tls');

-- Generate seats for first flight (SW101) as sample
INSERT INTO `seats` (`flight_id`, `seat_number`, `seat_class`, `status`)
SELECT 1, CONCAT(ROW_NUM, CHAR(65 + MOD(ROW_NUM-1, 6))), 
    CASE 
        WHEN ROW_NUM <= 8 THEN 'first_class'
        WHEN ROW_NUM <= 32 THEN 'business'
        WHEN ROW_NUM <= 72 THEN 'premium_economy'
        ELSE 'economy'
    END,
    'available'
FROM (
    SELECT @row := @row + 1 AS ROW_NUM
    FROM (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
         (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
         (SELECT @row := 0) r
    LIMIT 180
) numbers;
