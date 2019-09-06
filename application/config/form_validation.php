<?php

$config = array(
    'login' => array(
        array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
        ),
        array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
        )
    ),
    'ragister' => array(
        array(
                'field' => 'firstname',
                'label' => 'Firstname',
                'rules' => 'required|min_length[3]'
        ),
        array(
                'field' => 'lastname',
                'label' => 'Lastname',
                'rules' => 'required|min_length[3]'
        ),
        array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
        ),
        array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
        ),
        array(
                'field' => 'passwordcc',
                'label' => 'Conform Password',
                'rules' => 'required|matches[password]'
        )
        ),
        'forgot' => array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|valid_email'
                ),
                array(
                        'field' => 'firstname',
                        'label' => 'Firstname',
                        'rules' => 'required|alpha'
                )
        ),
        'Reset' => array(
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'passwordcc',
                        'label' => 'Conform Password',
                        'rules' => 'required|matches[password]'
                )
        ),
);