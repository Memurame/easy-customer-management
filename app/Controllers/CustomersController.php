<?php

namespace App\Controllers;

use App\Entities\Customer;
use App\Entities\CustomerContact;
use App\Models\CommentModel;
use App\Models\CustomerContactModel;
use App\Models\CustomerModel;

class CustomersController extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        return view("customer/index", [
            "customers" => $customers,
        ]);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $rules = [
                "customername" => "required",
                "street" => "required",
                "postcode" => "required",
                "city" => "required",
                "status" => "required",
                "contact_firstname" => "required",
                "contact_lastname" => "required"
            ];

            if (!$this->validate($rules)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with("errors", $this->validator->getErrors())
                    ->with(
                        "msg_error",
                        "Bitte alle erforderlichen Felder ausfüllen",
                    );
            }

            $customer = new Customer(
                $this->request->getPost([
                    "status",
                    "customername",
                    "mail",
                    "phone",
                    "street",
                    "postcode",
                    "city",
                    "notes",
                    "addressnumber",
                ]),
            );

            $customerModel = new CustomerModel();
            $customerModel->save($customer);

            $customer = $customerModel->find($customerModel->getInsertID());

            $customerContact = new CustomerContact();
            $customerContact->customer_id = $customer->id;
            $customerContact->firstname = $this->request->getPost(
                "contact_firstname",
            );
            $customerContact->lastname = $this->request->getPost(
                "contact_lastname",
            );
            $customerContact->street = $this->request->getPost(
                "contact_street",
            );
            $customerContact->postcode = $this->request->getPost(
                "contact_postcode",
            );
            $customerContact->city = $this->request->getPost("contact_city");
            $customerContact->phone = $this->request->getPost("contact_phone");
            $customerContact->mail = $this->request->getPost("contact_mail");
            $customerContact->typ = $this->request->getPost("contact_typ");

            $customerContactModel = new CustomerContactModel();
            $customerContactModel->save($customerContact);
            $insertID = $customerContactModel->getInsertID();

            $customer->billing_contact = $this->request->getPost(
                "billing_contact",
            )
                ? $insertID
                : null;
            $customer->main_contact = $insertID;
            $customerModel->save($customer);

            session()->setFlashdata(
                "msg_success",
                "Kunde erfolgreich angelegt.",
            );

            return redirect()->route("customer.index");
        }

        return view("customer/add", []);
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            session()->setFlashdata(
                "msg_error",
                "Der ausgewählte Kunde wurde nicht gefunden.",
            );
            return redirect()->route("customer.index");
        }

        $customerContactModel = new CustomerContactModel();
        $customerContacts = $customerContactModel
            ->where("customer_id", $customer->id)
            ->findAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $rules = [
                "customername" => "required",
                "status" => "required",
                "main_contact" => "required",
                "street" => "required",
                "postcode" => "required",
                "city" => "required"
            ];

            if (!$this->validate($rules)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with("errors", $this->validator->getErrors())
                    ->with(
                        "msg_error",
                        "Bitte alle erforderlichen Felder ausfüllen",
                    );
            }

            $checkMainContact = $customerContactModel
                ->where("id", $this->request->getPost("main_contact"))
                ->where("customer_id", $customer->id)
                ->findAll();
            if (!$checkMainContact) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with("errors", $this->validator->getErrors())
                    ->with(
                        "msg_error",
                        "Der ausgewählte Hauptkontakt wurde nicht gefunden. Wähle ein Kontakt aus dem Dropdown aus.",
                    );
            }
            $customer->addressnumber = $this->request->getPost("addressnumber");
            $customer->customername = $this->request->getPost("customername");
            $customer->mail = $this->request->getPost("mail");
            $customer->phone = $this->request->getPost("phone");
            $customer->street = $this->request->getPost("street");
            $customer->postcode = $this->request->getPost("postcode");
            $customer->city = $this->request->getPost("city");
            $customer->addressnumber = $this->request->getPost("addressnumber");
            $customer->status = $this->request->getPost("status");
            $customer->notes = $this->request->getPost("notes");

            $customer->billing_contact =
                $this->request->getPost("billing_contact") ?: null;

            $customer->main_contact = $this->request->getPost("main_contact");

            if ($customer->hasChanged()) {
                $customerModel->save($customer);
                session()->setFlashdata("msg_success", "Kunde gespeichert.");
            } else {
                session()->setFlashdata(
                    "msg_info",
                    "Es wurden keine änderungen erkannt.",
                );
            }

            return redirect()->route("customer.show", [$id]);
        }

        return view("customer/edit", [
            "customer" => $customer,
            "contacts" => $customerContacts,
        ]);
    }

    public function show($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        $customer->mainContact();
        $customer->allContacts();

        if (!$customer) {
            session()->setFlashdata(
                "msg_error",
                "Der ausgewählte Kunde wurde nicht gefunden.",
            );
            return redirect()->route("customer.index");
        }

        $commentModel = new CommentModel();
        $comments = $commentModel
            ->where("customer_id", $customer->id)
            ->orderBy("id", "desc")
            ->findAll();

        return view("customer/show", [
            "customer" => $customer,
            "comments" => $comments,
        ]);
    }

    public function apiDelete($id)
    {
        $data = [];
        $data["success"] = 0;
        $data["token"] = csrf_hash();

        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (empty($customer)) {
            $data["error"] = "Kunde wurde nicht gefunden.";
        } else {
            $customerContactsModel = model(CustomerContactModel::class);
            $deleteContact = $customerContactsModel
                ->where("customer_id", $customer->id)
                ->delete();

            if ($deleteContact) {
                $deleted = $customerModel->delete($customer->id);
                if ($deleted) {
                    $data["success"] = 1;
                } else {
                    $data["error"] = "Fehler beim Löschen des Kunden";
                }
            } else {
                $data["error"] = "Fehler beim Löschen der Kunden Kontakte";
            }
        }

        return $this->response->setJSON($data);
    }
}