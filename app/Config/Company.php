<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Company extends BaseConfig
{

    public string $name = 'ECM Kundenverwaltung';

    public string $street = 'Musterstrasse 119';

    public string $postcode = '3000';

    public string $city = 'Bern';

    public string $phone = '+41 31 654 32 98';

    public string $mail = 'info@ecm.ch';

    public string $website;

    public string $mwst;

    public string $iban;

    public bool $invoice = false;

    public string $invoice_qr = 'iban';

    public string $qriban;

    public string $qriban_reference;

    public int $payment_deadline = 30;




}