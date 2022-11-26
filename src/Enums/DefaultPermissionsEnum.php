<?php

namespace HadiHeydarzade89\QuestionAndAnswer\Enums;

enum DefaultPermissionsEnum: string
{
    case CREATE_QUESTION = 'create question';
    case SHOW_QUESTION = 'show question';
    case UPDATE_QUESTION = 'update question';
    case LIST_OF_QUESTION = 'list of question';
    case DELETE_OWN_QUESTION = 'delete own question';
    case DELETE_QUESTION = 'delete question';
    case CREATE_ANSWER = 'create answer';
    case SHOW_ANSWER = 'show answer';
    case UPDATE_ANSWER = 'update answer';
    case LIST_OF_ANSWER = 'list of answers';
    case DELETE_OWN_ANSWER = 'delete own answer';
    case DELETE_ANSWER = 'delete answer';
    case UPDATE_USER = 'update user';
    case CREATE_USER = 'create user';
}
