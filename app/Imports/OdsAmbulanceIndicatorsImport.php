<?php

namespace App\Imports;


use App\Models\OdsAmbulanceBrigades;
use App\Models\OdsAmbulanceHospitals;
use App\Models\OdsAmbulanceIndicators;
use App\Models\OdsAmbulanceReferences;
use App\Models\OdsAmbulanceSubstations;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;


class OdsAmbulanceIndicatorsImport implements ToCollection, SkipsOnError, WithHeadingRow, WithChunkReading, WithMapping#, WithValidation
{
    protected $excel_id;
    protected $region_coato;
    protected $end_date;
    protected $start_date;

    public function __construct($excel_id, $region_coato, $start_date, $end_date)
    {
        $this->excel_id = $excel_id;
        $this->region_coato = $region_coato;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $data_priema = strtotime($row['data_priema']);
            $data_p = date("Y-m-d", $data_priema);
            if ($data_p >= $this->start_date and $data_p <= $this->end_date and $data_p != null and $row['peredaca_brigade'] != null) {
                try {
                    $substation = OdsAmbulanceSubstations::findOrCreate($row['podstanciia'], $this->region_coato);
                    $type = OdsAmbulanceReferences::findOrCreate($row['tip_vyzova'], 'call_types');
                    $reason = OdsAmbulanceReferences::findOrCreate($row['povod'], 'reasons');
                    $call_result = OdsAmbulanceReferences::findOrCreate($row['rezultat_vyezda'], 'call_results');
                    $hospitalization_result = $row['rez_tat_gosp_cii'] ? OdsAmbulanceReferences::findOrCreate($row['rez_tat_gosp_cii'], 'hospitalization_results') : null;
                    $call_place = OdsAmbulanceReferences::findOrCreate($row['mesto_vyzova'], 'call_places');
                    $diagnosis = OdsAmbulanceReferences::findOrCreate($row['diagnoz'], 'diagnoses');
                    $hospital = OdsAmbulanceHospitals::findOrCreate($row['mesto_gospit'], $this->region_coato);
                    $brigade = OdsAmbulanceBrigades::findOrCreate($row['brigada'], $substation);
                    OdsAmbulanceIndicators::create([
                        'call_region_coato' => $this->region_coato,
                        'substation_id' => $substation,
                        'filling_call_card' => $row['kv_zapolnena'] ? $row['kv_zapolnena'] : null,
                        'call_type_id' => $type,
                        'card_number' => $row['pp'],
                        'call_received' => $row['data_priema'],
                        'call_reception' => $data_p . ' ' . $row['vremia_priema'],
                        'transfer_brigade' => $row['peredaca_brigade'] ? $row['peredaca_brigade'] : null,
                        'brigade_departure' => $row['vremia_vyezda_br'] ? $row['vremia_vyezda_br'] : null,
                        'arrival_brigade_place' => $row['pribytie_na_vyz'] ? $row['pribytie_na_vyz'] : null,
                        'transportation_start' => $row['nacalo_transp_ki'] ? $row['nacalo_transp_ki'] : null,
                        'arrival_medical_center' => $row['prib_ie_v_medorg'] ? $row['prib_ie_v_medorg'] : null,
                        'call_end' => $row['okoncanie_vyzova'] ? $row['okoncanie_vyzova'] : null,
                        'return_substation' => $row['vozvr_nie_na_pst'] ? $row['vozvr_nie_na_pst'] : null,
                        'brigade_id' => $brigade,
                        'address' => $row['adres_prozivaniia'] ? $row['adres_prozivaniia'] : null,
                        'reason_id' => $reason,
                        'gender' => $row['pol'] ? $row['pol'] : null,
                        'age' => $row['vozrast'] ? $row['vozrast'] : null,
                        'diagnos' => $row['kod_mkb'] ? $row['kod_mkb'] : null,
                        'call_result_id' => $call_result,
                        'hospital_id' => $hospital,
                        'hospitalization_result_id' => $hospitalization_result,
                        'call_place_id' => $call_place,
                        'brigade_call_time' => $row['vr_doezda_na_vyz'] ? $row['vr_doezda_na_vyz'] : null,
                        'travel_time' => $row['vrna_prinvyzbr'] ? $row['vrna_prinvyzbr'] : null,
                        'diagnosis_id' => $diagnosis,
                        'excel_id' => $this->excel_id
                    ]);
                } catch(\Exception $e) {
                    $errorMessage = "[" . date("Y-m-d H:i:s") . "] Xatolik: " . $e->getMessage() . " Qatorda: " . json_encode($row) . "\n";
                    file_put_contents("import_errors.log", $errorMessage, FILE_APPEND);
                }
            }


        }


//            $called_person = OdsAmbulanceReferences::findOrCreate($row['vyzvavsii'], 'called_persons');
//                'beginning_formation_ct' => $row['data_priema'] . ' ' . $row['vr_nac_form_kt'],
//                'called_person_id' => $called_person,

    }

    public function map($row): array
    {

        $row['peredaca_brigade'] = explode('.', $row['peredaca_brigade'])[0];
        $row['vremia_vyezda_br'] = explode('.', $row['vremia_vyezda_br'])[0];
        $row['pribytie_na_vyz'] = explode('.', $row['pribytie_na_vyz'])[0];

        return $row;
    }

    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

    public function chunkSize(): int
    {
        return 1000;
    }

//    public function rules(): array
//    {
//
//        return [
//            '*.peredaca_brigade' => 'required|date',
//            '*.vremia_vyezda_br' => 'required|date',
////            '*.pribytie_na_vyz' => 'required|date',
////            '*.pp' => 'required|integer',
////            '*.podstanciia' => 'required',
////            '*.kv_zapolnena' => ['required', Rule::in(["да", "нет"])],
////            '*.tip_vyzova' => 'required|string',
////            '*.data_priema' => [
////                'required',
////                'date',
////                'after_or_equal:'.$this->start_date,
////                'before_or_equal:'.$this->end_date,
////            ],
//            '*.vremia_priema' => 'required',
////            '*.vr_nac_form_kt' => 'required',
////            '*.nacalo_transp_ki' => 'nullable',
////            '*.prib_ie_v_medorg' => 'nullable',
////            '*.okoncanie_vyzova' => 'required|date',
////            '*.vozvr_nie_na_pst' => 'nullable',
////            '*.brigada' => 'required',
////            '*.adres' => 'nullable',
////            '*.povod' => 'required',
////            '*.pol' => 'nullable',
////            '*.vozrast' => ['required', new ExcelAgeRule()],
////            '*.diagnoz' => 'required|string',
////            '*.rezultat_vyezda' => 'required',
////            '*.mesto_gospit' => 'nullable',
////            '*.rez_tat_gosp_cii' => 'nullable',
////            '*.vyzvavsii' => 'required',
////            '*.mesto_vyzova' => 'required',
//            '*.vr_doezda_na_vyz' => 'required',
//            '*.vrna_prinvyzbr' => 'required',
//            '*.kod_mkb' => 'nullable',
//        ];
//    }
}
