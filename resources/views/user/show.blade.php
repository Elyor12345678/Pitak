@extends('layout.layout')

@section('title')
    {{-- Your page title --}}
@endsection
@section('content')
    <style>
        .profile_box {
            width: auto;
            height: auto;
            background: #FFFFFF;
            border-radius: 10px;
            padding: 22px;
        }
        @media screen and (max-width: 1180px) {
            .profile_box_content {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .profile_box_content>div{
                margin-bottom: 18px;
            }
        }
        @media screen and (min-width: 1181px) {
            .profile_box_content {
                display: flex;
                justify-content: space-between;
            }
        }
        .text_value {
            width: 262px;
            padding: 20px;
            background: #EBEFF2;
            border-radius: 20px;
            font-family: "Times New Roman";
            font-style: normal;
            font-weight: 700;
            font-size: 18px;
            line-height: 22px;
            color: #000000;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }
        .color_black{
            color: black;
        }
        .text_name {
            font-family: inter;
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 24px;
            color: #000000;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <h4 class="mt-0 header-title">{{translate('User informations')}}</h4>
            <div class="dropdown float-end">
                <a class="form_functions btn btn-success" href="{{route('user.create')}}">{{translate('Create')}}</a>
            </div>
            <div class="account">
                <div class="profile_box">
                    <div class="d-flex align-items-start">
                        <div>
                            @php
                                $sms_avatar = storage_path('app/public/user/'.$model->personalInfo->avatar);
                            @endphp
                            @php
                                $birth_date_array = explode(' ', $model->personalInfo->birth_date);
                                $now_time = strtotime('now');
                                $birth_time = strtotime($model->personalInfo->birth_date);
                                $month = date('m', ($now_time));
                                $day = date('d', ($now_time));
                                $birth_month = date('m', ($birth_time));
                                $birth_date = date('d', ($birth_time));
                                $year = date('Y', ($now_time));
                                $birth_year = date('Y', ($birth_time));
                                $year_old = 0;
                                if($year > $birth_year){
                                    $year_old = $year - $birth_year - 1;
                                    if($month > $birth_month){
                                        $year_old = $year_old +1;
                                    }elseif($month == $birth_month){
                                        if($day >= $birth_date){
                                            $year_old = $year_old +1;
                                        }
                                    }
                                }
                            @endphp
                            @if(file_exists($sms_avatar))
                                <img class="user_photo_2" src="{{asset('storage/user/'.$model->personalInfo->avatar)}}" alt="">
                            @else
                                <img class="user_photo_2" src="{{asset('assets/images/man.jpg')}}" alt="">
                            @endif
                        </div>
                        <div class="color_black" style="margin-left: 30px;">
                            <h3 class="color_black">{{$model->personalInfo->first_name.' '.$model->personalInfo->last_name.' '.$model->personalInfo->middle_name}}</h3>
                            <p>{{translate('Role').': '}}<b>{{$model->role->name }}</b></p>
                            <p>{{translate('Phone').': '}}<b>{{$model->personalInfo->phone_number}}</b></p>
                            <p>{{translate('Age').': '}}<b>{{$year_old}}</b></p>
                        </div>
                    </div>

                    <div class="profile_box_content">
                        <div style="width: auto;">
                            <div class="d-flex justify-content-between">
                                <h3 class="text_name">{{translate('Email')}}:</h3>
                                <div class="text_value">
                                    {{$model->email??''}}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between" style="margin-top: 20px;">
                                <h3 class="text_name">{{translate('Company')}}:</h3>
                                <div class="text_value">
                                    {{$model->company->name??''}}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between" style="margin-top: 20px;">
                                <h3 class="text_name">{{translate('Gender')}}:</h3>
                                <div class="text_value">
                                    {{$model->personalInfo->gender==2?translate('female'):translate('male')}}
                                </div>
                            </div>
                        </div>

                        <div style="width: auto;">
                            <div class="d-flex justify-content-between">
                                <h3 class="text_name">{{translate('Full Name')}}:</h3>
                                <div class="text_value">
                                    {{$model->personalInfo->first_name.' '.$model->personalInfo->last_name.' '.$model->personalInfo->middle_name}}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="margin-top: 20px;">
                                <h3 class="text_name">{{translate('Birth date')}}:</h3>
                                @php
                                    if(isset($model->personalInfo->birth_date)){
                                            $birth_date_arr = explode(' ', $model->personalInfo->birth_date);
                                    }else{
                                        $birth_date_arr = [];
                                    }
                                @endphp
                                <div class="text_value">
                                    {{$birth_date_arr[0]}}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="margin-top: 20px;">
                                <h3 class="text_name">{{translate('Update-at')}}:</h3>
                                <div class="text_value">
                                    {{$model->updated_at??''}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: end; width: 100%;">
            <div style="background-color: white; width: 50%; height: 76px; z-index: 4; position: absolute"></div>
        </div>
        <table id="datatable-buttons" class="table dt-responsive nowrap table_show" style="display:none;">
            <thead>
            <tr>
                <th>{{translate('Attributes')}}</th>
                <th>{{translate('Informations')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>{{translate('Role')}}</th>
                <td>{{$model->role->name}}</td>
            </tr>
            <tr>
                <th>{{translate('Company')}}</th>
                <td>{{$model->company->name}}</td>
            </tr>
            <tr>
                <th>{{translate('Full name')}}</th>
                <td>{{$model->personalInfo->first_name.' '.$model->personalInfo->last_name.' '.$model->personalInfo->middle_name}}</td>
            </tr>
            <tr>
                <th>{{translate('Phone number')}}</th>
                <td>{{$model->personalInfo->phone_number}}</td>
            </tr>
            <tr>
                <th>{{translate('Gender')}}</th>
                <td>{{$model->personalInfo->gender??''}}</td>
            </tr>
            <tr>
                <th>{{translate('Birth date')}}</th>
                <td>{{$model->personalInfo->birth_date??''}}</td>
            </tr>
            <tr>
                <th>{{translate('email')}}</th>
                <td>{{$model->email??''}}</td>
            </tr>
            <tr>
                <th>{{translate('Updated at')}}</th>
                <td>{{$model->updated_at??''}}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
