<?php

namespace Tests\Feature;

use App\Rules\LithuanianPhoneNumber;
use PHPUnit\Framework\AssertionFailedError;

it('validates correct Lithuanian phone number starting with +3706', function () {
    $rule = new LithuanianPhoneNumber();

    // A valid phone number starting with +3706
    $validPhoneNumber = '+37061234567';
    $fail = fn () => 'fail';

    try {
        $rule->validate('phone', $validPhoneNumber, $fail);
    } catch (AssertionFailedError $e) {
        // Fail the test if an error is thrown (validation failed)
        $this->fail('Validation failed unexpectedly for a valid phone number');
    }

    expect(true)->toBeTrue();
});

it('fails validation for incorrect Lithuanian phone number', function () {
    $rule = new LithuanianPhoneNumber();

    // An invalid phone number (does not start with +3706 or have 11 digits)
    $invalidPhoneNumber = '+37011234567';
    
    $fail = function ($message) {
        expect($message)->toBe('Please enter a valid Lithuanian phone number. Has to start with +3706 and contain 11 numbers total');
    };

    $rule->validate('phone', $invalidPhoneNumber, $fail);
});

it('fails validation for phone number with incorrect length', function () {
    $rule = new LithuanianPhoneNumber();

    // An invalid phone number (too short)
    $invalidPhoneNumber = '+37061234';

    $fail = function ($message) {
        expect($message)->toBe('Please enter a valid Lithuanian phone number. Has to start with +3706 and contain 11 numbers total');
    };

    $rule->validate('phone', $invalidPhoneNumber, $fail);
});