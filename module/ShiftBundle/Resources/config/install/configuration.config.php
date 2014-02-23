<?php

return array(
    array(
        'key'         => 'shift.signout_treshold',
        'value'       => 'P1D',
        'description' => 'The date interval after which a person cannot sign out from a shift',
    ),
    array(
        'key'         => 'shift.responsible_signout_treshold',
        'value'       => 'PT12H',
        'description' => 'The date interval after which a responsible cannot be signed out from a shift',
    ),
    array(
        'key'         => 'shift.mail',
        'value'       => 'it@vtk.be',
        'description' => 'The mail address from which shift notifications are sent',
    ),
    array(
        'key'         => 'shift.mail_name',
        'value'       => 'VTK IT',
        'description' => 'The name of the mail address from which shift notifications are sent',
    ),
    array(
        'key'         => 'shift.praesidium_removed_mail',
        'value'       => serialize(
            array(
                'en' => array(
                    'subject' => 'Shift Signout',
                    'content' => 'Dear,

You have been removed from the following shift by a non-praesidium volunteer:
{{ shift }}

-- This is an automatically generated email, please do not reply --'
                ),
                'nl' => array(
                    'subject' => 'Shift Afmelding',
                    'content' => 'Beste,

U bent verwijderd van de volgende shift door een niet-praesidium vrijwilliger:
{{ shift }}

-- Dit is een automatisch gegenereerde email, gelieve niet te antwoorden --'
                ),
            )
        ),
        'description' => 'The mail sent to a praesidium member when a volunteer removes him from a shift.',
    ),
    array(
        'key'         => 'shift.shift_deleted_mail',
        'value'       => serialize(
            array(
                'en' => array(
                    'subject' => 'Shift Deleted',
                    'content' => 'Dear,

The following shift to which you were subscribed has been deleted:
{{ shift }}

-- This is an automatically generated email, please do not reply --'
                ),
                'nl' => array(
                    'subject' => 'Shift Verwijderd',
                    'content' => 'Beste,

De volgende shift waar je was op ingeschreven is verwijderd:
{{ shift }}

-- Dit is een automatisch gegenereerde email, gelieve niet te antwoorden --'
                ),
            )
        ),
        'description' => 'The mail sent to a shift subscriber when the shift is deleted.',
    ),
    array(
        'key'         => 'shift.subscription_deleted_mail',
        'value'       => serialize(
            array(
                'en' => array(
                    'subject' => 'Shift Signout',
                    'content' => 'Dear,

You have been removed from the following shift by an administrator:
{{ shift }}

-- This is an automatically generated email, please do not reply --'
                ),
                'nl' => array(
                    'subject' => 'Shift Afmelding',
                    'content' => 'Beste,

U bent verwijderd van de volgende shift door een administrator:
{{ shift }}

-- Dit is een automatisch gegenereerde email, gelieve niet te antwoorden --'
                ),
            )
        ),
        'description' => 'The mail sent to a shift subscriber when he is removed from the shift.',
    ),
    array(
        'key'         => 'shift.pdf_generator_path',
        'value'       => 'data/shift/pdf_generator',
        'description' => 'The path to the PDF generator files',
    ),
    array(
        'key'         => 'shift.ranking_criteria',
        'value'       => serialize(
            array(
                array(
                    'name' => 'silver',
                    'limit' => '10'
                ),
                array(
                    'name' => 'gold',
                    'limit' => '20'
                ),
            )
        ),
        'description' => 'The ranking criteria for volunteers',
    ),
    array(
        'key'         => 'shift.icalendar_uid_suffix',
        'value'       => 'shift.vtk.be',
        'description' => 'The suffix of an iCalendar shift uid',
    ),
);