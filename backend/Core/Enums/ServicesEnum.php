<?php

namespace Flow\Core\Enums;

enum ServicesEnum: string
{
    case Id = 'ID';
    case Notification = 'NOTIFICATION';
    case Events = 'EVENTS';
    case Helpcenter = 'HELPCENTER';
    case Workflow = 'WORKFLOW';
    case Workflow_edocument = "WORKFLOW_EDOCUMENT";
}
