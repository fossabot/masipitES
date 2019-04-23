@extends('layouts.backend.master')
@section('title', 'Add Class')

@section('content')
<div ng-app="classApp" ng-controller="classCtrl as frm">
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
                        <li class="breadcrumb-item"><a href="#">Class</a></li>
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
                    <h5>Add Class</h5>
                </div>
                <div class="card-body">
                    <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="classFrm" ng-submit="frm.create(classFrm.$valid)" autocomplete="off">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Subject</label>
                                <select name="subject" ng-model="frm.subject" id="subject" class="form-control" required>
                                    <option selected="">Select Subject</option>
                                    @if($subjects)
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->description }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grade Level</label>
                                <select name="grade_level" ng-model="frm.grade_level" id="grade_level" class="form-control" required>
                                    <option selected="">Select Grade Level</option>
                                    @if($grade_level)
                                    @foreach($grade_level as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->description }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. of Credits</label>
                                <input type="number" name="credits" ng-model="frm.credits" id="credits" class="form-control" placeholder="No. of credits" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Duration (in weeks)</label>
                                <input type="number" name="weeks" ng-model="frm.weeks" id="weeks" class="form-control" placeholder="No. of weeks" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">School Year</label>
                                <select name="school_year" ng-model="frm.school_year" id="school_year" class="form-control" required>
                                    <option selected="">Select School Year</option>
                                    <option value="2018-2019">2018-2019</option>
                                    <option value="2019-2020">2019-2020</option>
                                    <option value="2021-2022">2021-2022</option>
                                    <option value="2022-2023">2022-2023</option>
                                    <option value="2023-2024">2023-2024</option>
                                    <option value="2024-2025">2024-2025</option>
                                    <option value="2025-2026">2025-2026</option>
                                    <option value="2026-2027">2026-2027</option>
                                    <option value="2027-2028">2027-2028</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea name="description" ng-model="frm.description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" ng-disabled="classFrm.$invalid" id="save_btn" class="btn btn-primary">Save</button>
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
        var classApp = angular.module('classApp', ['angular.filter']);
        classApp.controller('classCtrl', function ($scope, $http, $sce) {

            var vm = this;

            vm.create = function () {
               
               $('#save_btn').prop('disabled', true);
               $('#save_btn').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');

               $http({
                   method: 'POST',
                   url: '/faculty/class/add',
                   data: JSON.stringify({
                        subject: vm.subject,
                        grade_level: vm.grade_level,
                        credits: vm.credits,
                        weeks: vm.weeks,
                        school_year: vm.school_year,
                        description: vm.description,
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

                       setTimeout(window.location.href = '/faculty/class/add', 10000);

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
                                text: data.message,
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