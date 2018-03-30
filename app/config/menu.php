<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/18/14
 * Time: 5:40 PM
 */

return array(
    'Dashboard' => array(
        'route' => 'dashboard',
        'icon'  => 'fa-dashboard',
        'access' => 'Admin | Student | Teacher'
    ),

    'Sync' => array(
      'route' => 'sync',
      'icon'  => 'fa-exchange',
       'child' => array(
         /*'Sync DB' => array('route'=>'sync/index', 'access' => 'Admin'),*/
         'Import Student' => array('route'=>'sync/import-student', 'access' => 'Admin')
       ),
      'access' => 'Admin'
    ),

    'My Profile' => array(
      'route' => 'profile',
      'access' => 'Student | Teacher',
      'icon'  => 'fa-user'
    ),

    'Student' => array(
        'route' => 'student',
        'access' => 'Admin',
        'child' => array(
            'Admit Form' => array('route'=>'student/admit-form', 'access'=>'Admin'),
            'Admission List' => array('route'=>'student/admit-list', 'access'=>'Admin'),
            'Add Student' => array('route'=>'student/add', 'access'=>'Admin'),
            'Students List' => array('route'=>'student/lists', 'access'=>'Admin'),
            'Search' => array('route'=>'student/search', 'access'=>'Admin'),
            'Register' => array('route'=> 'student/registered-students', 'access'=>'Admin'),

        ),
        'icon'  => 'fa-user'
    ),

    'Teacher' => array(
        'route' => 'teacher',
        'access' => 'Admin',
        'child' => array(
            'Teachers List' => array('route' => 'teacher/lists', 'access'=>'Admin'),
            'Search' => array('route'=>'teacher/search', 'access'=>'Admin'),
        ),
        'icon'  => 'fa-user'
    ),

    'Activities' => array(
        'route' => 'activities',
        'access' => 'Admin',
        'child' => array(
          'Assign Mark' => array('route' => 'activities/mark', 'access'=>'Admin'),
          'Course Plan' => array('route' => 'activities/course-plan', 'access'=>'Admin'),
          'Task' => array('route' => 'activities/tasks', 'access'=>'Admin'),
          'Attendance'  => array('route' => 'activities/attendance', 'access'=>'Admin'),
          'Upload Attendance Sheet' => array('route' => 'activities/automatic-attendance', 'access'=>'Admin'),
        ),
        'icon'  => 'fa-tasks'
    ),

    'Finance' => array(
        'route' => 'finance',
        'access'=>'Admin | Teacher | Student',
        'child' => array(
          'Heads' => array('route' => 'finance/head','access'=>'Admin'),
          /*'Accounts' => array('route'=> 'finance/account','access'=>'Admin'),*/
            'Finance Groups' => array('route'=>'transaction-settings/index','access'=>'Admin'),
          'Students' => array('route'=> 'finance/students','access'=>'Admin'),
          'Teachers' => array('route'=> 'finance/teachers','access'=>'Admin'),
          'Transactions' => array('route' => 'finance/transactions','access'=>'Admin | Teacher | Student'),
          'Report' => array('route' => 'finance/income-statement/','access'=>'Admin')

        ),
        'icon' => 'fa-usd'
    ),

    'SMS' => array(
        'route' => 'sms',
        'access'=>'Admin',
        'child' => array(
            'Groups' => array('route'=>'sms/groups','access'=>'Admin'),
            'Send SMS Notice' => array('route'=>'sms/notice','access'=>'Admin'),
            'SMS Result' => array('route'=>'sms/sms-result','access'=>'Admin'),
        ),
        'icon'  => 'fa-tablet'
    ),

    'School Settings' => array(
        'route' => 'school',
        'access'=>'Admin',
        'child' => array(
            'Organization' => array('route' => 'school/org-info','access'=>'Admin'),
            'Class' => array('route'=>'school/classes','access'=>'Admin'),
            'Shift & Group' => array('route' => 'school/shift-group','access'=>'Admin'),
            'Section' => array('route' => 'school/section','access'=>'Admin'),
            'Subject' => array('route' => 'school/subject','access'=>'Admin'),
            'Teacher Assign' => array('route'=>'school/teacher-assign','access'=>'Admin'),
            'Period' => array('route' => 'school/period','access'=>'Admin'),
            'Class Routine' => array('route' => 'school/routine','access'=>'Admin'),
            'Total Class' => array('route' => 'school/total-class','access'=>'Admin'),
            'General' => array('route' => 'school/general','access'=>'Admin')
        ),
        'icon'  => 'fa-gear'
    ),

    'Exam and Mark Settings' => array(
        'route' => 'settings',
        'access'=>'Admin',
        'child' => array(
            'Exam Rules' => array('route' =>'settings/exam-rules','access'=>'Admin'),
            'Mark Type Settings' => array('route' =>'settings/mark-type','access'=>'Admin'),
            'Mark Settings' => array('route' =>'settings/mark','access'=>'Admin'),
            'Combine Mark Settings' => array('route' =>'settings/combine-mark','access'=>'Admin'),
            'Additional Settings' => array('route' =>'settings/additional','access'=>'Admin'),
            'Grade Settings' => array('route' =>'settings/grades','access'=>'Admin'),
            'Result Publish' => array('route' =>'settings/result-publish','access'=>'Admin'),
        ),
        'icon'  => 'fa-cogs'
    ),

    'Report' => array(
      'route' => 'report',
      'access' => 'Admin',
      'child' => array(
          'Student Wise Report' => array('route'=>'report/student','access'=>'Admin'),
          'Tabulation' => array('route'=>'report/tabulation','access'=>'Admin'),
          'Custom Result Search' => array('route'=>'result-search/','access'=>'Admin')
      ),
      'icon' =>'fa-report'

    ),

    'My Report Card' => array(
        'route'=>'report/card',
        'access' => 'Student',
        'icon' => 'fa-bar-chart-o'
    ),

    'My Attendance' => array(
        'route'  => 'profile/attendance',
        'access' => 'Student',
        'icon'   => 'fa-table'
    ),

    'My Subjects'  => array(
        'route'  => 'profile/subjects',
        'access' => 'Teacher',
        'icon'   => 'fa-book'
    ),

    'Templates' => array(
      'route' => 'templates',
      'access' => 'Admin',
      'child' => array(),
       'icon' => 'fa-file-o'
    ),

    'User' => array(
        'route' => 'users',
        'access' => 'Admin',
        'child' => array(
            /*'Permission' => array('route' => 'users/permission','access'=>'Admin'),*/
            /*'User Role' => array('route' => 'users/role','access'=>'Admin')*/
            'User' => array('route' => 'users/index','access'=>'Admin'),
        ),
        'icon' => 'fa-user'
    )
);