<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Commands\Database\Migrate;
use Config\Services;
use App\Models\UserDetailsModel;
use App\Entities\UserDetails;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class ResetInvoiceOrder extends BaseCommand
{
    protected $group       = 'ecm';
    protected $name        = 'ecm:resetorder';
    protected $description = 'Resets the sorting of the invoice items. Sorting by ID.';

    protected array $params;

    public function run(array $params)
    {
        helper('custom');

        $invoices = model('InvoiceModel')->findAll();
        foreach($invoices as $invoice){
            $positions = model('InvoicePositionModel')
                ->where('invoice_id', $invoice->id)
                ->orderBy('id', 'asc')
                ->findAll();
            $i = 0;
            foreach($positions as $position){
                $i++;
                $position->ord = $i;
                if($position->hasChanged()){
                    model('InvoicePositionModel')->save($position);
                }
            }
        }
    
    }
}