<?php
return [

     // app data
    'app'=> [
        'app_name' => env('APP_NAME'),
        'app_logo' => '/assets/img/n1.png',
        'contact_us_data' => 'We’re here, ready to talk',
        'contact_us_href' => env('APP_URL')
    ],

     // dummy content
      'dummy'=> [
          'main_heading' => 'Heading',
          'lines' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
          'button_data' => 'View Button',
          'button_href' => '#'
      ],

    // User Signup
      'user_signup'=> [
          'main_heading' => 'Successfully Registered',
          'lines' => 'Thanks for signup, now you can access all the features',
          'button_data' => 'Go To Site',
          'button_href' => env('APP_URL')
      ],

      // Verify Email Address
        'verify_email'=> [
            'main_heading' => 'Verify Email Address',
            'lines' => 'Please click the button below to verify your email address.',
            'button_data' => 'Verify Email Address',
            'button_href' => '#'
        ],

      // Reset Password
        'reset_password'=> [
            'main_heading' => 'Hello!',
            'lines' => 'You are receiving this email because we received a password reset request for your account.This password reset link will expire in 60 minutes.',
            'button_data' => 'Reset Password',
            'button_href' => '#'
        ],

        // Invite Participants
        'invite_participants'=> [
            'main_heading' => 'Hello!',
            'lines' => 'Please join Zoom meeting in progress! ',
            'button_data' => 'Join',
            'button_href' => '#'
        ],



];
