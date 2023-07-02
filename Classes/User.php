<?php

namespace Classes;

use Classes\NotifyType\Email;
use Classes\NotifyType\SMS;

class User
{
    /**
     * @param  Database  $db
     * @param  Email  $sendEmail
     * @param  SMS  $sendSms
     */
    public function __construct(
        protected Database $db,
        protected Email $sendEmail,
        protected SMS $sendSms
    ) {
    }

    /**
     * @param  array  $user
     * @return void
     */
    public function registerUser(array $user)
    {
        $this->db->insert('users', $user);
        $this->sendEmail->sendWelcomeEmail($user['email']);
        $this->sendSms->sendSMS($user['phone'], 'Welcome to our company! =)');
    }
}