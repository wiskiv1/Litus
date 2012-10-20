<?php
/**
 * Litus is a project by a group of students from the K.U.Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Niels Avonds <niels.avonds@litus.cc>
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */

namespace SportBundle\Controller\Admin;

use CommonBundle\Entity\General\Language;

/**
 * InstallController
 *
 * @author Pieter Maene <pieter.maene@litus.cc>
 */
class InstallController extends \CommonBundle\Component\Controller\ActionController\InstallController
{
    protected function initConfig()
    {
        $this->installConfig(
            array(
                array(
                    'key'         => 'sport.run_result_page',
                    'value'       => 'http://media.24u.ulyssis.org/live/tussenstand.xml',
                    'description' => 'The URL of the page where the XML of the official results is published',
                ),
                array(
                    'key'         => 'sport.run_team_id',
                    'value'       => '4',
                    'description' => 'The ID of the organization on the official result page',
                ),
                array(
                    'key'         => 'sport.queue_socket_port',
                    'value'       => '8897',
                    'description' => 'The port used for the websocket of the queue',
                ),
                array(
                    'key'         => 'sport.queue_socket_remote_host',
                    'value'       => '127.0.0.1',
                    'description' => 'The remote host for the websocket of the queue',
                ),
                array(
                    'key'         => 'sport.queue_socket_host',
                    'value'       => '127.0.0.1',
                    'description' => 'The host used for the websocket of the queue',
                ),
            )
        );
    }

    protected function initAcl()
    {
        $this->installAcl(
            array(
                'sportbundle' => array(
                    'admin_run' => array(
                        'delete', 'groups', 'next', 'queue'
                    ),
                    'run_group' => array(
                        'add', 'getName'
                    ),
                    'run_index' => array(
                        'index'
                    ),
                    'run_queue' => array(
                        'index', 'getName'
                    ),
                    'run_screen' => array(
                        'index'
                    ),
                ),
            )
        );

        $this->installRoles(
            array(
                'guest' => array(
                    'system' => true,
                    'parents' => array(
                    ),
                    'actions' => array(
                        'run_group' => array(
                            'add', 'getName'
                        ),
                        'run_index' => array(
                            'index'
                        ),
                    ),
                ),
            )
        );
    }
}