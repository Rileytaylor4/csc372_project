<?php
function clean_input(string $value): string
{
    return trim($value);
}

function validate_appointment_form(array $data): array
{
    $errors = [];

    $name = clean_input($data['name'] ?? '');
    $email = clean_input($data['email'] ?? '');
    $car_year = clean_input($data['car_year'] ?? '');
    $service = clean_input($data['service'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Name is required.';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters.';
    }

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($car_year === '') {
        $errors['car_year'] = 'Car year is required.';
    } elseif (!is_numeric($car_year)) {
        $errors['car_year'] = 'Car year must be a number.';
    } elseif ((int)$car_year < 1900 || (int)$car_year > 2030) {
        $errors['car_year'] = 'Enter a valid car year between 1900 and 2030.';
    }

    $allowed_services = ['Oil Change', 'Brake Service', 'Tune-Up', 'Detailing'];

    if ($service === '') {
        $errors['service'] = 'Please select a service.';
    } elseif (!in_array($service, $allowed_services, true)) {
        $errors['service'] = 'Please choose a valid service option.';
    }

    return $errors;
}