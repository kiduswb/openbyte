<?php 

// Emails.php
// Handles email sending and templates

require_once 'vendor/autoload.php';

/**
 * sendTransactionalEmail
 * Sends a transactional email to the specified email address
 * @param  mixed $email
 * @param  mixed $subject
 * @param  mixed $body
 * @return void
 */
function sendTransactionalEmail($email, $subject, $body) {
    $resend = Resend::client($_ENV['RESEND_API_KEY']);

    $resend->emails->send([
        'from' => 'OpenByte Hosting <no-reply@openbytehosting.com>',
        'to' => [$email],
        'subject' => $subject,
        'html' => $body,
    ]);
}

function generateVerificationEmail($userid) {
    //...
}

function generatePasswordResetEmail($token) {
    //...
}

function generateSiteDeletionEmail($domainName) {
    //...
}

function generateAccountDeletionEmail($email) {
    //...
}
