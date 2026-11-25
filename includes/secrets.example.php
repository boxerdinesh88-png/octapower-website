<?php
// Copy this file to includes/secrets.php ON THE SERVER and fill it in. Never upload secrets.php to GitHub.
// Database details: InfinityFree dashboard -> your account -> MySQL Databases.
const DB_HOST = '';            // e.g. sql100.infinityfree.com  (leave empty to save forms to files instead)
const DB_NAME = '';            // e.g. if0_43530189_octapower
const DB_USER = '';            // e.g. if0_43530189
const DB_PASS = '';            // your hosting account password (InfinityFree -> Account Details)

// Auto-reply + office notification emails, sent from your Hostinger mailbox.
const SMTP_HOST = 'smtp.hostinger.com';
const SMTP_PORT = 465;
const SMTP_USER = 'info@octapower.in';
const SMTP_PASS = '';          // the info@octapower.in mailbox password (leave empty to turn emails off)

// Admin page login (/admin). Use a strong password of at least 10 characters.
const ADMIN_USER = 'admin';
const ADMIN_PASS = '';
