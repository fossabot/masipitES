@extends('layouts.backend.master')
@section('title', 'Edit Grade Level')

@section('content')
<div ng-app="settingsApp" ng-controller="settingsCtrl as frm">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">MasipitES</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Grade Level</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Grade Level</h5>
                </div>
                <div class="card-body">
                    <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="settingsFrm" ng-submit="frm.update(settingsFrm.$valid)" autocomplete="off">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Level</label>
                                <input type="text" name="level" ng-model="frm.level" ng-init="frm.level='{{ $getgrade_level->level }}'" id="level" class="form-control" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea name="description" ng-model="frm.description" ng-init="frm.description='{{ $getgrade_level->description }}'" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" ng-disabled="settingsFrm.$invalid" id="save_btn" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Form Validation ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>
@endsection
@section('footer_scripts')
<script>
    (function () {
        var settingsApp = angular.module('settingsApp', ['angular.filter']);
        settingsApp.controller('settingsCtrl', function ($scope, $http, $sce) {

            var vm = this;

            var grade_level_id = '{{$getgrade_level->id}}';

            vm.update = function () {
               
               $('#save_btn').prop('disabled', true);
               $('#save_btn').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');

               $http({
                   method: 'POST',
                   url: '/admin/settings/grade/'+grade_level_id+'/edit',
                   data: JSON.stringify({
                        level: vm.level,
                        description: vm.description
                   })
               }).success(function (data) {
                   $('#save_btn').prop('disabled', false);
                   $('#save_btn').html('Save');
                   if (data.result == 1){

                        new PNotify({
                            title: 'Success',
                            text: data.message,
                            type: 'success'
                        });

                       setTimeout(window.location.href = '/admin/settings/grade-level', 10000);

                   } else {
                        new PNotify({
                            title: 'Warning',
                            text: 'Something went wrong. Please try again!',
                            type: 'default'
                        });
                   }
               }).error(function (data) {

                   $('#save_btn').prop('disabled', false);
                   $('#save_btn').html('Save');

                   if(data.result == 0){

                        new PNotify({
                            title: 'Warning',
                            text: data.message,
                            type: 'default'
                        });

                   } else {
                       
                        angular.forEach(data.errors, function(message, key){

                            new PNotify({
                                title: 'Warning',
                                text: message,
                                type: 'default'
                            });

                       });
                   }
               });
           };
            
        });
    })();

</script>

@stop