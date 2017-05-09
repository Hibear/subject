<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(
    'menu' => array(

        '报名管理' => array(
            'code' => 'sign_manage',
            'icon' => 'icon-asterisk menu-i',
            'list' => array(
                array(
                    'url'=>'/moteusers',
                   'name'=> '模特报名人员',
                   'active'=> 'mote_list'
                )
            )
        ),

//         'H5后台数据' => array(
//             'code' => 'question_manage',
//             'icon' => 'icon-asterisk menu-i',
//             'list' => array(
//                 array(
//                    'url'=>'/questionusers',
//                    'name'=> '调查参与人员',
//                    'active'=> 'question_list'
//                 )
//             ),
// 		),

//         '管理员管理' => array(
//             'code' => 'admin_user_manage',
//             'icon' => 'glyphicon glyphicon-user menu-i',
//             'list' => array(
//                 array(
//                     'url' => '/admin',
//                     'name' => '管理员列表',
//                     'active' => 'admin_list'
//                 )
//             ) 
//         )  
    ) 
);