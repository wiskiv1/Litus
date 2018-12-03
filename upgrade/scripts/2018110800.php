<?php
/**
 * Litus is a project by a group of students from the KU Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Niels Avonds <niels.avonds@litus.cc>
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Koen Certyn <koen.certyn@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Dario Incalza <dario.incalza@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Lars Vierbergen <lars.vierbergen@litus.cc>
 * @author Daan Wendelen <daan.wendelen@litus.cc>
 * @author Mathijs Cuppens <mathijs.cuppens@litus.cc>
 * @author Floris Kint <floris.kint@vtk.be>
 *
 * @license http://litus.cc/LICENSE
 */

updateConfigDescription($connection, 'sport.queue_socket_file', 'The file used for the WebSocket of the queue');
updateConfigDescription($connection, 'sport.queue_socket_public', 'The public address for the WebSocket of the queue');
updateConfigDescription($connection, 'sport.queue_socket_key', 'The public address for the WebSocket of the queue');

updateConfigDescription($connection, 'syllabus.update_socket_file', 'The file used for the WebSocket of the syllabus update');
updateConfigDescription($connection, 'syllabus.update_socket_public', 'The public address for the WebSocket of the syllabus update');
updateConfigDescription($connection, 'syllabus.update_socket_key', 'The key used for the WebSocket of the queue');

updateConfigDescription($connection, 'cudi.queue_socket_file', 'The file used for the WebSocket of the queue');
updateConfigDescription($connection, 'cudi.queue_socket_public', 'The public address for the WebSocket of the queue');
updateConfigDescription($connection, 'cudi.queue_socket_key', 'The key used for the WebSocket of the queue');