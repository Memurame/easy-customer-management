<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class ToolsEstosController extends BaseController
{
    public string $fileCSV = FCPATH . '../writable/export/estos.csv';
    public string $fileJSON = FCPATH . '../writable/export/estos.json';
    public string $fileKalahari = FCPATH . '../writable/export/kalahari.json';

    public function importAbacus(){

        $validationRule = [
            'abacus_import' => [
                'label' => 'Abacus Adressen',
                'rules' => [
                    'uploaded[abacus_import]'
                ],
            ],
        ];
        if (! $this->validate($validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];

            return redirect()->route('estos.index')->with('msg_error', 'Fehler beim hochaden der Datei, prüfe deine Eingabe. Nur JSON Datei möglich.');
        }

        $uploadFile = $this->request->getFile('abacus_import');

        if (! $uploadFile->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $uploadFile->store();
        }




        $inputFileName = $filepath;
        $json = json_decode(file_get_contents($inputFileName), true);
        
        $fp = fopen($this->fileCSV, 'w');


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
        fputcsv($fp, $title, ";");

        $adressen = $json[array_key_first($json)];
        $returnArray = [];

        $kalahari = json_decode(file_get_contents($this->fileKalahari), true);

        // Alle Adressen durchschleifen
        for($i = 0; $i < count($adressen); $i++){

            // Die Adressen welche als Inaktv markiert sind heruasfiltern
            // Wenn der Wert 1 ist dann  ist die Adresse inaktiv markiert
            if($adressen[$i]['Inaktiv'] == 1) continue;

            // Das Datum welches im Excel in einem Datumformat war, wieder in ein normales Format umwandeln
            // Falls das Datum leer ist, NULL zurückgeben
            $adressDate = (!empty($adressen[$i]['Zahldatum'])) ? date("d.m.Y", convertExcelDateToUnix($adressen[$i]['Zahldatum'])) : null;
            $adressDateArray = explode(".", $adressDate);
            // Prüfen on ein Zahldatum gesetzt ist.
            // von Juli-Dezember die Mitgliederart anhand des Zahldatums anpassen
            // NM welche im laufenden Jahr ab Juli bezahlt haben und über 70 % bezahlt haben, die Mitgliederart auf AM Wechseln

            if(isset($adressDate) AND
                $currentDate['year'] == $adressDateArray[2] AND
                $currentDate['month'] >= 7 AND
                $adressen[$i]['Bez in %'] >= 70 AND
                $adressen[$i]['Mitgliederart'] == "NM"){
                $adressen[$i]['Mitgliederart'] = "AM";
            }

            // Bei Mitgliederart AM und MK den Status "Rechnung bezahlt" setzen.
            if($adressen[$i]['Mitgliederart'] == "AM" OR $adressen[$i]['Mitgliederart'] == "MK"){
                $adressen[$i]['Status'] = "Rechnung bezahlt";
            }
            // CAJB Mitglieder erhalten den Status "CAJB"
            else if($adressen[$i]['Mitgliederart'] == "CAJB"){
                $adressen[$i]['Status'] = "CAJB";
            }
            // Adressen mit einem NM erhalten den Status "UNBEZAHLT"
            else if($adressen[$i]['Mitgliederart'] == "NM"){
                $adressen[$i]['Status'] = "UNBEZAHLT";
            }
            // Alle Anderen erhalten den Status "Keine Rechnung"
            else {
                $adressen[$i]['Status'] = "keine Rechnung";
            }$upas = Array("/" => "", "." => "", "-" => "", "'" => "");

            // Bei den Telefonnummern die (Sonder)Zeichen: / . - ' entfernen
            $adressen[$i]['Telefon 1'] = removeSpecialchar($adressen[$i]['Telefon 1']);
            $adressen[$i]['Telefon 2'] = removeSpecialchar($adressen[$i]['Telefon 2']);
            $adressen[$i]['Mobiltelefon'] = removeSpecialchar($adressen[$i]['Mobiltelefon']);

            // Die Telefonnummer und handynummer so formatieren damit diese mit der Kalahariliste abgeglichen werden können
            // Diese sollten im Format sein wie im folgenden Beispiel: 319382280
            $telefon = removeSpecialchar($adressen[$i]['Telefon 1'], true);
            $telefon = (string)((int)($telefon));

            $telefon2 = removeSpecialchar($adressen[$i]['Telefon 2'], true);
            $telefon2 = (string)((int)($telefon2));

            $mobile = removeSpecialchar($adressen[$i]['Mobiltelefon'], true);
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
            $returnArray[$i][$title[0]] = $adressen[$i]['AdressNr'];
            $returnArray[$i][$title[1]] = $adressen[$i]['Vorname'];
            $returnArray[$i][$title[2]] = $adressen[$i]['Name'];
            $returnArray[$i][$title[3]] = $adressen[$i]['Strasse'];
            $returnArray[$i][$title[4]] = $adressen[$i]['Plz'];
            $returnArray[$i][$title[5]] = $adressen[$i]['Ort'];
            $returnArray[$i][$title[6]] = $adressen[$i]['Telefon 1'];
            $returnArray[$i][$title[7]] = $adressen[$i]['Mobiltelefon'];
            $returnArray[$i][$title[8]] = $adressen[$i]['E-Mail'];
            $returnArray[$i][$title[9]] = $adressen[$i]['Mitgliederart'];
            $returnArray[$i][$title[10]] = $adressen[$i]['Bez in %'];
            $returnArray[$i][$title[11]] = $adressDate;
            $returnArray[$i][$title[12]] = $adressen[$i]['Status'];
            $returnArray[$i][$title[13]] = $adressen[$i]['KalahariId'];
            $returnArray[$i][$title[14]] = $adressen[$i]['Telefon 2'];

            fputcsv($fp, $returnArray[$i], ";");
        }

        fclose($fp);

        service('settings')->set('App.lastAbacusImport', date('d.m.Y - H:i:s'));
        file_put_contents($this->fileJSON, json_encode($returnArray));

        unlink($filepath);

        return redirect()->route('estos.index')->with('msg_success', 'Adressen wurden importiert');
    }

    public function index()
    {
        if(file_exists($this->fileJSON)){
            $adressen = json_decode(file_get_contents($this->fileJSON), true);
        }
        return view('tools/estos-phonelist', [
            'adressen' => $adressen ?? [],
            'preview'  => $this->request->getGet('preview')
        ]);

    }

    public function export(){

        if(file_exists($this->fileCSV)){
            return $this->response->download($this->fileCSV, null)->setFileName(date('Y-m-d').'_telefonliste.csv');
        }

        return false;
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

        if (! $uploadFile->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $uploadFile->store();

        }
        $json = json_decode(file_get_contents($filepath), true);
        $kalahari = $json[array_key_first($json)];


        $array = [];
        foreach($kalahari as $key => $val){
            if(!empty($val['tel_1'])){

                $telefon = removeSpecialchar($val['tel_1']);
                $telefon = (string)((int)($telefon));

                $array[$val['id_nr']] = $val['tel_1'];
                //$insert = Model(AbacusKalahariModel::class)->save($data);
            }

        }
        file_put_contents($this->fileKalahari, json_encode($array));

        service('settings')->set('App.lastKalahariImport', date('d.m.Y - H:i:s'));

        unlink($filepath);

        return redirect()->route('estos.index')->with('msg_success', 'Kalahari Einträge wurden importiert');
    }
}