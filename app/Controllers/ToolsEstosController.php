<?php

namespace App\Controllers;

use App\Models\AbaKalahariModel;
use CodeIgniter\Files\File;

class ToolsEstosController extends BaseController
{
    
    public function index()
    {
        return view('tools/estos-phonelist', [
            'adressen' => $adressen ?? [],
            'preview'  => $this->request->getGet('preview')
        ]);

    }

    public function export_OLD(){

        $adressen = model('abaAddressModel')
            ->where('abacus IS NOT NULL', null)
            ->where('inactive', NULL)
            ->findAll();

        $currentDate['year'] = date('Y');
        $currentDate['month'] = date('m');

        $title = [
            'AbacusNr',
            'Vorname',
            'Nachname',
            'Strasse',
            'Plz',
            'Ort',
            'Telefon',
            'Mobile',
            'Mail',
            'Mitgliederart',
            'Bezahlt in %',
            'Zahldatum',
            'Status',
            'KalahariId',
            'Telefon2'
        ];
        $returnArray = [];

        $kalahari = json_decode(file_get_contents(FCPATH . '../writable/export/kalahari.json'), true);

        $fileOut = fopen("php://output", 'w') or die("Unable open php://output");
        fputcsv($fileOut, $title, ';');

        // Header forces the CSV file to download
        header("Content-Type:application/csv");
        header("Content-Disposition:attachment;filename=example-csv.csv");

        // Alle Adressen durchschleifen
        for($i = 0; $i < count($adressen); $i++){

            // Das Datum welches im Excel in einem Datumformat war, wieder in ein normales Format umwandeln
            // Falls das Datum leer ist, NULL zurückgeben
            //$adressDate = (!empty($adressen[$i]['Zahldatum'])) ? date("d.m.Y", convertExcelDateToUnix($adressen[$i]['Zahldatum'])) : null;
            $adressDate = (!empty($address[$i]['paid_date'])) ? date('d.m.Y',strtotime($address[$i]['paid_date'])) : NULL;
            $adressDateArray = explode(".", $adressDate);
            // Prüfen on ein Zahldatum gesetzt ist.
            // von Juli-Dezember die Mitgliederart anhand des Zahldatums anpassen
            // NM welche im laufenden Jahr ab Juli bezahlt haben und über 70 % bezahlt haben, die Mitgliederart auf AM Wechseln

            if(isset($adressDate) AND
                $currentDate['year'] == $adressDateArray[2] AND
                $currentDate['month'] >= 7 AND
                $adressen[$i]['paid_percent'] >= 70 AND
                $adressen[$i]['member_typ'] == "NM"){
                $adressen[$i]['member_typ'] = "AM";
            }

            // Bei Mitgliederart AM und MK den Status "Rechnung bezahlt" setzen.
            if($adressen[$i]['member_typ'] == "AM" OR $adressen[$i]['member_typ'] == "MK"){
                $adressen[$i]['Status'] = "Rechnung bezahlt";
            }
            // CAJB Mitglieder erhalten den Status "CAJB"
            else if($adressen[$i]['member_typ'] == "CAJB"){
                $adressen[$i]['Status'] = "CAJB";
            }
            // Adressen mit einem NM erhalten den Status "UNBEZAHLT"
            else if($adressen[$i]['member_typ'] == "NM"){
                $adressen[$i]['Status'] = "UNBEZAHLT";
            }
            // Alle Anderen erhalten den Status "Keine Rechnung"
            else {
                $adressen[$i]['Status'] = "keine Rechnung";
            }

            // Bei den Telefonnummern die (Sonder)Zeichen: / . - ' entfernen
            $adressen[$i]['phone1'] = removeSpecialchar($adressen[$i]['phone1']);
            $adressen[$i]['phone2'] = removeSpecialchar($adressen[$i]['phone2']);
            $adressen[$i]['mobile'] = removeSpecialchar($adressen[$i]['mobile']);

            // Die Telefonnummer und handynummer so formatieren damit diese mit der Kalahariliste abgeglichen werden können
            // Diese sollten im Format sein wie im folgenden Beispiel: 319382280
            $telefon = removeSpecialchar($adressen[$i]['phone1'], true);
            $telefon = (string)((int)($telefon));

            $telefon2 = removeSpecialchar($adressen[$i]['phone2'], true);
            $telefon2 = (string)((int)($telefon2));

            $mobile = removeSpecialchar($adressen[$i]['mobile'], true);
            $mobile = (string)((int)($mobile));

            // In der kalahari Liste nach vorhandener Telefonnummer suchen
            // Die Kalahari Liste wurde vorgängig als JSON Importiert im Format:
            // {"223069":"324921539","214479":"344151384"}
            //     ID     Telnummer     ID     Telnummer
            // Eine Telefnonnummer kann mehrere Kalahari Nummern haben
            $t1 = array_keys($kalahari, $telefon);
            $t2 = array_keys($kalahari, $telefon2);
            $t3 = array_keys($kalahari, $mobile);

            // Die Beiden Ergebnisse, Telefonnummer und Mobile zusammenführen
            $adressen[$i]['KalahariId'] = implode(",", array_merge($t1, $t2, $t3));


            // Export der Mitgliederdaten aufbereiten
            $returnArray[$i][$title[0]] = $adressen[$i]['abacus'];
            $returnArray[$i][$title[1]] = $adressen[$i]['firstname'];
            $returnArray[$i][$title[2]] = $adressen[$i]['lastname'];
            $returnArray[$i][$title[3]] = $adressen[$i]['street'];
            $returnArray[$i][$title[4]] = $adressen[$i]['postcode'];
            $returnArray[$i][$title[5]] = $adressen[$i]['city'];
            $returnArray[$i][$title[6]] = $adressen[$i]['phone1'];
            $returnArray[$i][$title[7]] = $adressen[$i]['mobile'];
            $returnArray[$i][$title[8]] = $adressen[$i]['email'];
            $returnArray[$i][$title[9]] = $adressen[$i]['member_typ'];
            $returnArray[$i][$title[10]] = $adressen[$i]['paid_percent'];
            $returnArray[$i][$title[11]] = $adressDate;
            $returnArray[$i][$title[12]] = $adressen[$i]['Status'];
            $returnArray[$i][$title[13]] = $adressen[$i]['KalahariId'];
            $returnArray[$i][$title[14]] = $adressen[$i]['phone2'];
            fputcsv($fileOut, $returnArray[$i], ';');

        }

        fclose($fileOut) or die("Unable to close php://output");
    }

    public function export(){

        $outputfile = FCPATH . '../writable/export/telefonliste.csv';

        // Header forces the CSV file to download
        header("Content-Type:application/csv");
        header("Content-Disposition:attachment;filename=telefonliste_".date('Y-m-d').".csv");
        readfile( $outputfile );
        
    }

    public function importKalahari(){

        

        $validationRule = [
            'kalahari_import' => [
                'label' => 'Abacus Adressen',
                'rules' => [
                    'uploaded[kalahari_import]'
                ],
            ],
        ];
        if (! $this->validate($validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];

            return redirect()->route('estos.index')->with('msg_error', 'Fehler beim hochaden der Datei, prüfe deine Eingabe. Nur JSON Datei möglich.');
        }

        $uploadFile = $this->request->getFile('kalahari_import');
        $uploadFile->move(WRITEPATH . 'uploads/temp', 'kalahari.json', true);

        service('settings')->set('App.lastKalahariImportReceiver', auth()->user()->email);
        
        unlink(WRITEPATH . 'export/telefonliste.csv');

        return redirect()->route('estos.index')->with('message', 'Die Datei wurde hochgeladen und wird in den nächsten Minuten im Hintergrund verarbeitet. Du erhälst eine E-Mail sobald der Import abgeschlossen ist.');
    }
}