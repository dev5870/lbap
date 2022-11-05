<?php

return [

    'site_name' => 'Site name',

    'welcome_back' => 'Welcome',
    'id' => 'ID',
    'user_id' => 'User ID',
    'referral_uuid' => 'Referral id',
    'user_agent' => 'User agent',
    'ip' => 'IP',
    'email' => 'Email',
    'created_at' => 'Created at',
    'paid_at' => 'Paid at',
    'action' => 'Action',
    'status' => 'Status',
    'success' => 'Success!',
    'tg' => 'Telegram',
    'referrer_email' => 'Referrer email',
    'commission_amount' => 'Commission amount (%)',
    'file_not_upload' => 'File not upload!',
    'file_not_deleted' => 'File not deleted!',

    'user' => [
        'title' => 'Information about user',
        'latest' => 'Latest user',
        'role' => 'Role',
        'many' => 'Users',
        'update' => 'Update user form',
        'total_users' => 'Total users',
        'last_day' => 'Since last 24 hour',
        'last_logins' => 'Last logins',
        'referrer' => 'Referrer',
        'referrals' => 'Referrals',
        'referral' => 'Referral',
        'create' => 'Creating new user',
        'add' => 'Add new user',
        'file' => 'File',
        'comment' => 'Comment',
        'balance' => 'Balance',
    ],

    'main' => [
        'title' => 'Dashboard',
    ],

    'login' => [
        'title' => 'Authorization',
    ],

    'registration' => [
        'title' => 'Registration',
        'success' => 'Success registration!',
        'error' => 'Error registration!',
        'disabled' => 'Registration disabled!',
        'telegram' => 'For registration use telegram!',
        'error-invite' => 'Registration by invitation only',
    ],

    'menu' => [
        'collapse_menu' => 'Collapse menu',
        'users' => 'Users',
        'settings' => 'Settings',
        'general' => 'General',
        'control_panel' => 'Control panel',
        'user_logs' => 'User logs',
        'user_list' => 'User list',
        'user_referrals' => 'User referrals',
        'content' => 'Content',
        'notification' => 'Notification',
        'files' => 'Files',
        'payments' => 'Payments',
        'addresses' => 'Addresses',
        'notices' => 'System notices',
        'transactions' => 'Transactions',
        'cabinet' => 'Go to cabinet',
        'statistic' => 'Statistics',
        'page' => 'Pages',
    ],

    'page' => [
        'add' => 'Create new page',
        'update' => 'Edit page',
    ],

    'transaction' => [
        'title' => 'transaction',
        'new_balance' => 'New balance',
        'old_balance' => 'Old balance',
    ],

    'payment' => [
        'payment' => 'Payment',
        'full_amount' => 'Full amount',
        'full_amount_placeholder' => 'Full amount (min: :min)',
        'amount' => 'Amount',
        'commission_amount' => 'Commission',
        'create_new' => 'Create new payment',
        'update' => 'Update payment',
        'total' => 'Total payments',
        'id' => 'Payment ID',
        'type' => 'Type',
        'method' => 'Method',
        'description' => [
            'top_up' => 'User top up balance',
            'withdraw' => 'User withdraw balance',
            'referral_commission' => 'Referral commission',
            'payment' => 'Send coin on your Dogecoin address.',
            'wallet' => 'Your address: :wallet',
            'info' => 'Money will be credited to your balance automatically after replenishment of the address.',
            'question' => 'How top up balance?',
        ],
        'parent_id' => 'Parent ID',
        'tx' => 'Transaction hash',
    ],

    'bot' => [
        'welcome' => 'Welcome! Please, enter your email for registration or your secret key (if you already registered).',
        'chat_id_exists' => 'Your chat id already exists!',
        'success_login' => 'Success login!',
        'success_registration' => 'Success registration!',
        'email' => 'Your email: ',
        'password' => 'Your password: ',
    ],

    'notice' => [
        'title' => 'System notice',
        'description' => 'Description',
    ],

    'file' => [
        'name' => 'Name',
        'fileable_id' => 'Fileable id',
        'fileable_type' => 'Fileable type',
        'description' => 'File description',
        'dimensions' => 'width 300, height 200 only',
    ],

    'notification' => [
        'many' => 'Notifications',
        'text' => 'Message',
        'add' => 'Add new notification',
        'update' => 'Update notification',
        'type' => 'Type',
    ],

    'address' => [
        'title' => 'Address',
        'add' => 'Add new address',
        'total' => 'Total addresses',
    ],

    'payment_system' => [
        'title' => 'Payment system',
        'info' => 'Payment information',
    ],

    'settings' => [
        'site' => 'Site settings',
        'general_settings' => 'General settings',
        'registration_method' => 'Registration method',
        'invitation_only' => 'Registration by invitation only',
    ],

    'content' => [
        'title' => 'Title',
        'text' => 'Text',
        'status' => 'Status',
        'delayed_publication' => 'Delayed publication',
        'many' => 'Contents',
        'add' => 'Add new content',
        'preview' => 'Preview',
        'update' => 'Update content',
        'total' => 'Total contents',
    ],

    'statistic' => [
        'general' => 'General',
        'user' => 'User',
        'user_statistics' => 'User statistics',
        'finance' => 'Finance',
        'finance_statistics' => 'Finance statistics',
        'total' => 'Total',
        'date' => 'Date',
        'full_amount_top_up' => 'Sum amount (top up)',
        'full_amount_withdraw' => 'Sum full amount (withdraw)',
        'amount_top_up' => 'Amount (top up)',
        'amount_withdraw' => 'Amount (withdraw)',
        'commission_amount' => 'Commission amount',
        'payments' => 'Payments',
        'transactions' => 'Transactions',
        'name' => 'Name',
        'value' => 'Value',
        'total_user_balance' => 'Total user balance',
        'total_payments' => 'Total (sum) payments',
        'commission' => 'Commission',
        'total_commission' => 'Total commission',
        'total_referral_payments' => 'Total referral payments',
        'diff_balance' => 'Balance difference',
        'info_1' => 'Success payments sum (top up, withdraw and referral commission) group by day',
        'info_2' => 'Success top up transactions',
        'info_3' => 'Success withdraw payments',
        'info_4' => 'Success withdraw transactions',
    ],

    'input' => [
        'email' => 'Email address',
        'password' => 'Password',
        'repeat_password' => 'Repeat password',
        'code' => 'Telegram code',
    ],

    'btn' => [
        'submit' => 'Submit',
        'logout' => 'Logout',
        'update' => 'Update',
        'create' => 'Create',
        'close' => 'Close',
        'delete' => 'Delete',
        'return' => 'Return',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],

    'headers' => [
        'sure' => 'Are you sure?',
    ],

    'error' => [
        'auth' => 'Auth error!',
        '2fa' => 'Please, enter 2fa code!',
        'withdraw' => 'Can\'t create withdraw payment',
        'update_payment' => 'Can\'t update payment',
        'create_payment' => 'Can\'t create payment',
        'create' => 'Can\'t create',
        'update' => 'Can\'t update',
    ],
];
