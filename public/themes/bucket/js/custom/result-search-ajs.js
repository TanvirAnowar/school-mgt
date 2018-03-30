/**
 * Created by sanzeeb on 12-Feb-15.
 */

var requestPath = BASE + 'result-search/';
var reportApp = angular.module('reportApp', ['ui.bootstrap','ngBootbox']);

reportApp.controller('ResultSearchController',
    ['$scope', '$http', '$location', '$anchorScroll', '$modal','$ngBootbox',
        function ($scope, $http, $location, $anchorScroll, $modal,$ngBootbox) {


    // boot box configuration
    $ngBootbox.setDefaults({
        animate: false,
        backdrop: false
    });

    $scope.ajaxModal=function(flag)
    {
       // alert('sdfsdf');
        if(flag == true){
            bootbox.dialog({

            message: '<div style="text-align: center"><img src="'+ BASE +'/public/themes/bucket/images/ajax-loader-new.GIF"  /></div>',
            title: "Content Loading ... ",
            backdrop: true,
            closeButton: false

        });
        }else{
            bootbox.hideAll();
        }
    }

    $scope.emptyDataModal=function()
    {
        bootbox.dialog({

            message: '<div class="bootbox-body-message">No data available to show.</div>',
            title: "Warning ! ",
            backdrop: true,
            closeButton: false,
            buttons: {
                success: {
                    label: "Ok",
                    className: "btn-success",
                    callback: function() {
                        bootbox.hideAll();
                    }
                }
        }
    });
    }




    // hide table and initialize table header list.

    $scope.tableHeads = null;
    $scope.hideTable = true;

    $scope.resultData = [];

    var init = function () {
        // disable unused drop-down controls
        $scope.sectionDisabled = true;
        $scope.subjectDisabled = true;

        // for dynamic table column init
        $scope.tableDataGroup = [];


        $scope.massData = [];
        $scope.currentPage = 1;
        $scope.maxSize = 3;
        $scope.itemsPerPage = 50;
        $scope.bigTotalItems = $scope.massData.length;
        $scope.bigCurrentPage = 1;
        $scope.content = $scope.massData.slice(1, $scope.itemsPerPage);

        $scope.curPage = 0;
        $scope.startOffset = 0;
        $scope.endOffset = 0;

        /// Pagination initialization ////
    };

    init();

    /////////// Pagination //////////


    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function () {
        $scope.curPage = ($scope.bigCurrentPage - 1);
        $scope.startOffset = $scope.curPage * $scope.itemsPerPage;
        $scope.endOffset = ($scope.itemsPerPage * $scope.curPage) + $scope.itemsPerPage;
        $scope.content = $scope.massData.slice($scope.startOffset, $scope.endOffset);
    };


    //////////////// Pagination //////////

    $scope.getSections = function () {

        init();
        //$scope.ajaxModal(true);

        $http({
            url: requestPath + 'get-class-wise-section',
            method: "POST",
            params: {class_id: $scope.classModel}
        }).success(function (data) {

            $scope.sectionDisabled = false;

            //console.log(data.message);
            $scope.sectionList = data;

          //  $scope.ajaxModal(false);

        });

        // console.log('new log');

        $http({
            url: requestPath + 'get-class-wise-subject',
            method: "POST",
            params: {class_id: $scope.classModel}
        }).success(function (data) {

            //$scope.sectionDisabled = false;

            // console.log(data);
            $scope.subjectList = data;
        });

        return false;
    }

    $scope.getSubject = function () {

        // init();

        $http({
            url: requestPath + 'get-class-wise-subject',
            method: "POST",
            params: {class_id: $scope.classModel}
        }).success(function (data) {

            //$scope.sectionDisabled = false;

            // console.log(data);
            $scope.subjectList = data;
        });
        return false;
    }

    $scope.loadStudents = function () {

        $scope.ajaxModal(true);
        $scope.hideTable = true;
        $http({
            url: requestPath + 'get-custom-search-result',
            method: "POST",
            data: {

                session_id: $scope.sessionModel,
                class_id: $scope.classModel,
                section_id: $scope.sectionModel,
                term_id: $scope.termModel,
                search_type: $scope.searchTypeModel,
                subject_id: $scope.subjectModel
            }
        }).success(function (data) {

            $scope.ajaxModal(false);

            if(data.length > 0)
            {

            $scope.hideTable = false;

            $scope.massData = data;

            $scope.bigTotalItems = $scope.massData.length;
            $scope.pageChanged();
            }else{
               // alert('sdf');
                $scope.emptyDataModal();
            }

        });
        return false;
    }


    $scope.searchType = function () {

        //$scope.hideTable = false;
        //var searchType = $scope.searchTypeModel;
        //console.log('sdf'+$scope.searchTypeModel);
        switch ($scope.searchTypeModel) {
            case 'position-in-class':
            {
                $scope.tableHeads = ['Position', 'Name', 'Role', 'Section', 'Total', 'CGPA'];
                $scope.hideTable = true;
                $scope.sectionDisabled = true;
                $scope.showTableBody('position-in-class');
            }
                break;
            case 'position-section':
            {
                $scope.tableHeads = ['Position', 'Name', 'Role', 'Section', 'Total', 'CGPA'];
                $scope.hideTable = true;
                $scope.getSections();
                $scope.showTableBody('position-section');
            }
                break;
            case 'all-passed-student':
            {
                $scope.tableHeads = ['Name', 'Role', 'Section', 'Total', 'CGPA'];
                $scope.hideTable = true;
                $scope.getSections();
                $scope.showTableBody('all-passed-student');
            }
                break;
            case 'all-failed-student':
            {
                $scope.tableHeads = ['Name', 'Role', 'Section', 'Total'];
                $scope.hideTable = true;
                $scope.getSections();
                $scope.showTableBody('all-failed-student');
            }
                break;
            case 'passed-in-subject':
            {
                $scope.tableHeads = ['Name', 'Role', 'Section', 'Number', 'GPA'];
            }
                break;
            case 'failed-in-subject':
            {
                $scope.tableHeads = ['Name', 'Role', 'Section', 'Number'];
            }
                break;
            case 'gpa-per-subject':
            {
                $scope.tableHeads = ['Name', 'Role', 'Section', 'Number'];
            }
                break;
            case 'cgpa':
            {
                $scope.tableHeads = ['Name', 'Role', 'Section', 'Number'];
            }
                break;
            default:
        }


    }

    $scope.showTableBody = function(bodyName)
    {

        $scope.tableDataGroup['position-in-class'] = false;
        $scope.tableDataGroup['position-section'] = false;
        $scope.tableDataGroup['all-passed-student'] = false;
        $scope.tableDataGroup['all-failed-student'] = false;
        $scope.tableDataGroup['passed-in-subject'] = false;
        $scope.tableDataGroup['failed-in-subject'] = false;
        $scope.tableDataGroup['gpa-per-subject'] = false;
        $scope.tableDataGroup['cgpa'] = false;

        if($scope.tableDataGroup.hasOwnProperty(bodyName))
        {
            $scope.tableDataGroup[bodyName] = true;
        }

      //  console.log(tableDataGroup.length);
/*
        var tmp = 'position-in-clafss';

        console.log(tableDataGroup.hasOwnProperty(tmp));
        console.log(tableDataGroup[tmp]);
        tableDataGroup[tmp] = true;
        console.log(tableDataGroup[tmp]);
*/

    }


}]);