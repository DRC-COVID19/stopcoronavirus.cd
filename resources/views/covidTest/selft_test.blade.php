@extends('covidTest.base')
@section('title', 'Test covid-19')
@section('covid_content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <form method="post" class="question-form" id="question-form" action="{{url()->current()}}">
                <div class="question">
                    <div class="question-header">
                        <a href="{{$backUrl}}">
                            <span class="fa fa-chevron-left"></span>
                            &nbsp;
                            Question {{ $content['id'] }} sur 22
                        </a>
                    </div>
                    <p class="question-title">
                        {{ $content['q'] }}
                    </p>
                    @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="question-options {{$content['r']==9?'d-md-flex justify-content-center align-items-md-center':''}}">
                    <div class="d-flex flex-column justify-content-between {{ $content['r']==9?'col-md-7 col-12':'' }}">
                            @if($content['r']==1 || $content['r']==2 || $content['r']==8)
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-on" name="step_value" value="1" tabindex="1">
                                <label for="input-radio-step_fever-on">
                                    Oui
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-off" name="step_value" value="0" tabindex="2">
                                <label for="input-radio-step_fever-off">
                                    Non
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            @endif
                            @if($content['r']==2 || $content['r']==8)
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-none" name="step_value" value="2" tabindex="3">
                                <label for="input-radio-step_fever-none">
                                    {{ $content['r']==2 ? 'Ne sait pas':'Non applicable'}}
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            @endif

                            @if($content['r']==3)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label"></div>
                                <input id="step_fever_details" class="input-text " type="number" name="step_value" value="" min="34" max="42" step="0.1" placeholder="37,0" required tabindex="1">

                                <label class="custom-text-suffix" for="step_fever_details">degrés</label>
                            </div>
                            @endif

                            @if($content['r']==4)
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-well" name="step_value" value="1" tabindex="1">
                                <label for="input-radio-step_fever-well">
                                    Bien
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-enough" name="step_value" value="2" tabindex="2">
                                <label for="input-radio-step_fever-enough">
                                    Assez bien
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-bad" name="step_value" value="3" tabindex="1">
                                <label for="input-radio-step_fever-bad">
                                    Mal
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-very-bad" name="step_value" value="4" tabindex="2">
                                <label for="input-radio-step_fever-very-bad">
                                    Très mal
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            @endif

                            @if($content['r']==5)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label"></div>
                                <input id="step_age" class="input-text " type="number" name="step_value" value="" min="1" max="110" required="" tabindex="1">

                                <label class="custom-text-suffix" for="step_age">ans</label>
                            </div>
                            @endif

                            @if($content['r']==6)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label">Votre taille</div>
                                <input id="step_height" class="input-text " type="number" name="step_value" value="" min="80" max="250" required="" tabindex="1">

                                <label class="custom-text-suffix" for="step_height">cm</label>
                            </div>
                            @endif

                            @if($content['r']==7)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label">Votre poids</div>
                                <input id="step_weight" class="input-text " type="number" name="step_value" value="" min="20" max="250" required="" tabindex="1">

                                <label class="custom-text-suffix" for="step_weight">kg</label>
                            </div>
                            @endif

                            @if($content['r']==9)
                            <div class="form-group">
                                <label class="custom-text-label" for="province">Dans quelle province habitez vous ?</label>
                                <select class="form-control" name="province">
                                    <option value="Bas-Uele">Bas-Uele</option>
                                    <option value="Equateur">Equateur</option>
                                    <option value="Haut-Katanga">Haut-Katanga</option>
                                    <option value="Haut-Lomami">Haut-Lomami</option>
                                    <option value="Haut-Uele">Haut-Uele</option>
                                    <option value="Ituri">Ituri</option>
                                    <option value="Kasaï">Kasaï</option>
                                    <option value="Kasaï-Central">Kasaï-Central</option>
                                    <option value="Kasaï-Oriental">Kasaï-Oriental</option>
                                    <option selected value="Kinshasa">Kinshasa</option>
                                    <option value="Kongo-Central">Kongo-Central</option>
                                    <option value="Kwango">Kwango</option>
                                    <option value="Kwilu">Kwilu</option>
                                    <option value="Lomami">Lomami</option>
                                    <option value="Lualaba">Lualaba</option>
                                    <option value="Mai-Ndombe">Mai-Ndombe</option>
                                    <option value="Maniema">Maniema</option>
                                    <option value="Mongala">Mongala</option>
                                    <option value="Nord-Kivu">Nord-Kivu</option>
                                    <option value="Nord-Ubangi">Nord-Ubangi</option>
                                    <option value="Sankuru">Sankuru</option>
                                    <option value="Sud-Kivu">Sud-Kivu</option>
                                    <option value="Sud-Ubangi">Sud-Ubangi</option>
                                    <option value="Tanganyika">Tanganyika</option>
                                    <option value="Tshopo">Tshopo</option>
                                    <option value="Tshuapa">Tshuapa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="custom-text-label" for="town">Dans quelle ville habitez vous ?</label>
                                <select class="form-control" name="town" id="town">
                                    <option selected value="Kinshasa">Kinshasa</option>
                                    <option value="Lubumbashi">Lubumbashi</option>
                                    <option value="Mbuji-Mayi">Mbuji-Mayi</option>
                                    <option value="Kananga">Kananga</option>
                                    <option value="Kisangani">Kisangani</option>
                                    <option value="Bukavu">Bukavu</option>
                                    <option value="Tshikapa">Tshikapa</option>
                                    <option value="Kolwezi">Kolwezi</option>
                                    <option value="Likasi">Likasi</option>
                                    <option value="Goma">Goma</option>
                                    <option value="Kikwit">Kikwit</option>
                                    <option value="Uvira">Uvira</option>
                                    <option value="Bunia">Bunia</option>
                                    <option value="Kalemie">Kalemie</option>
                                    <option value="Mbandaka">Mbandaka</option>
                                    <option value="Matadi">Matadi</option>
                                    <option value="Kabinda">Kabinda</option>
                                    <option value="Butembo">Butembo</option>
                                    <option value="Baraka">Baraka</option>
                                    <option value="Mwene-Ditu">Mwene-Ditu</option>
                                    <option value="Isiro">Isiro</option>
                                    <option value="Kindu">Kindu</option>
                                    <option value="Boma">Boma</option>
                                    <option value="Kamina">Kamina</option>
                                    <option value="Gandajika">Gandajika</option>
                                    <option value="Bandundu">Bandundu</option>
                                    <option value="Gemena">Gemena</option>
                                    <option value="Kipushi">Kipushi</option>
                                    <option value="Bumba">Bumba</option>
                                    <option value="Mbanza-Ngungu">Mbanza-Ngungu</option>
                                    <option value="0">Autre</option>
                                </select>
                                <div id="other-town">
                                    <label class="custom-text-label">{{__('Si autre ville')}}</label>
                                    <input type="text" class="input-text form-control" cols="100" rows="100" name="other_town" tabindex="1" />
                                </div>
                            </div>

                            <div class="form-group" id="township">
                                <label class="custom-text-label" for="township">Si vous habitez Kinshasa, dans quelle commune habitez vous ?</label>
                                <select class="form-control" name="township" >
                                    <option value=""></option>
                                    <option value="Bandalungwa">Bandalungwa</option>
                                    <option value="Barumbu">Barumbu</option>
                                    <option value="Bumbu">Bumbu</option>
                                    <option value="Gombe">Gombe</option>
                                    <option value="Kalamu">Kalamu</option>
                                    <option value="Kasa-Vubu">Kasa-Vubu</option>
                                    <option value="Kimbanseke">Kimbanseke</option>
                                    <option value="Kinshasa">Kinshasa</option>
                                    <option value="Kintambo">Kintambo</option>
                                    <option value="Kisenso">Kisenso</option>
                                    <option value="Lemba">Lemba</option>
                                    <option value="Limete">Limete</option>
                                    <option value="Lingwala">Lingwala</option>
                                    <option value="Makala">Makala</option>
                                    <option value="Maluku">Maluku</option>
                                    <option value="Masina">Masina</option>
                                    <option value="Matete">Matete</option>
                                    <option value="Mont-Ngafula">Mont-Ngafula</option>
                                    <option value="Ndjili">Ndjili</option>
                                    <option value="Ngaba">Ngaba</option>
                                    <option value="Ngaliema">Ngaliema</option>
                                    <option value="Ngiri-Ngiri">Ngiri-Ngiri</option>
                                    <option value="Nsele">Nsele</option>
                                    <option value="Selembao">Selembao</option>
                                </select>
                            </div>
                            @endif
                        </div>

                        @if($content['r']==10)
                        <div class="custom-control custom-radio">
                            <input type="radio" id="input-radio-step_fever-1" name="step_value" value="1" tabindex="1">
                            <label for="input-radio-step_fever-1">
                                {{__('Je ne sais pas')}}
                                <span class="hover-border"></span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="input-radio-step_fever-2" name="step_value" value="2" tabindex="2">
                            <label for="input-radio-step_fever-2">
                                {{__('39°C ou plus')}}
                                <span class="hover-border"></span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="input-radio-step_fever-3" name="step_value" value="3" tabindex="2">
                            <label for="input-radio-step_fever-3">
                                {{__('Entre 37,8°C et 38,9°C de température')}}
                                <span class="hover-border"></span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="input-radio-step_fever-4" name="step_value" value="4" tabindex="2">
                            <label for="input-radio-step_fever-4">
                                {{__('Température basse, moins de 35,5°C')}}
                                <span class="hover-border"></span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="input-radio-step_fever-5" name="step_value" value="5" tabindex="2">
                            <label for="input-radio-step_fever-5">
                                {{__("Je n'ai pas eu de fièvre (entre 35,5°C et 37,7°C)")}}
                                <span class="hover-border"></span>
                            </label>
                        </div>
                        @endif
                    </div>
                    <input type="hidden" name="current_step" value="{{$content['id']}}">
                    @csrf

                </div>
            <div class="question-submit d-flex justify-content-center" >

                    <button class="btn btn-secondary" id="question-form-validate-btn" data-response="{{$content['r']}}">
                        Continuer
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
