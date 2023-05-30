@extends('dashboard.layouts.default')

@section('content')
    <h1 class="page-header">Политравма-детальная таблица</h1>
    <div class="row justify-content-center">
        @foreach($data as $key => $item)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Форма {{$item->id}}</h5>
                        <table class="table table-striped table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th>id</th>
                                    <td>{{$item->id}}</td>
                                </tr>
                                <tr>
                                    <th>department</th>
                                    <td>{{$item->department}}</td>
                                </tr>
                                <tr>
                                    <th>history_disease</th>
                                    <td>{{$item->history_disease}}</td>
                                </tr>
                                <tr>
                                    <th>full_name</th>
                                    <td>{{$item->full_name}}</td>
                                </tr>
                                <tr>
                                    <th>hospitalization_date</th>
                                    <td>{{$item->hospitalization_date}}</td>
                                </tr>
                                <tr>
                                    <th>discharge_date</th>
                                    <td>{{$item->discharge_date}}</td>
                                </tr>
                                <tr>
                                    <th>hospitalization_channels</th>
                                    <td>{{$item->hospitalization_channels}}</td>
                                </tr>
                                <tr>
                                    <th>treatment_result</th>
                                    <td>{{$item->treatment_result}}</td>
                                </tr>
                                <tr>
                                    <th>severity_of_ts</th>
                                    <td>{{$item->severity_of_ts}}</td>
                                </tr>
                                <tr>
                                    <th>injury_of_iss</th>
                                    <td>{{$item->injury_of_iss}}</td>
                                </tr>
                                <tr>
                                    <th>arrival_after_injury</th>
                                    <td>{{$item->arrival_after_injury}}</td>
                                </tr>
                                <tr>
                                    <th>mechanism_of_injury</th>
                                    <td>{{$item->mechanism_of_injury}}</td>
                                </tr>

                                <tr>
                                    <th>survey_of_surgeon</th>
                                    <td>{{$item->survey_of_surgeon}}</td>
                                </tr>
                                <tr>
                                    <th>survey_of_neurosurgeon</th>
                                    <td>{{$item->survey_of_neurosurgeon}}</td>
                                </tr>
                                <tr>
                                    <th>survey_of_traumatologist</th>
                                    <td>{{$item->survey_of_traumatologist}}</td>
                                </tr>
                                <tr>
                                    <th>narrow_specialists</th>
                                    <td>{{$item->narrow_specialists}}</td>
                                </tr>
                                <tr>
                                    <th>r_graphy</th>
                                    <td>{{$item->r_graphy}}</td>
                                </tr>
                                <tr>
                                    <th>conducted_ultrasound</th>
                                    <td>{{$item->conducted_ultrasound}}</td>
                                </tr>
                                <tr>
                                    <th>msct</th>
                                    <td>{{$item->msct}}</td>
                                </tr>
                                <tr>
                                    <th>msct_individual_parts</th>
                                    <td>{{$item->msct_individual_parts}}</td>
                                </tr>
                                <tr>
                                    <th>neutral_fats</th>
                                    <td>{{$item->neutral_fats}}</td>
                                </tr>
                                <tr>
                                    <th>analysis_of_hb_ht</th>
                                    <td>{{$item->analysis_of_hb_ht}}</td>
                                </tr>
                                <tr>
                                    <th>dynamic_uzs</th>
                                    <td>{{$item->dynamic_uzs}}</td>
                                </tr>
                                <tr>
                                    <th>diagnostic_laparoscopy</th>
                                    <td>{{$item->diagnostic_laparoscopy}}</td>
                                </tr>
                                <tr>
                                    <th>thoracocentesis</th>
                                    <td>{{$item->thoracocentesis}}</td>
                                </tr>
                                <tr>
                                    <th>laparotomy</th>
                                    <td>{{$item->laparotomy}}</td>
                                </tr>
                                <tr>
                                    <th>thoracoscopy_thoracotomy</th>
                                    <td>{{$item->thoracoscopy_thoracotomy}}</td>
                                </tr>
                                <tr>
                                    <th>osteosynthesis_of_fractures</th>
                                    <td>{{$item->osteosynthesis_of_fractures}}</td>
                                </tr>
                                <tr>
                                    <th>skull_trepanation</th>
                                    <td>{{$item->skull_trepanation}}</td>
                                </tr>
                                <tr>
                                    <th>physician_full_name</th>
                                    <td>{{$item->physician_full_name}}</td>
                                </tr>
                                <tr>
                                    <th>stat_department_full_name</th>
                                    <td>{{$item->stat_department_full_name}}</td>
                                </tr>          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection