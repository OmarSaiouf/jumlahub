<?php

return [
    'title' => 'Dashboard',
    'eyebrow' => 'Account',
    'welcome' => 'Hello :name, manage your account info and security from here',
    'muted' => 'Monitor your account status, update contact info, and enable two-factor authentication for extra protection.',

    'role_default' => 'User',

    'summary' => [
        'total_orders' => 'Total orders',
        'closed_label' => 'Closed (completed/cancelled/refunded)',
        'in_progress' => 'Orders in progress',
        'pending' => 'Pending approval',
        'processing' => 'Processing',
        'completed' => 'Completed orders',
        'cancelled_refunded' => 'Cancelled/Refunded',
        'total_paid' => 'Total paid',
        'successful_ops' => 'Successful transactions',
        'last_payment' => 'Last payment',
    ],

    'status' => [
        'email_label' => 'Email',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'email_verified_label' => 'Email verification',
        'two_factor_label' => 'Two-factor auth',
    ],

    'basic' => [
        'eyebrow' => 'Basic information',
        'title' => 'Update account information',
    ],

    'form' => [
        'name_label' => 'Full name',
        'email_label' => 'Email address',
        'email_muted' => 'A verification code will be sent to the email if changed.',
        'save_changes' => 'Save changes',
    ],

    'security' => [
        'eyebrow' => 'Security',
        'change_password' => 'Change password',
        'current_password_label' => 'Current password',
        'new_password_label' => 'New password',
        'confirm_password_label' => 'Confirm password',
        'update_password' => 'Update password',
    ],

    'twofactor' => [
        'show_settings' => 'Show two-factor settings',
        'hide_settings' => 'Hide two-factor settings',
        'eyebrow' => 'Two-factor authentication',
        'title' => 'Additional protection for your account',
        'muted' => 'Enable two-factor authentication via an authenticator app to add an extra security layer.',
        'enable_info' => 'Enable two-factor to get additional login codes and improved protection.',
        'enable_button' => 'Enable two-factor',
        'scan_qr_info' => 'Scan the QR code below with your authenticator app then enter the code to confirm activation.',
        'code_label' => 'Authenticator code',
        'confirm_button' => 'Confirm activation',
        'disable_button' => 'Disable two-factor',
        'activated_label' => 'Activated :time',
        'recovery_codes_label' => 'Recovery codes',
        'recovery_codes_hint' => 'Keep them in a safe place',
        'qr_title' => 'QR code',
        'recovery_codes_eyebrow' => 'Recovery codes',
        'regenerate_codes' => 'Regenerate codes',
    ],
];
