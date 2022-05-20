@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('appearance-setting.store')}}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">     
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Image")}}</label>
                            <div class="col-md-9">
                                <img src="{{ asset(getAppearance()->image ?? 'public/img/user/default.png') }}" width="150" id="image_preview">
                                <input style="display: none;" type='file' id="image" name="image"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Language")}}</label>
                            <div class="col-md-9">
                                <select name="language" class="custom-select">
                                    <option value="en" @if(($data->language ?? 'en') == 'en') selected @endif>English</option>
                                    <option value="id" @if(($data->language ?? 'en') == 'id') selected @endif>Bahasa Indonesia</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("General") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="true">{{ __("Sidebar") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab3" role="tab" aria-selected="true">{{ __("Navbar") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-2">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Layout")}}</label>
                                            <div class="col-md-9">
                                                <select name="layout" class="custom-select">
                                                    <option value="sidebar-mini" @if(($data->layout ?? 'sidebar-mini') == 'sidebar-mini') selected @endif>Side Bar</option>
                                                    <option value="layout-top-nav" @if(($data->layout ?? 'sidebar-mini') == 'layout-top-nav') selected @endif>Top Bar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Dark Mode")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="dark_mode" value="1" @if(($data->dark_mode ?? '0') == '1') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Footer Fixed")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="footer_fixed" value="1" @if(($data->footer_fixed ?? '1') == '1') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Small Text")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="small_text" value="1" @if(($data->small_text ?? '1') == '1') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Sidebar Fixed")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="sidebar_fixed" value="1" @if(($data->sidebar_fixed ?? '1') == '1') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label required">{{__("Sidebar Theme")}}</label>
                                            <div class="col-md-9">
                                                <select name="sidebar_theme" class="custom-select">
                                                    <option value="light" @if(($data->sidebar_theme ?? 'dark') == 'light') selected @endif>{{__('Light')}}</option>
                                                    <option value="dark" @if(($data->sidebar_theme ?? 'dark') == 'dark') selected @endif>{{__('Dark')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label required">{{__("Sidebar Variant")}}</label>
                                            <div class="col-md-9">
                                                <select name="sidebar_variant" class="custom-select">
                                                    <option class="bg-white" value="white" @if(($data->sidebar_variant ?? 'primary') == 'white') selected @endif>White</option>
                                                    <option class="bg-primary" value="primary" @if(($data->sidebar_variant ?? 'primary') == 'primary') selected @endif>Primary</option>
                                                    <option class="bg-warning" value="warning" @if(($data->sidebar_variant ?? 'primary') == 'warning') selected @endif>Warning</option>
                                                    <option class="bg-info" value="info" @if(($data->sidebar_variant ?? 'primary') == 'info') selected @endif>Info</option>
                                                    <option class="bg-danger" value="danger" @if(($data->sidebar_variant ?? 'primary') == 'danger') selected @endif>Danger</option>
                                                    <option class="bg-success" value="success" @if(($data->sidebar_variant ?? 'primary') == 'success') selected @endif>Success</option>
                                                    <option class="bg-indigo" value="indigo" @if(($data->sidebar_variant ?? 'primary') == 'indigo') selected @endif>Indigo</option>
                                                    <option class="bg-lightblue" value="lightblue" @if(($data->sidebar_variant ?? 'primary') == 'lightblue') selected @endif>Lightblue</option>
                                                    <option class="bg-navy" value="navy" @if(($data->sidebar_variant ?? 'primary') == 'navy') selected @endif>Navy</option>
                                                    <option class="bg-purple" value="purple" @if(($data->sidebar_variant ?? 'primary') == 'purple') selected @endif>Purple</option>
                                                    <option class="bg-fuchsia" value="fuchsia" @if(($data->sidebar_variant ?? 'primary') == 'fuchsia') selected @endif>Fuchsia</option>
                                                    <option class="bg-pink" value="pink" @if(($data->sidebar_variant ?? 'primary') == 'pink') selected @endif>Pink</option>
                                                    <option class="bg-maroon" value="maroon" @if(($data->sidebar_variant ?? 'primary') == 'maroon') selected @endif>Maroon</option>
                                                    <option class="bg-orange" value="orange" @if(($data->sidebar_variant ?? 'primary') == 'orange') selected @endif>Orange</option>
                                                    <option class="bg-lime" value="lime" @if(($data->sidebar_variant ?? 'primary') == 'lime') selected @endif>Lime</option>
                                                    <option class="bg-teal" value="teal" @if(($data->sidebar_variant ?? 'primary') == 'teal') selected @endif>Teal</option>
                                                    <option class="bg-olive" value="olive" @if(($data->sidebar_variant ?? 'primary') == 'olive') selected @endif>Olive</option>
                                                    <option class="bg-dark" value="dark" @if(($data->sidebar_variant ?? 'primary') == 'dark') selected @endif>Dark</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label required">{{__("Sidebar Elevation")}}</label>
                                            <div class="col-md-9">
                                                <input type="text" name="sidebar_elevation" class="form-control required" value="{{$data->sidebar_elevation ?? '1'}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Sidebar Style")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="sidebar_flat" value="1" @if(($data->sidebar_flat ?? '0') == '1') checked @endif>
                                                    <label class="form-check-label">{{__('Flat Style')}}</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="sidebar_legacy" value="1" @if(($data->sidebar_legacy ?? '0') == '1') checked @endif>
                                                    <label class="form-check-label">{{__('Legacy Style')}}</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="sidebar_indent" value="1" @if(($data->sidebar_indent ?? '1') == '1') checked @endif>
                                                    <label class="form-check-label">{{__('Child Indent')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Navbar Fixed")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="navbar_fixed" value="1" @if(($data->navbar_fixed ?? '1') == '1') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">{{__("Navbar Show Icon")}}</label>
                                            <div class="col-md-9">
                                                <div class="form-check pt-2">
                                                    <input class="form-check-input" type="checkbox" name="navbar_show_icon" value="1" @if(($data->navbar_show_icon ?? '0') == '1') checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label required">{{__("Navbar Theme")}}</label>
                                            <div class="col-md-9">
                                                <select name="navbar_theme" class="custom-select">
                                                    <option value="light" @if(($data->navbar_theme ?? 'light') == 'light') selected @endif>{{__('Light')}}</option>
                                                    <option value="dark" @if(($data->navbar_theme ?? 'light') == 'dark') selected @endif>{{__('Dark')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label required">{{__("Navbar Variant")}}</label>
                                            <div class="col-md-9">
                                                <select name="navbar_variant" class="custom-select">
                                                    <option class="bg-white" value="white" @if(($data->navbar_variant ?? 'white') == 'white') selected @endif>White</option>
                                                    <option class="bg-primary" value="primary" @if(($data->navbar_variant ?? 'white') == 'primary') selected @endif>Primary</option>
                                                    <option class="bg-warning" value="warning" @if(($data->navbar_variant ?? 'white') == 'warning') selected @endif>Warning</option>
                                                    <option class="bg-info" value="info" @if(($data->navbar_variant ?? 'white') == 'info') selected @endif>Info</option>
                                                    <option class="bg-danger" value="danger" @if(($data->navbar_variant ?? 'white') == 'danger') selected @endif>Danger</option>
                                                    <option class="bg-success" value="success" @if(($data->navbar_variant ?? 'white') == 'success') selected @endif>Success</option>
                                                    <option class="bg-indigo" value="indigo" @if(($data->navbar_variant ?? 'white') == 'indigo') selected @endif>Indigo</option>
                                                    <option class="bg-lightblue" value="lightblue" @if(($data->navbar_variant ?? 'white') == 'lightblue') selected @endif>Lightblue</option>
                                                    <option class="bg-navy" value="navy" @if(($data->navbar_variant ?? 'white') == 'navy') selected @endif>Navy</option>
                                                    <option class="bg-purple" value="purple" @if(($data->navbar_variant ?? 'white') == 'purple') selected @endif>Purple</option>
                                                    <option class="bg-fuchsia" value="fuchsia" @if(($data->navbar_variant ?? 'white') == 'fuchsia') selected @endif>Fuchsia</option>
                                                    <option class="bg-pink" value="pink" @if(($data->navbar_variant ?? 'white') == 'pink') selected @endif>Pink</option>
                                                    <option class="bg-maroon" value="maroon" @if(($data->navbar_variant ?? 'white') == 'maroon') selected @endif>Maroon</option>
                                                    <option class="bg-orange" value="orange" @if(($data->navbar_variant ?? 'white') == 'orange') selected @endif>Orange</option>
                                                    <option class="bg-lime" value="lime" @if(($data->navbar_variant ?? 'white') == 'lime') selected @endif>Lime</option>
                                                    <option class="bg-teal" value="teal" @if(($data->navbar_variant ?? 'white') == 'teal') selected @endif>Teal</option>
                                                    <option class="bg-olive" value="olive" @if(($data->navbar_variant ?? 'white') == 'olive') selected @endif>Olive</option>
                                                    <option class="bg-dark" value="dark" @if(($data->navbar_variant ?? 'white') == 'dark') selected @endif>Dark</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label required">{{__("Navbar Border")}}</label>
                                            <div class="col-md-9">
                                                <input type="text" name="navbar_border" class="form-control required" value="{{$data->navbar_border ?? 1}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btn-store-multipart"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection